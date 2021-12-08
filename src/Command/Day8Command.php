<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day8Command extends Command
{
    protected static $defaultName = 'app:day8';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day8.txt"));

        $part1 = 0;
        foreach ($lines as $line) {
            list($input, $output) = explode("|", $line);
            $output = explode(" ", trim($output));
            foreach ($output as $digit) {
                if (strlen($digit) < 5 || strlen($digit) == 7) {
                    $part1++;
                }
            }
        }

        $io->success("Part1: The total number of occurences of 1, 4, 7 or 8 is $part1");

        $digits = [
            0 => "1110111",
            1 => "0010010",
            2 => "1011101",
            3 => "1011011",
            4 => "0111010",
            5 => "1101011",
            6 => "1101111",
            7 => "1010010",
            8 => "1111111",
            9 => "1111011",
        ];
        $values = [
            'abcefg' => 0,
            'cf' => 1,
            'acdeg' => 2,
            'acdfg' => 3,
            'bcdf' => 4,
            'abdfg' => 5,
            'abdefg' => 6,
            'acf' => 7,
            'abcdefg' => 8,
            'abcdfg' => 9,
        ];

        $part2 = 0;
        foreach ($lines as $line) {
            list($inputs, $outputs) = explode("|", $line);
            $mapping = $this->map(explode(' ', trim($inputs)), $digits);
            $number = 0;
            foreach (explode(' ', trim($outputs)) as $output) {
                $translation = [];
                for ($i = 0; $i < strlen($output); $i++) {
                    $translation[] = $mapping[$output[$i]];
                }
                sort($translation);
                $translation = implode('', $translation);
                $number = $number * 10 + $values[$translation];
            }
            $part2 += $number;
        }

        $io->success("Part2: The sum of all outputs is $part2");

        return Command::SUCCESS;
    }

    private function map($inputs, $digits)
    {
        $combinations = $this->generate(['a', 'b', 'c', 'd', 'e', 'f', 'g']);
        foreach ($combinations as $combination) {
            $ok = true;
            foreach ($inputs as $input) {
                $temp = $this->combine($input, $combination);
                if (!in_array($temp, $digits)) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) {
                return [
                    $combination[0] => 'a',
                    $combination[1] => 'b',
                    $combination[2] => 'c',
                    $combination[3] => 'd',
                    $combination[4] => 'e',
                    $combination[5] => 'f',
                    $combination[6] => 'g',
                ];
            }
        }
    }

    private function combine($input, $combination)
    {
        $res = '';
        $input = str_split($input);
        for ($i = 0; $i < strlen($combination); $i++) {
            if (in_array($combination[$i], $input)) {
                $res .= '1';
            } else {
                $res .= '0';
            }
        }

        return $res;
    }

    private function generate($options, $current = '', $results = [])
    {
        foreach ($options as $key => $option) {
            $newOptions = $options;
            unset($newOptions[$key]);
            if (count($newOptions) > 0) {
                $results = array_unique(array_merge($results, $this->generate($newOptions, $current . $option, $results)));
            } else {
                return [$current . $option];
            }
        }

        return $results;
    }
}
