<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day2Command extends Command
{
    protected static $defaultName = 'app:day2';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $commands = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day2.txt"));

        $horizontal = 0;
        $depth = 0;
        foreach ($commands as $command) {
            list($action, $parameter) = explode(" ", $command);
            switch($action) {
                case 'forward':
                    $horizontal += $parameter;
                    break;
                case 'up':
                    $depth -= $parameter;
                    break;
                case 'down':
                    $depth += $parameter;
                    break;
            }
        }

        $io->success("The product of depth and horizontal position is " . ($horizontal * $depth));

        $horizontal = 0;
        $depth = 0;
        $aim = 0;
        foreach ($commands as $command) {
            list($action, $parameter) = explode(" ", $command);
            switch($action) {
                case 'forward':
                    $horizontal += $parameter;
                    $depth += ($aim * $parameter);
                    break;
                case 'up':
                    $aim -= $parameter;
                    break;
                case 'down':
                    $aim += $parameter;
                    break;
            }
        }

        $io->success("The product of depth and horizontal position is " . ($horizontal * $depth));

        return Command::SUCCESS;
    }
}
