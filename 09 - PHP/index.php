<?php

class RopeBridge
{
    private $inputStr;
    private $steps;

    private $hCurrent = [ 'x' => 0, 'y' => 0 ];
    private $knots = [];

    private $defaultValue = '.';
    private $usedValue = '#';

    private $grid = [
        -1 => [ -1 => '.', 0 => '.', 1 => '.'],
        0 => [ -1 => '.', 0 => '#', 1 => '.'],
        1 => [ -1 => '.', 0 => '.', 1 => '.'],
    ];

    private $directionLookup = [
        'U' => [ 'x' => 0, 'y' => -1],
        'R' => [ 'x' => 1, 'y' => 0],
        'D' => [ 'x' => 0, 'y' => 1],
        'L' => [ 'x' => -1, 'y' => 0],
    ];


    public function __construct($numOfKnots, $part)
    {
        $this->numOfKnots = $numOfKnots;
        $this->initData();

        foreach ($this->steps as $sNum => $step) {
            list($direction, $distance) = explode(' ', $step);
            $dir = $this->directionLookup[$direction];

            for ($i = 1; $i <= $distance; $i++) {
                $newX = $this->hCurrent['x'] + $dir['x'];
                $newY = $this->hCurrent['y'] + $dir['y'];

                $this->performMove($newX, $newY, $sNum);
            }
        }

        $this->printGrid($this->grid);
        print_r("Part $part: " . $this->countVisited() . PHP_EOL);
    }


    private function initData()
    {
        $this->inputStr = file_get_contents('./input.txt');
        $this->steps = explode(PHP_EOL, $this->inputStr);

        for ($i = 1; $i <= $this->numOfKnots; $i++) {
            $this->knots[$i] = [ 'x' => 0, 'y' => 0 ];
        }
    }

    private function printGrid()
    {
        ksort($this->grid);

        foreach ($this->grid as $row) {
            ksort($row);

            foreach ($row as $col) {
                echo $col;
            }

            echo PHP_EOL;
        }
    }

    private function performMove($x, $y, $stepNum)
    {
        $this->checkCoordinateExists($x, $y);

        $this->hCurrent['x'] = $x;
        $this->hCurrent['y'] = $y;

        $lastX = $x;
        $lastY = $y;

        foreach ($this->knots as $knotNum => $knot) {
            $knotX = $knot['x'];
            $knotY = $knot['y'];

            $xDiff = $lastX - $knotX;
            $yDiff = $lastY - $knotY;

            if (abs($xDiff) > 1 || abs($yDiff) > 1) {
                $newX = $knotX;
                $newY = $knotY;

                $newX += $xDiff === 0 ? 0 : ($xDiff < 0 ? -1 : 1);
                $newY += $yDiff === 0 ? 0 : ($yDiff < 0 ? -1 : 1);

                $this->knots[$knotNum]['x'] = $newX;
                $this->knots[$knotNum]['y'] = $newY;

                $lastX = $newX;
                $lastY = $newY;

                // Track last knot
                if ($knotNum === count($this->knots)) {
                    $this->grid[$newY][$newX] = $this->usedValue;
                }
            } else {
                return;
            }
        }
    }

    private function countVisited()
    {
        $count = 0;

        foreach ($this->grid as $row) {
            foreach ($row as $val) {
                if ($val === $this->usedValue) $count++;
            }
        }

        return $count;
    }

    private function checkCoordinateExists($x, $y)
    {
        if (isset($this->grid[$y][$x])) return true;
        isset($this->grid[$y]) ? $this->addCol($x) : $this->addRow($y);
    }

    private function resortGrid()
    {
        ksort($this->grid);

        foreach ($this->grid as $rowKey => $row) {
            ksort($this->grid[$rowKey]);
        }
    }

    private function addRow($key)
    {
        $this->grid[$key] = [];

        foreach ($this->grid[0] as $index => $value) {
            $this->grid[$key][$index] = $this->defaultValue;
        }

        $this->resortGrid();
    }

    private function addCol($key)
    {
        foreach ($this->grid as $rowKey => $row) {
            $this->grid[$rowKey][$key] = $this->defaultValue;
        }

        $this->resortGrid();
    }
}

new RopeBridge(1, 1);
new RopeBridge(9, 2);
