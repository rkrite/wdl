<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Models\Word;

class WordController extends Controller
{
    // ==============================
    // Display the current word stuff
    // ==============================
    public function show()
    {
        /*  word = HELLO
            map[0] = [
                        'letters'=>['A','G','i','L','E']
                        'marks'=>['x','x','x','g','y']
                    ]
            map[1] = [
                        'letters'=>['S','O','U','N','D']
                        'marks'=>['x','y','x','x','x']
                    ]
         */
        $wordmaps = GGetWordMap();
        $foundwords = [];
        $wsql = '';
        if (!empty($wordmaps)){
            foreach ($wordmaps as $wordmap) {
                $letters = $wordmap['letters'];
                $marks = $wordmap['marks'];
                $i = 0;
                foreach ($letters as $letter) {
                    $mark = $marks[$i];
                    switch ($mark) {
                        case 'x':
                            // Black (bad)
                            $wsql .= " and c0" . $i . " != '" . $letter . "' ";
                            break;
                        case 'g':
                            // Green (good char good pos)
                            $wsql .= " and c0" . $i . " = '" . $letter . "' ";
                            break;
                        case 'y':
                            // Yellow (good char bad pos)
                            $wsql .= " and c0" . $i . " != '" . $letter . "' ";
                            $wsql .= " and word like '%" . $letter . "%' ";
                            break;
                        default:
                            break;
                    }
                    $i++;
                }

            }

            $sql = 'select word from words where 1=1 ' . $wsql . ' limit 10 ';
            $foundwords = GExecSqlRaw ($sql);
        }
        while (count($wordmaps) < 5){
            $wordmaps[] = ['letters'=>['','','','',''],'marks'=>['','','','','']];
        }
        return view('show')->with('wordmaps', $wordmaps)->with('foundwords', $foundwords);
    } // show

    // ==============================
    // capture the entered row of letters into the session word map
    // ==============================
    public function enter(Request $request)
    {
        /*  word = HELLO
            $letters = AGILE, $marks = xxxgy
            $letters = SOUND, $marks = xyxxx
         */
        GClearWordMap();
        for($rowidx=0;$rowidx<6;$rowidx++){
            $vLetters = '';
            $vMarks = '';
            for($colidx=0;$colidx<5;$colidx++){
                $idx = 'word_' . $rowidx . '_letter_' . $colidx;

                $vLetter = $request[$idx];
                $vMark = $request['val_' . $idx];

                $vLetters .= $vLetter;
                $vMarks .= $vMark;
            }
            GSetWordMap($vLetters, $vMarks);
        }

        return redirect()->route('word.show');
        // return $this->show();
    } // enter

    // ==============================
    // Clear the current word stuff
    // ==============================
    public function clear()
    {
        GClearWordMap();
        return $this->show();
    } // clear

}
