<?php


namespace App\Http\Controllers;


use App\Helper\PhpHelper;
use App\Helper\RequestHelper;
use App\Helper\UtilityHelper;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function generateCode(Request $request){
        $inputMap = RequestHelper::readRequestArray($request);

        //var_dump($inputMap);
        //die;

        $errorMsg ='';
        $originalCode='';
        $generatedCode ='';

        if(array_key_exists(RequestHelper::PARAM_ORIGINAL, $inputMap)){

            $originalCode =$inputMap[RequestHelper::PARAM_ORIGINAL];

            $helper = new PhpHelper();
            $helper->setIndentCharacter(PhpHelper::convertParamIndent($inputMap[RequestHelper::PARAM_INDENT_CHAR]));
            $helper->setIndentSize($inputMap[RequestHelper::PARAM_INDENT_SIZE]);
            $helper->setNewlineCharacter(PhpHelper::convertParamNewline($inputMap[RequestHelper::PARAM_NEWLINE_CHAR]));
            if(array_key_exists(RequestHelper::PARAM_IS_CONSTRUCTOR, $inputMap)){
                $helper->setIsConstructor(UtilityHelper::convertStringToBool($inputMap[RequestHelper::PARAM_IS_CONSTRUCTOR]));
            }

            if(array_key_exists(RequestHelper::PARAM_IS_TOARRAY, $inputMap)){
                $helper->setIsToArray(UtilityHelper::convertStringToBool($inputMap[RequestHelper::PARAM_IS_TOARRAY]));
            }

            if(array_key_exists(RequestHelper::PARAM_IS_PASCALCASE, $inputMap)){
                $helper->setIsPascalCase(UtilityHelper::convertStringToBool($inputMap[RequestHelper::PARAM_IS_PASCALCASE]));
            }

            $listVars = $helper->readCode($inputMap[RequestHelper::PARAM_ORIGINAL]);

            if(!empty($listVars)){
                $generatedCode = $helper->generateCode($listVars);

                //var_dump($generatedCode);
                //die;
            }
            else{
                //list vars was empty
                $errorMsg = 'could not find variables in code';
            }
        }

        return view('generate')
            ->with('inputMap', $inputMap)
            ->with('original_code', $originalCode)
            ->with('generated_code', $generatedCode)
            ->with('error_message', $errorMsg);
    }
}
