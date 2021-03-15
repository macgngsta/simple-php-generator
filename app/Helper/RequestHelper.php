<?php


namespace App\Helper;


use Illuminate\Http\Request;

class RequestHelper
{
    const PARAM_INDENT_CHAR = 'indent_char';
    const PARAM_INDENT_SIZE = 'indent_size';
    const PARAM_NEWLINE_CHAR = 'newline_char';
    const PARAM_ORIGINAL= 'original';
    const PARAM_IS_CONSTRUCTOR = 'is_constructor';
    const PARAM_IS_TOARRAY = 'is_toarray';
    const PARAM_IS_PASCALCASE = 'is_pascalcase';

    //params that we care about
    const AVAILABLE_PARAMS = array(self::PARAM_INDENT_CHAR, self::PARAM_INDENT_SIZE, self::PARAM_NEWLINE_CHAR, self::PARAM_ORIGINAL,
        self::PARAM_IS_CONSTRUCTOR, self::PARAM_IS_TOARRAY, self::PARAM_IS_PASCALCASE);
    /**
     * we expect parameters to come in as my_param, or myParam
     * when a - exists, we assume that is the value of the param. ie my_param-value : useful for checkboxes
     * @param Request $request
     * @return array
     */
    public static function readRequestArray(Request $request)
    {
        $map = array();

        $inputs = $request->all();
        if (!empty($inputs)) {
            foreach ($inputs as $key => $value) {

                $specialPair = UtilityHelper::getKeyValueByDelimiter($key, "-");
                if (count($specialPair) == 2) {
                    //this is one of those special cases
                    //lets make sure it is an allowed param
                    if (in_array($specialPair['key'], self::AVAILABLE_PARAMS)) {
                        //we use this just in case there are multiple values
                        UtilityHelper::createAddMapArray($map, $specialPair['key'], $specialPair['value']);
                    }
                } else {
                    //this is a typical param
                    if (in_array($key, self::AVAILABLE_PARAMS)) {
                        $map[$key] = $value;
                    }
                }
            }
        }

        return $map;
    }
}
