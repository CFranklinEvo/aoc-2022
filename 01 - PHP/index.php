<?php

$inputString = file_get_contents('./input.txt');
$arr = explode(PHP_EOL.PHP_EOL, $inputString);

foreach ($arr as $key => $line) {
    $elf = explode(PHP_EOL, $line);
    $arr[$key] = array_sum($elf);
}

rsort($arr);

$top3 = $arr[0] + $arr[1] + $arr[2];

echo 'Part 1: '.$arr[0].PHP_EOL;
echo 'Part 2: '.$top3.PHP_EOL;

