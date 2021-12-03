<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day3Command extends Command
{
    protected static $defaultName = 'app:day3';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $numbers = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day3.txt"));

        $width = strlen($numbers[0]);

        $temp = [];
        for ($i = 0; $i < $width; $i++) {
            $temp[$i] = 0;
        }
        foreach ($numbers as $number) {
            for ($i = 0; $i < $width; $i++) {
                if ($number[$i] == 0) {
                    $temp[$i]--;
                } else {
                    $temp[$i]++;
                }
            }
        }
        for ($i = 0; $i < $width; $i++) {
            if ($temp[$i] > 0) {
                $temp[$i] = 1;
            } else {
                $temp[$i] = 0;
            }
        }

        $gamma = bindec(implode('', $temp));
        $epsilon = pow(2, $width) - $gamma - 1;

        $io->success("The product of gamma and epsilon position is " . ($gamma * $epsilon));

        $oxygen = bindec($this->reduce($numbers, 0));
        $co2 = bindec($this->reduce($numbers, 1));

        $io->success("The product of oxygen and co2 position is " . ($oxygen * $co2));

        return Command::SUCCESS;
    }

    private function reduce($numbers, $param)
    {
        $position = 0;
        while(count($numbers) > 1) {
            $temp = 0;
            foreach ($numbers as $number) {
                if ($number[$position] == 0) {
                    $temp--;
                } else {
                    $temp++;
                }
            }

            foreach ($numbers as $key => $number) {
                if ($temp == 0 && $number[$position] == $param) {
                    unset($numbers[$key]);
                }
                if ($temp > 0 && $number[$position] == $param) {
                    unset($numbers[$key]);
                }
                if ($temp < 0 && $number[$position] == 1 - $param) {
                    unset($numbers[$key]);
                }
            }
            $position++;
        }

        return array_values($numbers)[0];
    }
}
