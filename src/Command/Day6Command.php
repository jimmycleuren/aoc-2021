<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day6Command extends Command
{
    protected static $defaultName = 'app:day6';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $start = explode(",", file_get_contents(dirname(__DIR__)."../../input/day6.txt"));

        $part1 = $this->calculate($start, 80);
        $io->success("Part1: The number of lanterfish is $part1");

        $part2 = $this->calculate($start, 256);
        $io->success("Part2: The number of lanterfish is $part2");

        return Command::SUCCESS;
    }

    private function calculate(array $population, int $days)
    {
        $pop = array_count_values($population);
        for ($i = 0; $i < $days; $i++) {
            for ($j = 1; $j < 10; $j++) {
                $newpop[$j - 1] = $pop[$j] ?? 0;
            }
            $newpop[6] = $newpop[6] ?? 0;
            $newpop[6] += $pop[0] ?? 0;
            $newpop[8] = $newpop[8] ?? 0;
            $newpop[8] += $pop[0] ?? 0;
            $pop = $newpop;
        }

        return array_sum($pop);
    }
}
