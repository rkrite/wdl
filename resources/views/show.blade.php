<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="Description" content="{{ GC('APP_NAME') }} website. Information and contact details.">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ GC("APP_NAME") }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        {{-- Styles --}}
        <link href="{{ GC("APP_URL") }}/css/app.css{{ GForceNoCache() }}" rel="stylesheet">
        <link href="{{ GC("APP_URL") }}/css/custom.css{{ GForceNoCache() }}" rel="stylesheet">

        {{-- Scripts --}}
        <script src="{{ GC("APP_URL") }}/js/app.js{{ GForceNoCache() }}"></script>
        <script src="{{ GC("APP_URL") }}/js/custom.js{{ GForceNoCache() }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    </head>
    <body class="desktop-body">
        <div id="site-desktop-page">
            <div class="container-fluid">
                <form>
                    <table>
                        @foreach ($wordmaps as $rowidx => $wordmap)
                            <tr>
                                @foreach ($wordmap['letters'] as $colidx => $letter)
                                    <td>
                                        <input type="text" class="mark_{{ $wordmap['marks'][$colidx] }} toggle-state" name="word_{{ $rowidx }}_letter_{{ $colidx }}">
                                        <input type="hidden" id="val_word_{{ $rowidx }}_letter_{{ $colidx }}" name="val_word_{{ $rowidx }}_letter_{{ $colidx }}" value="{{ $wordmap['marks'][$colidx] }}">
                                    </td>
                                @endforeach
                                <td>
                                    <a class="btn" href="/enter">Enter</a>

                                    <input type="text" class="mark_{{ $wordmap['marks'][$colidx] }} toggle-state" name="word_{{ $rowidx }}_letter_{{ $colidx }}">
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </form>
                <a class="btn" href="/clear">Clear</a>
            </div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function(){
        $(".toggle-state").click(function(){
            var vElement = $(this);
            var vName = vElement.name;
            var vValName = '#val_' + vName;
            // var vValElement = $("input[id=" + vValName + "]");

            if (vElement.hasClass("mark_")){
                vElement.removeClass('mark_');
                $(vValName).val('x');
                // vValElement.val('x')
                vElement.addClass('mark_x');
            }

            if (vElement.hasClass("mark_x")){
                vElement.removeClass('mark_x');
                $(vValName).val('y');
                // vValElement.val('y')
                vElement.addClass('mark_y');
            }

            if (vElement.hasClass("mark_y")){
                vElement.removeClass('mark_y');
                $(vValName).val('g');
                // vValElement.val('g')
                vElement.addClass('mark_g');
            }

            if (vElement.hasClass("mark_g")){
                vElement.removeClass('mark_g');
                $(vValName).val('');
                // vValElement.val('')
                vElement.addClass('mark_');
            }

        });
    });
</script>
