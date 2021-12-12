<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day11Command extends Command
{
    protected static $defaultName = 'app:day11';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day11.txt"));

        $this->grid = [];
        foreach ($lines as $line) {
            $this->grid[] = str_split($line);
        }

        $part1 = 0;
        $step = 0;
        $currentFlashes = 0;
        while ($currentFlashes < 100) {
            $currentFlashes = 0;
            for ($j = 0; $j < count($this->grid); $j++) {
                for ($k = 0; $k < count($this->grid[$j]); $k++) {
                    $this->grid[$j][$k]++;
                }
            }
            do {
                $temp = $this->checkFlashes();
                if ($step < 100) {
                    $part1 += $temp;
                }
                $currentFlashes += $temp;
            } while ($temp > 0);

            $step++;
        }

        $io->success("Part1: The number of flashes after step 100 is $part1");

        $io->success("Part2: The step where all octopuses flash is $step");

        return Command::SUCCESS;
    }

    private function checkFlashes() {
        $flashes = 0;

        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid[$i]); $j++) {
                if ($this->grid[$i][$j] > 9) {
                    $this->grid[$i][$j] = 0;
                    $flashes++;
                    for ($k = -1; $k <= 1; $k++) {
                        for ($l = -1; $l <= 1; $l++) {
                            if (isset($this->grid[$i + $k][$j + $l]) && $this->grid[$i + $k][$j + $l] > 0) {
                                $this->grid[$i + $k][$j + $l]++;
                            }
                        }
                    }
                }
            }
        }

        return $flashes;
    }
}
