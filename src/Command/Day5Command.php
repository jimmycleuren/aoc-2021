<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day5Command extends Command
{
    protected static $defaultName = 'app:day5';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day5.txt"));

        $part1 = $this->calculate($lines, false);
        $io->success("Part1: The number of points where at least 2 lines overlap is $part1");

        $part2 = $this->calculate($lines, true);
        $io->success("Part2: The number of points where at least 2 lines overlap is $part2");

        return Command::SUCCESS;
    }

    private function calculate($lines, bool $diagonal) {
        $grid = [];
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $grid[$i][$j] = 0;
            }
        }
        foreach ($lines as $line) {
            preg_match("/(\d+),(\d+) \-\> (\d+),(\d+)/", $line, $matches);
            $x1 = $matches[1];
            $y1 = $matches[2];
            $x2 = $matches[3];
            $y2 = $matches[4];

            if ($x1 != $x2 && $y1 != $y2 && !$diagonal) {
                continue;
            }

            if ($x1 != $x2 && $y1 != $y2) {
                for ($i = 0; $i <= abs($x1 - $x2); $i++) {
                    $o1 = $x1 < $x2 ? $i : -$i;
                    $o2 = $y1 < $y2 ? $i : -$i;
                    if (!isset($grid[$x1 + $o1][$y1 + $o2])) {
                        $grid[$x1 + $o1][$y1 + $o2] = 0;
                    }
                    $grid[$x1 + $o1][$y1 + $o2]++;
                }
            } elseif ($x1 != $x2) {
                for ($i = min($x1, $x2); $i <= max($x1, $x2); $i++) {
                    if (!isset($grid[$i][$y1])) {
                        $grid[$i][$y1] = 0;
                    }
                    $grid[$i][$y1]++;
                }
            } elseif ($y1 != $y2) {
                for ($i = min($y1, $y2); $i <= max($y1, $y2); $i++) {
                    if (!isset($grid[$x1][$i])) {
                        $grid[$x1][$i] = 0;
                    }
                    $grid[$x1][$i]++;
                }
            }
        }

        $result = 0;
        foreach ($grid as $row) {
            foreach ($row as $value) {
                if ($value > 1) {
                    $result++;
                }
            }
        }

        return $result;
    }
}
