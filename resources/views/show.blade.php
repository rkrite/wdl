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
        <link href="{{ GC("APP_URL") }}/css/app.css{{ GForceNoCache() }}" rel="stylesheet">
        <link href="{{ GC("APP_URL") }}/css/custom.css{{ GForceNoCache() }}" rel="stylesheet">

        {{-- Scripts --}}
        <script src="{{ GC("APP_URL") }}/js/app.js{{ GForceNoCache() }}"></script>
        <script src="{{ GC("APP_URL") }}/js/custom.js{{ GForceNoCache() }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    </head>
    <body class="desktop-body">
        <div class="container text-center">
            <h1>Wordle Cheater</h1>
            <form action="{{ route('word.enter') }}" method="post">
                @csrf
                @foreach ($wordmaps as $rowidx => $wordmap)
                <div class=" row  border-0">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">&nbsp;</div>
                    @foreach ($wordmap["letters"] as $colidx => $letter)
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                        <input type="text" {{ ($rowidx == 0 and $colidx == 0)?e('autofocus'):e('') }} value="{{ $letter }}" class="input-sm wc-input border-1 mark_{{ $wordmap["marks"][$colidx] }} toggle-state" name="word_{{ $rowidx }}_letter_{{ $colidx }}" id="word_{{ $rowidx }}_letter_{{ $colidx }}">
                        <input type="hidden" id="val_word_{{ $rowidx }}_letter_{{ $colidx }}" name="val_word_{{ $rowidx }}_letter_{{ $colidx }}" value="{{ $wordmap["marks"][$colidx] }}">
                    </div>
                    @endforeach
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">&nbsp;</div>
                </div>
                @endforeach
                <button type="submit" class="btn" href="/enter">Enter</button>
                <a class="btn" href="/clear">Clear</a>
            </form>
        </div>

        <div class="container text-center">
            <h1>Words found...</h1>
            <div class="card deck-card">
                <div class="card-body">
                @foreach ($foundwords as $foundword)
                    <div>{{ e($foundword->word) }}</div>
                @endforeach
                </div>
            </div>
        </div>

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

