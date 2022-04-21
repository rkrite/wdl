<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
        $numletters = 5;
        $numwords = 6;
        $wordmaps = GGetWordMap();
        $foundwords = [];
        $wsql = '';
        $usedLetters = [];
        $br = "\n";
        if (!empty($wordmaps)){
            foreach ($wordmaps as $wordmap) {
                $letters = $wordmap['letters'];
                $marks = $wordmap['marks'];
                $i = 0;
                foreach ($letters as $letter) {
                    if (!empty($letter)){
                        $mark = $marks[$i];
                        switch ($mark) {
                            case 'x':
                                // Black (bad)
                                $usedLetters[$letter]['c0' . ($i+1)]='x';
                                $wsql .= " and c0" . ($i+1) . " != '" . $letter . "' " . $br;
                                break;
                            case 'g':
                                // Green (good char good pos)
                                $usedLetters[$letter]['c0' . ($i+1)]='g';
                                $wsql .= " and c0" . ($i+1) . " = '" . $letter . "' " . $br;
                                break;
                            case 'y':
                                // Yellow (good char bad pos)
                                $usedLetters[$letter]['c0' . ($i+1)]='y';
                                $wsql .= " and c0" . ($i+1) . " != '" . $letter . "' " . $br;
                                $wsql .= " and word like '%" . $letter . "%' " . $br;
                                break;
                            default:
                                break;
                        }
                    }
                    $i++;
                }
            }

            foreach ($usedLetters as $letter => $rule) {
                $hasX = [];
                $hasY = [];
                $hasG = [];
                foreach ($rule as $col => $mark) {
                    if ($mark == 'x'){
                        $hasX[$col] = $mark;
                    }
                    if ($mark == 'y'){
                        $hasY[$col] = $mark;
                    }
                    if ($mark == 'g'){
                        $hasG[$col] = $mark;
                    }
                }

                if ($hasY){
                    foreach ($hasY as $col => $mark) {
                        $wsql .= " and " . $col . " != '" . $letter . "' " . $br;
                        $wsql .= " and word like '%" . $letter . "%' " . $br;
                    }
                }
                if ($hasG){
                    foreach ($hasG as $col => $mark) {
                        $wsql .= " and " . $col . " = '" . $letter . "' " . $br;
                    }
                }
                if ($hasX){
                    foreach ($hasX as $col => $mark) {
                        $wsql .= " and " . $col . " != '" . $letter . "' " . $br;
                    }
                    if ($hasG){
                        $i = 0;
                        for ($i=0;$i<$numletters;$i++){
                            if (!array_key_exists('c0' . ($i+1), $hasG)){
                                $wsql .= " and " . 'c0' . ($i+1) . " != '" . $letter . "' " . $br;
                            }
                        }

                    } else {
                        if (empty($hasY)){
                            $wsql .= " and word not like '%" . $letter . "%' " . $br;
                        }
                    }
                }
            }

            $sql = "select word from words " . $br . "where 1=1 " . $br . $wsql . "limit 10 " . $br;
            $foundwords = GExecSqlRaw ($sql);
        }
        while (count($wordmaps) < $numwords){
            $letters = [];
            while (count($letters) < $numletters){
                $letters[count($letters)] = '';
            }
            $wordmaps[]=['letters'=>$letters,'marks'=>$letters];
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
        for($rowidx=0;$rowidx<=5;$rowidx++){
            $vLetters = '';
            $vMarks = '';
            $vOK = 1;
            for($colidx=0;$colidx<5;$colidx++){
                $idx = 'word_' . $rowidx . '_letter_' . $colidx;

                $vLetter = $request[$idx];
                $vMark = $request['val_' . $idx]??'x';

                $vLetters .= $vLetter;
                $vMarks .= $vMark;
                if (empty ($vLetter)){
                    $vOK = 0;
                }
            }
            if ($vOK){
                GSetWordMap($vLetters, $vMarks);
            }
        }

// dr(GGetWordMap());

        return redirect()->route('word.show');
        // return $this->show();
    } // enter

    // ==============================
    // Clear the current word stuff
    // ==============================
    public function clear()
    {
        GClearWordMap();
        return redirect()->route('word.show');
    } // clear

}
