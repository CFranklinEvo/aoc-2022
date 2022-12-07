<?php

$inputString = file_get_contents('./input.txt');
$commands = explode(PHP_EOL, $inputString);

$directories = [];
$currentDirectory = '/';

function assignArrayByDotNotation(&$arr, $path, $value) {
    $keys = explode('.', $path);

    foreach ($keys as $key) {
        $arr = &$arr[$key];
    }

    $arr = $value;
}

foreach ($commands as $command) {
    $commandParts = explode(' ', $command);

    if ($commandParts[0] === '$') {
        $cmd = $commandParts[1];

        if ($cmd === 'ls') continue;

        if ($cmd === 'cd') {
            $destination = rtrim($commandParts[2]);

            if ($destination === '/') {
                $currentDirectory = '/';
            } else if ($destination === '..') {
                $currentDirectory = substr($currentDirectory, 0, strrpos( $currentDirectory, '.'));
            } else {
                $currentDirectory .= '.'.$destination;
            }
        }
    } else if ($commandParts[0] === 'dir') {
        //
    } else {
        $size = intval($commandParts[0]);
        $fileName = str_replace('.', '-', rtrim($commandParts[1]));

        assignArrayByDotNotation(
            $directories,
            $currentDirectory.'.'.$fileName,
            $size
        );
    }
}

// Pretty print of directory structure
// print_r($directories);

$dirSizes = [];

function getFolderSize($folder) {
    $sum = 0;

    array_walk_recursive($folder, function($number) use (&$sum) {
        $sum += $number;
    });

    return $sum;
}

function mapNestedSizes($array, &$dirSizes, $prevKey = '/') {
    foreach ($array as $key => $folder) {
        if (! is_array($folder)) continue;

        $newKey = $prevKey . '.' . $key;

        $dirSizes[$newKey] = getFolderSize($folder);

        mapNestedSizes($folder, $dirSizes, $newKey);
    }
}

// Get root size
$dirSizes['/'] = getFolderSize($directories);

mapNestedSizes($directories['/'], $dirSizes);

// Pretty print all directory sizes (dot notated)
// print_r($dirSizes);

$sub100kDirs = array_map(fn($value): int => $value <= 100000 ? $value : 0, $dirSizes);
print_r('Part 1: ' . array_sum($sub100kDirs) . PHP_EOL . PHP_EOL);

// Part 2
$totalSpace = 70000000;
$neededSpace = 30000000;
$currentFreeSpace = $totalSpace - $dirSizes['/'];

// print_r($dirSizes);

sort($dirSizes);

foreach ($dirSizes as $dir => $size) {
    if ($currentFreeSpace + $size >= $neededSpace) {
        print_r('Part 2:' . PHP_EOL);
        print_r('Free up: ' . $size . PHP_EOL);
        exit;
    }
}
