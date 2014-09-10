<?php

/**
 * Расчитывает простое арифметическое выражение
 *
 * @throws Exception
 *
 * @param $phrase
 * @return number
 */
function simpleCalc($phrase)
{
    $tokens = array();
    $number = '';
    for( $i = 0; $i < strlen($phrase); $i++) {
        switch ($phrase[$i]) {
            case '+': case '-':
            case '*': case '/':
                if ($phrase[$i] == '-' && $number == '') {
                    $number .= $phrase[$i];
                    continue;
                }
                if ($number == '') {
                    throw new Exception("Wrong expression  \"" . $phrase . "\": missing operand");
                }
                array_push($tokens, floatval($number));
                array_push($tokens, $phrase[$i]);
                $number = '';
                break;
            default:
                $number .= $phrase[$i];
        }

    }

    array_push($tokens, floatval($number));
    if (count($tokens) % 2 == 0) {
        throw new Exception("Wrong expression: " . $phrase);
    }

    while (count($tokens) > 1) {
        switch ($tokens[1]) {
            case '+':
            case '-':
                if (count($tokens) == 3 || $tokens[3] == '+' || $tokens[3] == '-') {
                    if ($tokens[1] == '+') {
                        $tokens[0] = $tokens[0] +  $tokens[2];
                    } else {
                        $tokens[0] = $tokens[0] -  $tokens[2];
                    }
                    array_splice($tokens, 1, 2);
                } else {
                    if ($tokens[3] == '*') {
                        $tokens[2] = $tokens[2] *  $tokens[4];
                    } else {
                        $tokens[2] = $tokens[2] /  $tokens[4];
                    }
                    array_splice($tokens, 3, 2);
                }
                break;
            case '*':
                $tokens[0] = $tokens[0] *  $tokens[2];
                array_splice($tokens, 1, 2);
                break;
            case '/':
                $tokens[0] = $tokens[0] /  $tokens[2];
                array_splice($tokens, 1, 2);
                break;
            default:
                throw new Exception("Parsing error: " . $phrase);
        }
    }


    return $tokens[0];
}


/**
 * Разбор и решение арифметического вырожения
 *
 * @throws Exception

 * @param string $expressionString
 * @return number
 */
function parse($expressionString)
{
    $result = 0;

    $expressionString = preg_replace("/(\d)\(/", "$1*(", $expressionString);

    while (strpos($expressionString, ')') !== false) {
        $phraseEnd = strpos($expressionString, ')');
        $phraseStart = strrpos(substr($expressionString, 0, $phraseEnd), '(');

        if ($phraseStart === false) {
            throw new Exception("Extra symbol \")\"");
        }

        $phrase = substr($expressionString, $phraseStart + 1, $phraseEnd - $phraseStart - 1);
        $phraseResult = simpleCalc($phrase);
        $expressionString = substr_replace(
            $expressionString, $phraseResult, $phraseStart, $phraseEnd - $phraseStart + 1
        );
    }

    if (strpos($expressionString, '(') !== false) {
        throw new Exception("Extra symbol \"(\"");
    }

    return simpleCalc($expressionString);
}