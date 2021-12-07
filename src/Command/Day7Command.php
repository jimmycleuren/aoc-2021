<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day7Command extends Command
{
    protected static $defaultName = 'app:day7';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $start = explode(",", file_get_contents(dirname(__DIR__)."../../input/day7.txt"));

        $part1 = $this->calculate($start, false);
        $io->success("Part1: The lowest fuel consumption is $part1");

        $part2 = $this->calculate($start, true);
        $io->success("Part2: The lowest fuel consumption is $part2");

        return Command::SUCCESS;
    }

    private function calculate(array $start, bool $increase)
    {
        $min = 1000000000;
        for ($i = 0; $i < count($start); $i++) {
            $current = 0;
            foreach ($start as $item) {
                $current += $increase ? array_sum(range(1, abs($item - $i))) : abs($item - $i);
            }
            $min = $current < $min ? $current : $min;
        }

        return $min;
    }
}
