<?php
    use App\Word;
    use Illuminate\Support\Str;

    // =====================================
    // =====================================
    if (!function_exists('dr')) {
        function dr($var, $keepalive=0){
            if ($keepalive){
                dump($var);
            } else {
                dd($var);
            }
        }
    } // dr

    // =====================================
    // =====================================
    if (!function_exists('GC')) {
        /**
         * Get Global Config items. Use this instead of env()
         * @param string $configname [name of config item]
         */
        function GC(string $configname){
            return env($configname);
        }
    } // GC

    // =====================================
    // =====================================
    if (!function_exists('GSetWordMap')){
        function GSetWordMap($pLetters, $pMarks) {
            $vWordMaps = GGetWordMap();
            if (empty($vWordMaps)){
                $vWordMaps = [];
            }
            $vMapped = [];
            $vLetters = str_split(strtolower($pLetters));
            $vMarks = str_split(strtolower($pMarks));
            $vMapped['letters'] = $vLetters;
            $vMapped['marks'] = $vMarks;
            $vWordMaps[] = $vMapped;

            GPutSession('wordmaps', $vWordMaps);
            return $vWordMaps;
        }
    } // GSetWordMap

    // =====================================
    // =====================================
    if (!function_exists('GGetWordMap')){
        function GGetWordMap() {
        	$vWordMap = GGetSession('wordmaps');
            if (empty($vWordMap)){
            	return GClearWordMap();
            } else {
            	return $vWordMap;
            }
        }
    } // GGetWordMap

    // =====================================
    // =====================================
    if (!function_exists('GClearWordMap')){
        function GClearWordMap() {
            GPutSession('wordmaps', []);
            return [];
        }
    } // GClearWordMap

    // =====================================
    // =====================================
    if (!function_exists('GPutSession')){
        function GPutSession($key, $val) {

            session([$key => $val]);

            return session($key);
        }
    } // GPutSession

    // =====================================
    // =====================================
    if (!function_exists('GGetSession')){
        function GGetSession($key) {
            return session($key);
        }
    } // GGetSession

    // =====================================
    // =====================================
    if (!function_exists('GExecSqlRaw')){
        /**
         * Given a raw sql string, return the DB result
         */
        function GExecSqlRaw($sql) {
            return DB::select( $sql );
        }
    } // GExecSqlRaw

    // =====================================
    // =====================================
    if (!function_exists('GForceNoCache')) {
        /**
         * Calc and return the current vendor Pricing
         * @return string - "?<random_number>" or "<blank>"
         */
        function GForceNoCache ($pOptions=[]) {
            $force = $pOptions??0;
            $str = "";
            if ($force or GC("FORCE_NO_CACHE")){
                $str = "?" . GGenCode();
            }
            return ($str);
        }
    } // GForceNoCache

    // =====================================
    // =====================================
    if (!function_exists('GGenCode')) {
    /**
     * Generate a code with a given length
     * @param int $length [description]
     */
        function GGenCode(int $length=20) {
            return (strtolower(Str::random($length)));
        }
    } // GGenCode
