<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Description" content="{{ GC("APP_NAME") }} website. Information and contact details.">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ GC("APP_NAME") }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        {{-- Styles --}}
        <link href="./css/app.css{{ GForceNoCache(['force'=>1]) }}" rel="stylesheet">
        <link href="./css/custom.css{{ GForceNoCache(['force'=>1]) }}" rel="stylesheet">

        {{-- Scripts --}}
        <script src="./js/app.js{{ GForceNoCache(['force'=>1]) }}"></script>
        <script src="./js/custom.js{{ GForceNoCache(['force'=>1]) }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-8TDGHT4F88"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-8TDGHT4F88');
        </script>

    </head>

    <body>
        <div class="wc-game">
            <div class="container text-center">
                <h1 class="h1">Wordle Cheater</h1>
                <h2>Why bother!!</h2>
            </div>
            <div class="wc-board-container">
                <div id="wc-board">
                    <form action="./enter" method="post">
                        @csrf
                        <div class="wc-game-row">
                            @foreach ($wordmaps as $rowidx => $wordmap)
                            <div class="wc-row ">
                                <div class="">&nbsp;</div>
                                @foreach ($wordmap["letters"] as $colidx => $letter)
                                <div class="wc-field-group border-0">
                                    <input
                                        type="text" {{ ($rowidx == 0 and $colidx == 0)?e('autofocus'):e('') }}
                                        value="{{ $letter }}"
                                        maxlength="1"
                                        class="wc-input border-1 mark_{{ $wordmap["marks"][$colidx] }} toggle-state"
                                        name="word_{{ $rowidx }}_letter_{{ $colidx }}"
                                        id="word_{{ $rowidx }}_letter_{{ $colidx }}">
                                    <input
                                        type="hidden"
                                        id="val_word_{{ $rowidx }}_letter_{{ $colidx }}"
                                        name="val_word_{{ $rowidx }}_letter_{{ $colidx }}"
                                        value="{{ $wordmap["marks"][$colidx] }}">
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary" href="/enter">Enter</button>
                        <a class="btn btn-success" href="./clear">Clear</a>
                    </form>
                </div>
            </div>


            <div class="container text-center">
                <h1>Words found...</h1>
                <div class="card deck-card">
                    <div class="card-body">
                    <!--{{ $i=1 }} -->
                    @foreach ($foundwords as $foundword)
                        <div>{{ e($i++  . ': ' . $foundword->word) }}</div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-primary text-center fixed-bottom">
            <a class="text-light" href="https://github.com/rkrite/wdl">github.com/rkrite/wdl</a>
        </footer>

        <script>
            $(document).ready(function(){
                $(".toggle-state").on ('click',(function(){
                    var vElement = $(this);
                    var vName = vElement.attr("name");
                    var vValName = "val_" + vName;
                    var vValElement = $("input[id=" + vValName + "]");
                    var vChar = "A";

                    if (vElement.hasClass("mark_")){
                        vChar = "x";
                        vElement.removeClass("mark_");
                        vValElement.val(vChar);
                        vElement.addClass("mark_" + vChar);
                    } else if (vElement.hasClass("mark_x")){
                        vChar = "y";
                        vElement.removeClass("mark_x");
                        vValElement.val(vChar);
                        vElement.addClass("mark_" + vChar);
                    } else if (vElement.hasClass("mark_y")){
                        vChar = "g";
                        vElement.removeClass("mark_y");
                        vValElement.val(vChar);
                        vElement.addClass("mark_" + vChar);
                    } else if (vElement.hasClass("mark_g")){
                        vChar = "";
                        vElement.removeClass("mark_g");
                        vValElement.val(vChar);
                        vElement.addClass("mark_" + vChar);
                    }
                }));
            });
        </script>
        <script>
            $(document).ready(function(){
                $(".wc-input").keyup(function () {

                    var vElement = $(this);
                    var vElementName = vElement.attr("name");
                    var vMaxLen = vElement.attr("maxlength");
                    var vLen = vElement.val().length;
                    var vIndex = vElement.index(".wc-input");
                    var vNextElement = vElement.next('.wc-input');
                    var vNextElementName = vNextElement.attr("name");

                    var inputs = vElement.closest('form').find(':focusable');

                    if (vLen >= vMaxLen) {
                      vNextElement('.wc-input').focus();
                    }
                });
            });
        </script>

    </body>

</html>

