<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day1Command extends Command
{
    protected static $defaultName = 'app:day1';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $numbers = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day1.txt"));

        $prev = 1000000;
        $increase = 0;
        foreach ($numbers as $x) {
            if ($x > $prev)  {
                $increase++;
            }
            $prev = $x;
        }

        $io->success("$increase measurements are larger than the previous");

        $prev = 1000000;
        $increase = 0;
        foreach ($numbers as $i => $x) {
            if (isset($numbers[$i + 2])) {
                $sum = $numbers[$i] + $numbers[$i + 1] + $numbers[$i + 2];
                if ($sum > $prev)  {
                    $increase++;
                }
                $prev = $sum;
            }
        }

        $io->success("$increase three-measurements sliding windows are larger than the previous");

        return Command::SUCCESS;
    }
}
