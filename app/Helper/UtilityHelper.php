<?php


namespace App\Helper;


class UtilityHelper
{
    //  --------------------------------------------------

    /**
     * @param $input
     * @param $delimiter
     * @return array
     */
    public static function getKeyValueByDelimiter($input, $delimiter)
    {
        $result = array();

        if (!empty($input)) {
            $nArr = explode($delimiter, $input);
            if (count($nArr) == 2) {
                $result['key'] = $nArr[0];
                $result['value'] = $nArr[1];
            }
        }

        return $result;
    }

    //  --------------------------------------------------

    /**
     * @param $map
     * @param $key
     * @param $value
     */
    public static function createAddMapArray(&$map, $key, $value)
    {
        if (!empty($key) && !empty($value)) {
            if (!is_null($map)) {

                $currArr = null;

                if (array_key_exists($key, $map)) {
                    $currArr = $map[$key];
                } else {
                    $currArr = array();
                }
                //add to the list
                array_push($currArr, $value);
                //restore into map
                $map[$key] = $currArr;
            }
        }
    }

    //  --------------------------------------------------

    /**
     * @param $input
     * @return bool
     */
    public static function convertStringToBool($input)
    {
        if (!empty($input)) {
            $cleanInput = trim(strtolower($input));

            //account for true
            if ($cleanInput == 'yes' || $cleanInput == 'y' || $cleanInput == '1' || $cleanInput=='true' || $cleanInput=='t') {
                return true;
            }
        }

        return false;
    }
    //  --------------------------------------------------

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function strStartsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }


    //  --------------------------------------------------

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function strEndsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

    //  --------------------------------------------------

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function strContains($haystack, $needle)
    {
        if (strpos($haystack, $needle) !== false) {
            return true;
        }
        return false;
    }
}
