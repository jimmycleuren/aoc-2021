<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day9Command extends Command
{
    protected static $defaultName = 'app:day9';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day9.txt"));

        $grid = [];
        foreach ($lines as $line) {
            $grid[] = str_split($line);
        }

        $sum = 0;
        $basins = [];
        for ($i = 0; $i < count($grid); $i++) {
            for ($j = 0; $j < count($grid[$i]); $j++) {
                $ok = true;
                if (isset($grid[$i - 1][$j]) && $grid[$i - 1][$j] <= $grid[$i][$j]) {
                    $ok = false;
                }
                if (isset($grid[$i + 1][$j]) && $grid[$i + 1][$j] <= $grid[$i][$j]) {
                    $ok = false;
                }
                if (isset($grid[$i][$j - 1]) && $grid[$i][$j - 1] <= $grid[$i][$j]) {
                    $ok = false;
                }
                if (isset($grid[$i][$j + 1]) && $grid[$i][$j + 1] <= $grid[$i][$j]) {
                    $ok = false;
                }
                if ($ok) {
                    $sum += $grid[$i][$j] + 1;
                    $basins[] = $this->findBasinSize($grid,$i, $j);
                }
            }
        }

        $io->success("Part1: The sum of all risk levels is $sum");

        asort($basins);
        $items = array_slice($basins, -3);

        $io->success("Part1: The product of the 3 largest basins is ".$items[0] * $items[1] * $items[2]);

        return Command::SUCCESS;
    }

    private function findBasinSize($grid, $i, $j): int
    {
        $this->done[] = $i.'-'.$j;
        $size = 1;

        if (isset($grid[$i - 1][$j]) && $grid[$i - 1][$j] < 9 && !in_array(($i - 1).'-'.$j, $this->done)) {
            $size += $this->findBasinSize($grid, $i - 1, $j);
        }
        if (isset($grid[$i + 1][$j]) && $grid[$i + 1][$j] < 9 && !in_array(($i + 1).'-'.$j, $this->done)) {
            $size += $this->findBasinSize($grid, $i + 1, $j);
        }
        if (isset($grid[$i][$j - 1]) && $grid[$i][$j - 1] < 9 && !in_array($i.'-'.($j - 1), $this->done)) {
            $size += $this->findBasinSize($grid, $i, $j - 1);
        }
        if (isset($grid[$i][$j + 1]) && $grid[$i][$j + 1] < 9 && !in_array($i.'-'.($j + 1), $this->done)) {
            $size += $this->findBasinSize($grid, $i, $j + 1);
        }

        return $size;
    }
}
