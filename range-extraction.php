<?php

/**
 * Range Extraction
 * 
 * https://www.codewars.com/kata/51ba717bb08c1cd60f00002f
 * 
 * A format for expressing an ordered list of integers is to use a comma separated list of either
 *
 * individual integers
 * or a range of integers denoted by the starting integer separated from the end integer in the range by a dash, '-'. The range includes all integers in the interval including both endpoints. It is not considered a range unless it spans at least 3 numbers. For example "12,13,15-17"
 * Complete the solution so that it takes a list of integers in increasing order and returns a correctly formatted string in the range format.
 *
 * Example:
 *
 * solution([-10, -9, -8, -6, -3, -2, -1, 0, 1, 3, 4, 5, 7, 8, 9, 10, 11, 14, 15, 17, 18, 19, 20])
 * // returns '-10--8,-6,-3-1,3-5,7-11,14,15,17-20'
 */

function solution(array $list): string
{
    sort($list);
    
    $outputArray = [];
    $groupedArray = [];
    $groupKeyCount = 0;

    for ($i = 0; $i < count($list); $i++) 
    {
        $countSequence = 1;
        
        $groupedArray[$groupKeyCount][] = $list[$i];
        
        if (
            ! array_key_exists($i + 1, $list) ||
            ! array_key_exists($i + 2, $list) ||
            $list[$i] + 1 != $list[$i + 1] ||
            $list[$i] + 2 != $list[$i + 2]
        ) {
            $groupKeyCount++;
            continue;
        }

        while (
            array_key_exists($i + $countSequence, $list) &&
            (int) $list[$i] + $countSequence == $list[$i + $countSequence]
        ) {
            $groupedArray[$groupKeyCount][] = $list[$i + $countSequence];
            $countSequence++;
        }

        $groupKeyCount++;
        
        if ($countSequence > 1) {
            $i += $countSequence - 1;
        }
    }
    
    foreach ($groupedArray as $list[$i])
    {
        $outputArray[] = decorateItem($list[$i]);
    }
    
    return implode(',', $outputArray);
}

function decorateItem(int|array $value): string
{
    if (is_array($value) && count($value) > 1) {
        return $value[0] . '-' . $value[max(array_keys($value))];
    }
    
    return (string) $value[0];
}

solution([-10, -9, -8, -6, -3, -2, -1, 0, 1, 3, 4, 5, 7, 8, 9, 10, 11, 14, 15, 17, 18, 19, 20]);