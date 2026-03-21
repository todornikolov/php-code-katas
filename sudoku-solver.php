<?php

/**
 * Sudoku Solver
 *
 * https://www.codewars.com/kata/5296bc77afba8baa690002d7
 *
 * Write a function that will solve a 9x9 Sudoku puzzle. The function will take one argument consisting of the 2D puzzle array, with the value 0 representing an unknown square.
 *
 * The Sudokus tested against your function will be "easy" (i.e. determinable; there will be no need to assume and test possibilities on unknowns) and can be solved with a brute-force approach.
 *
 * For Sudoku rules, see the Wikipedia article.
 *
 * sudoku([
 * [5,3,0,0,7,0,0,0,0],
 * [6,0,0,1,9,5,0,0,0],
 * [0,9,8,0,0,0,0,6,0],
 * [8,0,0,0,6,0,0,0,3],
 * [4,0,0,8,0,3,0,0,1],
 * [7,0,0,0,2,0,0,0,6],
 * [0,6,0,0,0,0,2,8,0],
 * [0,0,0,4,1,9,0,0,5],
 * [0,0,0,0,8,0,0,7,9]
 * ]); /* => [
 * [5,3,4,6,7,8,9,1,2],
 * [6,7,2,1,9,5,3,4,8],
 * [1,9,8,3,4,2,5,6,7],
 * [8,5,9,7,6,1,4,2,3],
 * [4,2,6,8,5,3,7,9,1],
 * [7,1,3,9,2,4,8,5,6],
 * [9,6,1,5,3,7,2,8,4],
 * [2,8,7,4,1,9,6,3,5],
 * [3,4,5,2,8,6,1,7,9]
 * ] 
 * */

function sudoku(array $puzzle): array {
    while (true) 
    {
        // iterate to find unknown positions
        $unknownSolvablePointers = findUnknownPositions($puzzle);

        if (empty($unknownSolvablePointers)) {
            break;
        }
        
        // try to solve
        foreach ($unknownSolvablePointers as $pointerKeys) {
            $potentialValue = tryBruteSolve($puzzle, $pointerKeys);

            // assign new solved value to puzzle
            if (is_int($potentialValue))
            {
                $puzzle[$pointerKeys[0]][$pointerKeys[1]] = $potentialValue;
            }
        }
    }

    // Return the solved puzzle as a 9 × 9 grid
    return $puzzle;
}

function findUnknownPositions(array $puzzle): array {
    $unknownPositions = [];
    
    for ($verticalKey = 0; $verticalKey <= 8; $verticalKey++)
    {
        for ($horizontalKey = 0; $horizontalKey <= 8; $horizontalKey++) {
            if ($puzzle[$verticalKey][$horizontalKey] == 0) {
                $unknownPositions[] = [$verticalKey, $horizontalKey];
            }
        }
    }
    
    return $unknownPositions;
}

function tryBruteSolve(array $puzzle, array $pointerKeys): ?int {
    $horizontalValues = [];
    $verticalValues = [];
    $groupValues = [];
    $potentialValues = [];

    // get values horizontal and vertical rows
    for ($i = 0; $i <= 8; $i++) {
        if ($puzzle[$pointerKeys[0]][$i] != 0) {
            $horizontalValues[] = $puzzle[$pointerKeys[0]][$i];
        }
        if ($puzzle[$i][$pointerKeys[1]] != 0) {
            $verticalValues[] = $puzzle[$i][$pointerKeys[1]];
        }
    }
    
    // determine group vertical and horizontal range
    $verticalRange = getGroupRange($pointerKeys[0]);
    $horizontalRange = getGroupRange($pointerKeys[1]);
    
    // get values from the group
    foreach ($verticalRange as $verticalRangeKey)
    {
        foreach ($horizontalRange as $horizontalRangeKey)
        {
            if ($puzzle[$verticalRangeKey][$horizontalRangeKey] != 0) {
                $groupValues[] = $puzzle[$verticalRangeKey][$horizontalRangeKey];
            }
        }
    }

    for ($i = 1; $i <= 9; $i++) {
        if (! in_array($i, $horizontalValues, true) 
            && ! in_array($i, $verticalValues, true)
                && ! in_array($i, $groupValues, true)) {
            $potentialValues[] = $i;
        }
    }
    
    if (count($potentialValues) == 1) {
        return $potentialValues[0];
    }
    
    return null;
}

function getGroupRange($key): array {
    if ($key <= 2) {
        return [0, 1, 2];
    }
    
    if ($key <= 5) {
        return [3, 4, 5];
    }
    
    return [6, 7, 8];
}

sudoku([
    [5,3,0,  0,7,0,  0,0,0],
    [6,0,0,  1,9,5,  0,0,0],
    [0,9,8,  0,0,0,  0,6,0],
   
    [8,0,0, 0,6,0, 0,0,3],
    [4,0,0, 8,0,3, 0,0,1],
    [7,0,0, 0,2,0, 0,0,6],
   
    [0,6,0, 0,0,0, 2,8,0],
    [0,0,0, 4,1,9, 0,0,5],
    [0,0,0, 0,8,0, 0,7,9]
]);
