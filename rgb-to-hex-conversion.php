<?php

/**
 * RGB To Hex Conversion
 * 
 * https://www.codewars.com/kata/513e08acc600c94f01000001
 */

//The rgb function is incomplete. Complete it so that passing in RGB decimal values will result in a hexadecimal representation being returned. Valid decimal values for RGB are 0 - 255. Any values that fall out of that range must be rounded to the closest valid value.
//
//Note: Your answer should always be 6 characters long, the shorthand with 3 will not work here.
//
//Examples (input --> output):
//255, 255, 255 --> "FFFFFF"
//255, 255, 300 --> "FFFFFF"
//0, 0, 0       --> "000000"
//148, 0, 211   --> "9400D3"

echo rgb(0, 0, 0) . PHP_EOL;
echo rgb(150, 120, 100) . PHP_EOL;
echo rgb(233, 120, 39) . PHP_EOL;
echo rgb(20, 88, 211) . PHP_EOL;
echo rgb(255, 255, 255) . PHP_EOL;

function rgb($r, $g, $b) {
    
    // Validate inputs boundaries
    $r = setValueToClosesBoundary($r);
    $g = setValueToClosesBoundary($g);
    $b = setValueToClosesBoundary($b);
    
    return covertAsColor($r, $g, $b);
}

function setValueToClosesBoundary(int $value): int
{
    if ($value < 0) {
        return 0;
    }

    if ($value > 255) {
        return 255;
    }

    return $value;
}

function covertAsColor(int $r, int $g, int $b): string
{
    $rgbArray = [$r, $g, $b];
    
    foreach ($rgbArray as $key => $value) {
        $asHex = convertIntToHex($value);
        
        if (strlen($asHex) == 1)
        {
            $asHex = '0' . $asHex;
        }
        
        $rgbArray[$key] = $asHex;
    }
    
    return strtoupper(implode($rgbArray));
}

function convertIntToHex(int $input): string
{
    return base_convert($input, 10, 16);
}