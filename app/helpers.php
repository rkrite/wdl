<?php
    use App\Word;

    // =====================================
    // =====================================
    if (!function_exists('GSetWordMap')){
        function GSetWordMap($pLetters, $pMarks) {
            $vWordMaps = GGetWordMap();
            if (empty($vWordMaps)){
                $vWordMaps = [];
            }
            $vMapped = [];
            $vLetters = str_split($pLetters);
            $vMarks = str_split($pMarks);
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
            return $_SESSION[$key] = $val;
        }
    } // GPutSession

    // =====================================
    // =====================================
    if (!function_exists('GGetSession')){
        function GGetSession($key) {
            if (array_key_exists($key, $_SESSION)) {
                return $_SESSION[$key];
            } else {
                return false;
            }
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
        function GForceNoCache () {
            $str = "";
            if (GC("FORCE_NO_CACHE")){
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
            return (strtolower(str_random($length)));
        }
    } // GGenCode
