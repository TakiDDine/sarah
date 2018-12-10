<?php

/**
 *  This function reads a JSON content string and converts it to an Array
 *  By Halpdesk
 *
 *  @param  String      $content    The CSV string to convert
 *  @param  Boolean     $assoc      If set to true, the function returns an object instead
 *  @throws Exception               Exception with json_last_error from json_decode if any
 *  @return mixed                   The resulting array or object
 *
 */
if (!function_exists('json_to_array')) {
    function json_to_array($content, $assoc = true)
    {
        // Remove byte order mark from beginning of content if found
        $STR_BOM = "\xEF\xBB\xBF";
        if (stristr($content, $STR_BOM) !== false) {
            $content = str_replace($STR_BOM, "", $content);
        }

        // Replace carrige return with line feed
        $content = str_replace("\r\n", "\n", $content);
        $content = str_replace("\r", "\n", $content);

        // Convert to UTF-8
        //$content = utf8_encode($content);

        $result = json_decode($content, $assoc);
        if ($result === null) {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $error = 'No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    $error = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $error = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $error = 'Unknown error';
                    break;
            }
            throw new Exception('json_decode() ['.json_last_error() . ']: '.$error.' (' . json_last_error_msg() .')', json_last_error());
        }
        return $result;
    }
}


/**
 *  Reads a JSON file and converts it to an Array
 *
 *  @param  String      $path   Full path to JSON file
 *  @return Array               The resulting array
 *  @author Halpdesk
 *
 */
if (!function_exists('json_file_to_array') && function_exists('json_to_array')) {
    function json_file_to_array($path)
    {
        if (!file_exists($path)) {
            trigger_error(
                __FUNCTION__.'(): The path '.$path.' does not exist.',
                E_USER_ERROR
            );
        }
        if (!is_readable($path)) {
            trigger_error(
                __FUNCTION__.'(): The path '.$path.' is not readable.',
                E_USER_ERROR
            );
        }

        // Get content
        $content = file_get_contents($path);

        try {
            // Get Array
            $result = json_to_array($content);
        } catch (Exception $e) {
            trigger_error(
                __FUNCTION__.'(): '. $e->getMessage() . ' in file: ' . $path,
                E_USER_ERROR
            );
        }

        // Return
        return $result;
    }
}


/**
 *  Combine two arrays with same keys, last value persists
 *  ignores empty values
 *
 *  @param  Array[] $array  The arrays to patch
 *  @return Array           The resulting array
 *  @author Halpdesk
 */
if (!function_exists('array_patch')) {
    function array_patch(...$array)
    {
        $args = func_get_args();
        $count = func_num_args();

        $resultArray = [];

        for ($i = 0; $i < $count; ++$i) {
            if (is_array($args[$i])) {
                foreach ($args[$i] as $key => $val) {

                    if (empty($val)) {
                        continue;
                    }

                    $resultArray[$key] = $val;
                }
                $result = $resultArray;
            } else {
                trigger_error(
                    __FUNCTION__ . '(): Argument #' . ($i+1) . ' is not an array',
                    E_USER_ERROR
                );
                $result = null;
            }
        }
        return $result;
    }
}

/**
 *  Transforms an array to CSV format
 *
 *  @param  Array $array        The arrays to transform
 *  @return string $separator   The CSV separator, typically a semicolon or comma
 *  @return string $newLine     The newline character, typically "\r\n" for windows, "\n" for linux systems
 *  @author Halpdesk
 */
if (! function_exists('array_to_csv')) {
    function array_to_csv($array, $separator = ';', $newLine = "\n")
    {
        $content = '';
        if (is_array($array)) {
            foreach ($array as $line) {
                if (is_array($line)) {
                    $content .= implode($separator, $line) . $separator . $newLine;
                } else {
                    trigger_error(
                        __FUNCTION__ . '(): Argument #1 is not a 2-dimensional array',
                        E_USER_WARNING
                    );
                    $result = null;
                }
            }
            $result = $content;
        } else {
            trigger_error(
                __FUNCTION__ . '(): Argument #1 is not an array',
                E_USER_WARNING
            );
            $result = null;
        }
        return $result;
    }
}