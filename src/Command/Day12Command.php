<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day12Command extends Command
{
    protected static $defaultName = 'app:day12';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day12.txt"));

        $this->connections = [];
        foreach ($lines as $line) {
            list($from, $to) = explode("-", $line);
            $this->connections[$from][] = $to;
            $this->connections[$to][] = $from;
        }

        $part1 = $this->step("start", "start");

        $io->success("Part1: The number of paths is $part1");

        $part2 = $this->step("start", "start", true);

        $io->success("Part2: The number of paths is $part2");

        return Command::SUCCESS;
    }

    private function step($currentPath, $current, $doubeAllowed = false, $visits = [])
    {
        $paths = 0;
        foreach ($this->connections[$current] as $destination) {
            if ($destination == "end") {
                $paths++;
            } elseif ($destination == "start") {
                //do nothing
            } else {
                if (!isset($visits[$destination])) {
                    $visits[$destination] = 0;
                }
                $twos = $this->countTwos($visits);
                if ($visits[$destination] == 0 || ($visits[$destination] == 1 && $twos == 0 && $doubeAllowed) || strtolower($destination) != $destination) {
                    $visits[$destination]++;
                    $paths += $this->step($currentPath . "-" . $destination, $destination, $doubeAllowed, $visits);
                    $visits[$destination]--;
                }
            }
        }

        return $paths;
    }

    private function countTwos($visits)
    {
        $count = 0;
        foreach ($visits as $key => $value) {
            if (strtolower($key) == $key) {
                $count += ($value == 2 ? 1 : 0);
            }
        }

        return $count;
    }
}
