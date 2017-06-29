<?php

class Level1
{
    public static function generatePossibleDecodedMessage($string)
    {
        $bitsArray = self::convertToBits($string);

        $possibleAnswers = [];
        for ($i = 0; $i <= sizeof($bitsArray); $i++) {
            for ($bitValue = 0; $bitValue <= 1; $bitValue++) {
                $fixedBitsArray = self::injectBitIntoPosition($bitValue, $i, $bitsArray);
//            print implode(',', $fixedBitsArray) . "\n";
                $letters = self::splitBitsIntoLetters($fixedBitsArray);
                $possibleAnswer = self::binaryLettersToAsciiWord($letters);
                if ($possibleAnswer) {
                    $possibleAnswers[] = $possibleAnswer;
                }
            }
        }
        var_dump(sizeof(array_unique($possibleAnswers)));
        var_dump(array_unique($possibleAnswers));
    }

    private function binaryLettersToAsciiWord($letters)
    {
        $ascii = '';
        $valid = true;
        foreach ($letters as $letter) {
            $dec = self::binaryToDec(implode('', $letter));
            if ($dec < 32 || $dec > 126) {
                $valid = false;
            }
            if (!$valid) {
                return;
            }
            $ascii .= chr($dec);
        }
        return $ascii;
    }

    private function binaryToDec($bin)
    {
        $dec = bindec($bin);
        return $dec;
    }

    private function splitBitsIntoLetters($array)
    {
        $words = array_chunk($array, 8);
        return $words;
    }

    private function injectBitIntoPosition($bit, $position, $bitsArray)
    {
        array_splice($bitsArray, $position, 0, $bit);
        return $bitsArray;
    }

    private function convertToBits($string)
    {
        $bits = explode(' ', $string);
        return array_map(function ($bit) {
            return $bit === '16' ? 0 : 1;
        }, $bits);
    }
}

Level1::generatePossibleDecodedMessage('16 16 17 17 17 16 16 16 16 17 17 16 16 17 17 16 16 17 17 16 17 17 17 16 17 17 16 17 16 16 16 16 17 17 16 16 16 16 17 16 17 17 17 16 16 17 17 16 16 17 17 16 17 17 16');