<?php


namespace App\Helper;


use App\Models\VariableObject;

class PhpHelper
{
    const INDENT_TAB = "\t";
    const INDENT_SPACE = " ";
    const NEWLINE_WINDOWS = "\r\n";
    const NEWLINE_UNIX = "\n";
    const NEWLINE_MAC = "\r";

    const PARAM_INDENT_TAB = 't';
    const PARAM_INDENT_SPACE = 's';
    const PARAM_NEWLINE_WINDOWS = 'w';
    const PARAM_NEWLINE_UNIX = 'u';
    const PARAM_NEWLINE_MAC = 'm';

    const TYPE_SET = 'set';
    const TYPE_GET = 'get';


    private $indentCharacter;
    private $indentSize;
    private $newlineCharacter;
    private $isConstructor;
    private $isToArray;
    private $isPascalCase;
    private $isClone;
    private $isConvertJson;

    public function __construct()
    {
        $this->indentCharacter = self::INDENT_TAB;
        $this->indentSize = 1;
        $this->newlineCharacter = self::NEWLINE_UNIX;
        $this->isConstructor = true;
        $this->isToArray = true;
        $this->isPascalCase = true;
        $this->isClone = true;
        $this->isConvertJson = true;
    }

    public function getIndentCharacter()
    {
        return $this->indentCharacter;
    }

    public function setIndentCharacter($indentCharacter)
    {
        $this->indentCharacter = $indentCharacter;
    }

    public function getIndentSize()
    {
        return $this->indentSize;
    }

    public function setIndentSize($indentSize)
    {
        $this->indentSize = $indentSize;
    }

    public function getNewlineCharacter()
    {
        return $this->newlineCharacter;
    }

    public function setNewlineCharacter($newlineCharacter)
    {
        $this->newlineCharacter = $newlineCharacter;
    }

    public function isConstructor()
    {
        return $this->isConstructor;
    }

    public function setIsConstructor($isConstructor)
    {
        $this->isConstructor = $isConstructor;
    }

    public function isToArray()
    {
        return $this->isToArray;
    }

    public function setIsToArray($isToArray)
    {
        $this->isToArray = $isToArray;
    }

    public function isPascalCase()
    {
        return $this->isPascalCase;
    }

    public function setIsPascalCase($isPascalCase)
    {
        $this->isPascalCase = $isPascalCase;
    }

    public function isClone()
    {
        return $this->isClone;
    }

    public function setIsClone($isClone)
    {
        $this->isClone = $isClone;
    }

    public function isConvertJson()
    {
        return $this->isConvertJson;
    }

    public function setIsConvertJson($isConvertJson)
    {
        $this->isConvertJson = $isConvertJson;
    }

    //  --------------------------------------------------

    public function readCode($input)
    {
        $listVars = array();

        $matches = array();
        //read the input code
        $count = preg_match_all("/(private|protected)\\s+\\$(.*?)(=.*?)?;/", $input, $matches);
        for ($i = 0; $i < $count; $i++) {
            $name = trim($matches[2][$i]);

            $listToProcess = array();
            array_push($listToProcess, $name);
            //check to see if it contains commas
            //account for private $var1,$var2,$var3;
            if (UtilityHelper::strContains($name, ',')) {
                $listToProcess = explode(',', $name);
            }

            foreach ($listToProcess as $ex) {
                $var = new VariableObject();

                //remove the $
                $cleaned = trim($ex);
                //make sure its lowercase first letter
                $var->setRawName(lcfirst($cleaned));

                //snake_case, camelcase, pascalcase, kebabcase
                //my_variable, myVariable, MyVariable, my-variable
                $parts = array();

                //check what the current case is
                if (UtilityHelper::strContains($cleaned, '_')) {
                    //snake case
                    $parts = explode('_', $cleaned);
                } else if (UtilityHelper::strContains($cleaned, '-')) {
                    //kebab case
                    $parts = explode('-', $cleaned);
                } else {
                    //we assume camel of pascal
                    $parts = preg_split("/((?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z]))/", $cleaned);
                }

                if (strtolower($parts[0]) == 'is') {
                    $var->setIsBoolean(true);
                }

                if ($this->isPascalCase) {
                    $update = '';
                    foreach ($parts as $part) {
                        $update .= ucfirst($part);
                    }
                    $var->setFunctionName($update);
                } else {
                    $var->setFunctionName(ucfirst($cleaned));
                }

                array_push($listVars, $var);
            }

        }

        return $listVars;
    }

//  --------------------------------------------------

    public function generateCode($listOfVariables)
    {
        $code = "";

        if (!empty($listOfVariables)) {
            if ($this->isConstructor()) {
                $code .= $this->handleIndent(1) . "public function __construct(){" . $this->newlineCharacter;

                foreach ($listOfVariables as $variable) {
                    $code .= $this->handleIndent(2) . "\$this->" . $variable->getRawName() . " ='';" . $this->newlineCharacter;
                }

                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;
            }

            foreach ($listOfVariables as $variable) {
                $code .= $this->newlineCharacter;
                //write get
                $code .= $this->handleIndent(1) . "public function " . $this->handleFunctionName(self::TYPE_GET, $variable) . "() {" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "return \$this->" . $variable->getRawName() . ";" . $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;

                $code .= $this->newlineCharacter;
                //write set
                $code .= $this->handleIndent(1) . "public function " . $this->handleFunctionName(self::TYPE_SET, $variable) . "($" . $variable->getRawName() . ") {" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "\$this->" . $variable->getRawName() . " = $" . $variable->getRawName() . ";" . $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;
            }

            if($this->isClone()){
                $code .= $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "public function clone(){" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "\$result = new MyNewClass();" . $this->newlineCharacter;
                foreach($listOfVariables as $variable){
                    $code .= $this->handleIndent(2) . "\$result->".$this->handleFunctionName(self::TYPE_SET, $variable)."(\$this->".$variable->getRawName().");" .$this->newlineCharacter;
                }
                $code .= $this->handleIndent(2) . "return \$result;" . $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;
            }

            if ($this->isToArray()) {
                $code .= $this->newlineCharacter;

                //toArray
                $code .= $this->handleIndent(1) . "public function toArray(){" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "\$arr = array();" . $this->newlineCharacter;
                foreach ($listOfVariables as $variable) {
                    $code .= $this->handleIndent(2) . "if(!empty(\$this->" . $variable->getRawName() . ")){" . $this->newlineCharacter;
                    $code .= $this->handleIndent(3) . "\$arr['" . $variable->getRawName() . "'] = \$this->" . $variable->getRawName() . ";" . $this->newlineCharacter;
                    $code .= $this->handleIndent(2) . "} else {" . $this->newlineCharacter;
                    $code .= $this->handleIndent(3) . "\$arr['" . $variable->getRawName() . "'] = '';" . $this->newlineCharacter;
                    $code .= $this->handleIndent(2) . "}" . $this->newlineCharacter;
                }
                $code .= $this->handleIndent(2) . "return \$arr;" . $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;

                $code .= $this->newlineCharacter;

                //static toHeaderArray
                $code .= $this->handleIndent(1) . "public static function toHeaderArray(){" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "\$arr = array();" . $this->newlineCharacter;
                foreach ($listOfVariables as $variable) {
                    $code .= $this->handleIndent(2) . "array_push(\$arr, '" . $variable->getRawName() . "');" . $this->newlineCharacter;
                }
                $code .= $this->handleIndent(2) . "return \$arr;" . $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;
            }

            if($this->isConvertJson()){
                $code .= $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "public static function convertFromJson(\$json){" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "\$result=null;" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "if(!empty(\$json)){" . $this->newlineCharacter;
                $code .= $this->handleIndent(3) . "\$result = new MyNewClass();" . $this->newlineCharacter;
                foreach($listOfVariables as $variable){
                    $code .= $this->handleIndent(3) . "if(array_key_exists('".$variable->getRawName()."', \$json){". $this->newlineCharacter;
                    $code .= $this->handleIndent(4) . "\$result->".$this->handleFunctionName(self::TYPE_SET, $variable)."(\$json['".$variable->getRawName()."']);" .$this->newlineCharacter;
                    $code .= $this->handleIndent(3)."}". $this->newlineCharacter;
                }
                $code .= $this->handleIndent(2) . "}" . $this->newlineCharacter;
                $code .= $this->handleIndent(2) . "return \$result;" . $this->newlineCharacter;
                $code .= $this->handleIndent(1) . "}" . $this->newlineCharacter;
            }
        }

        return $code;
    }

    //  --------------------------------------------------

    private function handleIndent($level)
    {
        return str_repeat(str_repeat($this->indentCharacter, $this->getIndentSize()), $level);
    }

    //  --------------------------------------------------

    private function handleFunctionName($type, $variable)
    {
        $result = '';
        if (self::TYPE_GET == $type) {
            if ($variable->isBoolean()) {
                $result .= lcfirst($variable->getFunctionName());
            } else {
                $result .= self::TYPE_GET . $variable->getFunctionName();
            }
        } else {
            $result .= self::TYPE_SET . $variable->getFunctionName();
        }
        return $result;
    }

//  --------------------------------------------------

    public static function convertParamIndent($input)
    {
        //fancy lookup table
        return [self::PARAM_INDENT_SPACE => self::INDENT_SPACE, self::PARAM_INDENT_TAB => self::INDENT_TAB][$input] ?? self::INDENT_TAB;
    }

    //  --------------------------------------------------

    public static function convertParamNewline($input)
    {
        return [self::PARAM_NEWLINE_MAC => self::NEWLINE_MAC, self::PARAM_NEWLINE_UNIX => self::NEWLINE_UNIX, self::PARAM_NEWLINE_WINDOWS => self::NEWLINE_WINDOWS][$input] ?? self::NEWLINE_UNIX;
    }
}
