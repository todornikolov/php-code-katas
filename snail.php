<?php

/**
 * Snail Sort
 * 
 * https://www.codewars.com/kata/521c2db8ddc89b9b7a0000c1
 * 
 * Given an n x n array, return the array elements arranged from outermost elements to the middle element, traveling clockwise.
 *
 * array = [[1,2,3],
 * [4,5,6],
 * [7,8,9]]
 * snail(array) #=> [1,2,3,6,9,8,7,4,5]
 * For better understanding, please follow the numbers of the next array consecutively:
 *
 * array = [[1,2,3],
 * [8,9,4],
 * [7,6,5]]
 * snail(array) #=> [1,2,3,4,5,6,7,8,9]
 */

function snail(array $array): array {
    if (empty($array) || empty($array[array_key_first($array)])) {
        return [];
    }
    
    $snailResult = [];
    
    // Repeat until array is single item
    while (! empty($array)) 
    {
        if (count($array[0]) == 1) {
            array_push($snailResult, array_pop($array[0]));
            break;
        }
        
        foreach (walkSnailPath($array) as $value) {
            array_push($snailResult, $value);
        }
    }

    return $snailResult;
}

function walkSnailPath(array &$array): array
{
    $snailResult = [];
    
    // Take first array
    foreach ($array[0] as $value) {
        $snailResult[] = $value;
    }
    array_shift($array);

    // Take last element of any non-last arrays
    for ($i = 0; $i < count($array) - 1; $i++) {
        $snailResult[] = array_pop($array[$i]);
    }

    // Take reverse of the last array
    $lastArray = $array[count($array) - 1];
    foreach (array_reverse($lastArray) as $value) {
        $snailResult[] = $value;
    }
    array_pop($array);

    // Take first element of any left arrays
    for ($i = count($array) - 1; $i >= 0; $i--) {
        $snailResult[] = array_shift($array[$i]);
    }
    
    return $snailResult;
}

snail([
    [1, 2, 3, 1],
    [4, 5, 6, 4],
    [7, 8, 9, 7],
    [7, 8, 9, 7]
]);