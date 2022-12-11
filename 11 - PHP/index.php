<?php

$inputStr = file_get_contents('./input.txt');
$monkeyInputs = preg_split("/\r\n\r\n|\n\n|\r\r/", $inputStr);

$monkeys = [];
$rounds = 20;

foreach ($monkeyInputs as $monkeyId => $monkeyString) {
    $monkey = explode(PHP_EOL, $monkeyString);

    # Extract Starting Items
    $startItemsLine = $monkey[1];
    $startItemsString = rtrim(substr($startItemsLine, strpos($startItemsLine, ':') + 2));
    $startItems = explode(', ', $startItemsString);

    # Extract operation
    $operationLine = $monkey[2];
    $operation = rtrim(substr($operationLine, strpos($operationLine, '=') + 2));

    # Extract divisible text amount
    $testLine = $monkey[3];
    $test = rtrim(substr($testLine, strpos($testLine, 'by') + 3));

    # Extract monkey to throw for true test
    $trueLine = $monkey[4];
    $true = rtrim(substr($trueLine, strpos($trueLine, 'monkey') + 7));

    # Extract monkey to throw for false test
    $falseLine = $monkey[5];
    $false = rtrim(substr($falseLine, strpos($falseLine, 'monkey') + 7));

    $monkeys[$monkeyId] = [
        'items' => $startItems,
        'operation' => $operation,
        'test' => $test,
        'true' => $true,
        'false' => $false,
        'count' => 0,
    ];
}


function calculateString($calc) {
    $terms = explode(' ', $calc);

    switch ($terms[1]) {
        case '+':
            $result = $terms[0] + $terms[2];
            break;
        case '-':
            $result = $terms[0] - $terms[2];
            break;
        case '/':
            $result = $terms[0] / $terms[2];
            break;
        case '*':
            $result = $terms[0] * $terms[2];
            break;
        default:
            die('Something went wrong. Unsupported operand: ' . $terms[1]);
            break;
    }

    return $result;
}


for ($round = 1; $round <= $rounds; $round++) {
    foreach ($monkeys as $monkeyId => $monkeh) {
        $monkey = $monkeys[$monkeyId];
        $items = $monkey['items'];

        foreach ($items as $item) {
            $calc = str_replace('old', $item, $monkey['operation']);
            $worry = calculateString($calc);
            $worry = floor($worry / 3);

            if ($worry % $monkey['test'] === 0) {
                $monkeys[$monkey['true']]['items'][] = $worry;
            } else {
                $monkeys[$monkey['false']]['items'][] = $worry;
            }

            $monkeys[$monkeyId]['count']++;
        }

        $monkeys[$monkeyId]['items'] = [];
    }

    /*
    print_r('After Round: ' . $round . PHP_EOL);
    foreach ($monkeys as $monkeyId => $monkey) {
        print_r("Monkey $monkeyId: " . implode(', ', $monkey['items']) . PHP_EOL);
    }
    */
}

$counts = [];

foreach ($monkeys as $monkeyId => $monkey) {
    $counts[] = $monkey['count'];
    print_r("Monkey $monkeyId inspected items " . $monkey['count'] . " times." . PHP_EOL);
}

rsort($counts);

print_r("Part 1: Monkey Business = " . ($counts[0] * $counts[1]) . PHP_EOL);
