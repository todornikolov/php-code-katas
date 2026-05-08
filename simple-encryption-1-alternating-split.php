<?php

/**
 * Simple Encryption #1 - Alternating Split
 * 
 * https://www.codewars.com/kata/57814d79a56c88e3e0000786/train/php
 * 
 * Implement a pseudo-encryption algorithm which given a string S and an integer N concatenates all the odd-indexed characters of S with all the even-indexed characters of S, this process should be repeated N times.
 *
 * Examples:
 *
 * encrypt("012345", 1)  =>  "135024"
 * encrypt("012345", 2)  =>  "135024"  ->  "304152"
 * encrypt("012345", 3)  =>  "135024"  ->  "304152"  ->  "012345"
 *
 * encrypt("01234", 1)  =>  "13024"
 * encrypt("01234", 2)  =>  "13024"  ->  "32104"
 * encrypt("01234", 3)  =>  "13024"  ->  "32104"  ->  "20314"
 * Together with the encryption function, you should also implement a decryption function which reverses the process.
 *
 * If the string S is an empty value or the integer N is not positive, return the first argument without changes.
 */

function encrypt($text, $n): ?string {
    if (empty($text)) {
        return $text;
    }

    // concat n times
    for (;$n > 0; $n--)
    {
        $splitArray = splitStingToOddEven($text);
        
        // Iterate odd/even arrays and concat to output
        $text = implode($splitArray['odd']) . implode($splitArray['even']);
    }
    
    return $text;
}

function decrypt($text, $n): ?string {
    if (empty($text)) {
        return $text;
    }

    // concat n times
    for (;$n > 0; $n--)
    {
        // split in half
        $strSplit = str_split($text, strlen($text) / 2);
        $firstHalf = str_split($strSplit[0]);
        $secondHalf = str_split($strSplit[1]);

        if (isset($strSplit[2])) {
            $secondHalf[] = $strSplit[2];
        }
        
        $text = '';
        // Iterate odd/even arrays and concat to output
        $counter = max(count($firstHalf), count($secondHalf));
        for ($x = 0; $x <= $counter; $x++)
        {
            $text = $text . ($secondHalf[$x] ?? '') . ($firstHalf[$x] ?? '');
        }
    }

    return $text;
}

function splitStingToOddEven(string $inputString): array
{
    $inputArray = str_split($inputString);

    // iterate and push to odd/even arrays
    $oddArray = [];
    $evenArray = [];

    for ($i = 0; $i < count($inputArray); $i++)
    {
        if ($i % 2 == 0) {
            $evenArray[] = $inputArray[$i];
            continue;
        }

        $oddArray[] = $inputArray[$i];
    }
    
    return [
        'even' => $evenArray,
        'odd' => $oddArray
    ];
}


encrypt('012345', 0); // 012345
encrypt('012345', 1); // 135024
encrypt('012345', 2); // "135024"  ->  "304152"
encrypt("012345", 3); // "135024"  ->  "304152"  ->  "012345"

decrypt('012345', 0); // 012345
decrypt('1350246', 1); // 012345
decrypt('304152', 2); // 012345
decrypt('012345', 3); // 012345
