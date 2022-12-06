<?php

$inputString = file_get_contents('./input.txt');
$lines = explode(PHP_EOL, $inputString);

$numStacks = strlen($lines[0]) / 4;

$stacks = array_fill(0, $numStacks, []);
$moves = [
    // quantity
    // from
    // to
];

$finishedStacks = false;

// Process into workable arrays
for ($i = 0; $i < count($lines); $i++) {
    $line = $lines[$i];

    // skip 2 lines between stacks and moves
    if (substr($line, 0, 2) === ' 1') {
        $finishedStacks = true;
        $i++;
        continue;
    }

    if (! $finishedStacks) {
        $line .= ' ';

        for ($j = 0; $j < $numStacks; $j++) {
            $segment = substr($line, $j * 4, 4);
            $letter = substr($segment, 1, 1);

            if ($letter != ' ') {
                $stacks[$j][] = $letter;
            }
        }

        continue;
    }

    list(
        $_move,
        $quantity,
        $_from,
        $fromStack,
        $_to,
        $toStack
    ) = explode(' ', $line);

    $moves[] = [
        'quantity' => $quantity,
        'from' => $fromStack,
        'to' => $toStack
    ];
}

// Take a copy
$p2Stacks = $stacks;

// Part 1
foreach ($moves as $move) {
    $quantity = (int) $move['quantity'];
    $fromStack = $move['from'] - 1;
    $toStack = $move['to'] - 1;

    for ($i = 0; $i < $quantity; $i++) {
        $value = $stacks[$fromStack][0];

        // Remove from old stack and re-index
        unset($stacks[$fromStack][0]);
        $stacks[$fromStack] = array_values($stacks[$fromStack]);

        array_unshift($stacks[$toStack], $value);
    }
}

echo 'Part 1: ';
foreach ($stacks as $stack) {
    echo $stack[0];
}
echo PHP_EOL;


// Part 2
foreach ($moves as $move) {
    $quantity = (int) $move['quantity'];
    $fromStack = $move['from'] - 1;
    $toStack = $move['to'] - 1;

    $values = array_slice($p2Stacks[$fromStack], 0, $quantity);

    // Remove from old stack and re-index
    array_splice($p2Stacks[$fromStack], 0, $quantity);
    $p2Stacks[$fromStack] = array_values($p2Stacks[$fromStack]);

    for ($i = $quantity; $i > 0; $i--) {
        array_unshift($p2Stacks[$toStack], $values[$i - 1]);
    }
}

echo 'Part 2: ';
foreach ($p2Stacks as $stack) {
    echo $stack[0];
}
echo PHP_EOL;
