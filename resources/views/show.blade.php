<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="Description" content="{{ GC("APP_NAME") }} Wordle Helper. Get matching words based on your clues.">
    <meta name="google-adsense-account" content="ca-pub-5557547426776396">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ GC("APP_NAME") }} | Wordle Assistant</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- Styles --}}
    <link href="./css/custom.css{{ GForceNoCache(['force' => 1]) }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="/favicon.ico">

    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5557547426776396"
        crossorigin="anonymous"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8TDGHT4F88"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-8TDGHT4F88');
    </script>
</head>

<body>
    <div class="wc-game">
        <header class="text-center">
            <h1 class="h1">WDL</h1>
            <h2>Wordle Assistant</h2>
        </header>

        <div class="wc-board-container">
            <form action="./enter" method="post" id="game-form">
                @csrf
                <div class="wc-game-row">
                    @foreach ($wordmaps as $rowidx => $wordmap)
                        <div class="wc-row">
                            @foreach ($wordmap["letters"] as $colidx => $letter)
                                <div class="wc-field-group">
                                    <input type="text" {{ ($rowidx == 0 and $colidx == 0) ? 'autofocus' : '' }} value="{{ $letter }}"
                                        wdlword="{{ $rowidx }}" wdlletter="{{ $colidx }}" maxlength="1" autocomplete="off"
                                        class="wc-input mark_{{ $wordmap["marks"][$colidx] }} toggle-state"
                                        name="word_{{ $rowidx }}_letter_{{ $colidx }}"
                                        id="word_{{ $rowidx }}_letter_{{ $colidx }}">
                                    <input type="hidden" id="val_word_{{ $rowidx }}_letter_{{ $colidx }}"
                                        name="val_word_{{ $rowidx }}_letter_{{ $colidx }}"
                                        value="{{ $wordmap["marks"][$colidx] }}">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="btn-container justify-content-center">
                    <button type="submit" class="btn btn-primary">Enter</button>
                    <a class="btn btn-success" href="./clear">Clear</a>
                </div>
            </form>
        </div>

        <!-- Ad Unit -->
        <div class="ad-container">
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5557547426776396"
                data-ad-slot="XXXXXXXXXX" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

        @if(!empty($foundwords))
            <div class="found-words-container">
                <div class="found-words-header">
                    <h1 class="h1" style="font-size: 1.2rem;">Found Words</h1>
                    <span class="badge-count">{{ count($foundwords) }}{{ count($foundwords) >= 30 ? '+' : '' }}</span>
                </div>
                <div class="card deck-card">
                    <div class="card-body wc-found-words">
                        @foreach ($foundwords as $foundword)
                            <span class="wc-found-word">{{ e($foundword->word) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>

    <script>
        $(document).ready(function () {
            // Color toggling with animation
            $(".toggle-state").on('click', function (e) {
                var vElement = $(this);
                var vName = vElement.attr("name");
                var vValName = "val_" + vName;
                var vValElement = $("#" + vValName);
                var currentState = vValElement.val() || "";
                var nextState = "";

                // Cycle: "" -> "x" -> "y" -> "g" -> ""
                if (currentState === "") nextState = "x";
                else if (currentState === "x") nextState = "y";
                else if (currentState === "y") nextState = "g";
                else nextState = "";

                // Animate flip
                vElement.addClass('flip');

                setTimeout(function () {
                    vElement.removeClass("mark_ mark_x mark_y mark_g");
                    vElement.addClass("mark_" + nextState);
                    vValElement.val(nextState);
                    vElement.removeClass('flip');
                }, 200);
            });

            // Input handling
            $(".wc-input").on('input', function () {
                var vElement = $(this);
                var vWord = parseInt(vElement.attr("wdlword"));
                var vLetter = parseInt(vElement.attr("wdlletter"));

                // Overwrite logic: if length > 1, keep only the latest character
                if (vElement.val().length > 1) {
                    vElement.val(vElement.val().slice(-1));
                }

                // Pop animation when typing
                if (vElement.val().length > 0) {
                    vElement.addClass('pop');
                    setTimeout(() => vElement.removeClass('pop'), 100);
                }

                if (vElement.val().length >= 1) {
                    var nextLetter = vLetter + 1;
                    var nextWord = vWord;

                    if (nextLetter > 4) {
                        nextLetter = 0;
                        nextWord = vWord + 1;
                    }

                    if (nextWord <= 5) {
                        $("#word_" + nextWord + "_letter_" + nextLetter).focus();
                    }
                }
            });

            // Auto-select text on focus to make overwriting easier
            $(".wc-input").on('focus', function () {
                this.select();
            });

            // Backspace handling
            $(".wc-input").on('keydown', function (e) {
                if (e.which === 8 && $(this).val().length === 0) {
                    var vWord = parseInt($(this).attr("wdlword"));
                    var vLetter = parseInt($(this).attr("wdlletter"));

                    var prevLetter = vLetter - 1;
                    var prevWord = vWord;

                    if (prevLetter < 0) {
                        prevLetter = 4;
                        prevWord = vWord - 1;
                    }

                    if (prevWord >= 0) {
                        $("#word_" + prevWord + "_letter_" + prevLetter).focus();
                    }
                }
            });
        });
    </script>
</body>

</html>