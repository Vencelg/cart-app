<?php

namespace CartApp\Core\Validator;

/**
 *
 */
abstract class AbstractValidator
{
    protected array $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Functional rule keywords are:
     * required
     * email
     * integer
     * string
     * float/double
     * boolean
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @return array
     */
    public function validate(): array
    {
        $errorsSet = false;
        $messages = [];
        $rules = $this->rules();
        $keysData = array_keys($this->data);
        $keysRules = array_keys($rules);

        for ($i = 0; $i < count($this->data); $i++) {
            for ($j = 0; $j < count($keysRules); $j++) {
                if ($keysData[$i] == $keysRules[$j]) {
                    $rulesString = $rules[$keysRules[$j]];
                    $rulesForData = explode("|", $rulesString);
                    for ($k = 0; $k < count($rulesForData); $k++) {
                        $isRequired = false;
                        if ($rulesForData[$k] == "required") {
                            $isRequired = true;
                            if (empty(trim($this->data[$keysData[$i]]))) {
                                $errorsSet = true;
                                array_push($messages, $keysData[$i] . " - REQUIRED ERROR");
                            }
                        }
                        if ($isRequired || isset($this->data[$keysData[$i]])) {
                            if ($rulesForData[$k] == "string") {
                                if (gettype($this->data[$keysData[$i]]) != "string") {
                                    $errorsSet = true;
                                    array_push($messages, $keysData[$i] . " - NOT $rulesForData[$k] ERROR");
                                }
                            }

                            if ($rulesForData[$k] == "integer") {
                                if (gettype($this->data[$keysData[$i]]) != "integer") {
                                    $errorsSet = true;
                                    array_push($messages, $keysData[$i] . " - NOT $rulesForData[$k] ERROR");
                                }
                            }

                            if ($rulesForData[$k] == "boolean") {
                                if (gettype($this->data[$keysData[$i]]) != "boolean") {
                                    $errorsSet = true;
                                    array_push($messages, $keysData[$i] . " - NOT $rulesForData[$k] ERROR");
                                }
                            }

                            if ($rulesForData[$k] == "float" || $rulesForData[$k] == "double") {
                                if (gettype($this->data[$keysData[$i]]) != "double") {
                                    $errorsSet = true;
                                    array_push($messages, $keysData[$i] . " - NOT $rulesForData[$k] ERROR");
                                }
                            }

                            if ($rulesForData[$k] == "email") {
                                if (!filter_var($this->data[$keysData[$i]], FILTER_VALIDATE_EMAIL)) {
                                    $errorsSet = true;
                                    array_push($messages, $keysData[$i] . " - NOT $rulesForData[$k] ERROR");
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($errorsSet) {
            return [
                'errorsSet' => true,
                'messages' => $messages
            ];
        } else {
            return [
                'errorsSet' => false,
                'messages' => $messages
            ];
        }
    }
}