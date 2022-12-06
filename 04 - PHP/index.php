<?php

$inputString = file_get_contents('./input.txt');
$arr = explode(PHP_EOL, $inputString);

$p1Total = 0;
$p2Total = 0;

foreach ($arr as $line) {
    list($elf1, $elf2) = explode(',', $line);
    $elf1 = explode('-', $elf1);
    $elf2 = explode('-', $elf2);

    $elf1Range = range($elf1[0], $elf1[1]);
    $elf2Range = range($elf2[0], $elf2[1]);
    $totalAreas = count($elf1Range) + count($elf2Range);
    $combinedAreas = count(array_unique(
        array_merge($elf1Range, $elf2Range)
    ));

    if (
        $combinedAreas === count($elf1Range)
        || $combinedAreas === count($elf2Range)
    ) {
        $p1Total++;
    }

    if ($combinedAreas < $totalAreas) {
        $p2Total++;
    }
}

print('Part 1: ' . $p1Total . PHP_EOL);
print('Part 2: ' . $p2Total . PHP_EOL);
