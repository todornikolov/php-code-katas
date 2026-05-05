<?php

/**
 * The observed PIN
 * 
 * https://www.codewars.com/kata/5263c6999e0f40dee200059d
 * 
 * Alright, detective, one of our colleagues successfully observed our target person, Robby the robber. We followed him to a secret warehouse, where we assume to find all the stolen stuff. The door to this warehouse is secured by an electronic combination lock. Unfortunately our spy isn't sure about the PIN he saw, when Robby entered it.
 *
 * The keypad has the following layout:
 *
 * ┌───┬───┬───┐
 * │ 1 │ 2 │ 3 │
 * ├───┼───┼───┤
 * │ 4 │ 5 │ 6 │
 * ├───┼───┼───┤
 * │ 7 │ 8 │ 9 │
 * └───┼───┼───┘
 * │ 0 │
 * └───┘
 * He noted the PIN 1357, but he also said, it is possible that each of the digits he saw could actually be another adjacent digit (horizontally or vertically, but not diagonally). E.g. instead of the 1 it could also be the 2 or 4. And instead of the 5 it could also be the 2, 4, 6 or 8.
 *
 * He also mentioned, he knows this kind of locks. You can enter an unlimited amount of wrong PINs, they never finally lock the system or sound the alarm. That's why we can try out all possible (*) variations.
 *
 *  possible in sense of: the observed PIN itself and all variations considering the adjacent digits
 *
 * Can you help us to find all those variations? It would be nice to have a function, that returns an array (or a list in Java/Kotlin and C#) of all variations for an observed PIN with a length of 1 to 8 digits. We could name the function getPINs (get_pins in python, GetPINs in C#). But please note that all PINs, the observed one and also the results, must be strings, because of potentially leading '0's. We already prepared some test cases for you.
 *
 * Detective, we are counting on you!
 */

function getPINs(string $observed): array
{
    $resultPins = [];
    $observedArray = str_split($observed);

    $lookupTable = [
        '1' => ['124'],
        '2' => ['1235'],
        '3' => ['236'],
        '4' => ['1457'],
        '5' => ['24568'],
        '6' => ['3569'],
        '7' => ['478'],
        '8' => ['57890'],
        '9' => ['689'],
        '0' => ['08'],
    ];

    for ($pinPosition = 0; $pinPosition < count($observedArray); $pinPosition++) {
        // For given pin position return all possible values based on mapping
        $possibleValues = str_split($lookupTable[$observedArray[$pinPosition]][0]);

        // 1st - direct assign combinations from mappings
        if ($pinPosition == 0) {
            $resultPins = $possibleValues;
            continue;
        }
        
        $resultPins = iteratePins($resultPins, $possibleValues);
    }
    
    return $resultPins;
}

function iteratePins(array $existingPins, array $nextPins): array
{
    $iteratedResult = [];
    foreach ($existingPins as $existingValue) {
        foreach ($nextPins as $nextPinValue) {
            $iteratedResult[] = $existingValue . $nextPinValue;
        }
    }

    return $iteratedResult;
}

function testSample() {
    $expectations = [
        "8" => ["5", "7", "8", "9", "0"],
        "11" => ["11", "22", "44", "12", "21", "14", "41", "24", "42"],
        "369" => ["339","366","399","658","636","258","268","669","668","266","369","398","256","296","259","368","638","396","238","356","659","639","666","359","336","299","338","696","269","358","656","698","699","298","236","239"],
    ];
    foreach ($expectations as $pin => $expect) {
        $actual = getPINs($pin);
        sort($actual);
        sort($expect);
        if ($expect != $actual) {
            throw new Exception('Test failed!' . print_r($actual) . ' ' . print_r($expect));
        }
    }
}

testSample();