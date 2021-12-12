<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day10Command extends Command
{
    protected static $defaultName = 'app:day10';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day10.txt"));

        $corruptSum = 0;
        $incompleteScores = [];
        foreach ($lines as $line) {
            $stack = [];
            $corrupt = false;
            for ($i = 0; $i < strlen($line); $i++) {
                if (in_array($line[$i], ['(', '[', '{', '<'])) {
                    array_push($stack, $line[$i]);
                } elseif (in_array($line[$i], [')', ']', '}', '>'])) {
                    $item = array_pop($stack);
                    if ($item == '(' && $line[$i] == ')') {
                        continue;
                    } elseif ($item == '[' && $line[$i] == ']') {
                        continue;
                    } elseif ($item == '{' && $line[$i] == '}') {
                        continue;
                    } elseif ($item == '<' && $line[$i] == '>') {
                        continue;
                    } else {
                        $corrupt = true;
                        switch ($line[$i]) {
                            case ')':
                                $corruptSum += 3;
                                break;
                            case ']':
                                $corruptSum += 57;
                                break;
                            case '}':
                                $corruptSum += 1197;
                                break;
                            case '>':
                                $corruptSum += 25137;
                                break;
                        }
                    }
                }
            }
            if (count($stack) > 0 && !$corrupt) {
                $score = 0;
                $stack = array_reverse($stack);
                foreach ($stack as $item) {
                    $score *= 5;
                    switch ($item) {
                        case '(':
                            $score += 1;
                            break;
                        case '[':
                            $score += 2;
                            break;
                        case '{':
                            $score += 3;
                            break;
                        case '<':
                            $score += 4;
                            break;
                    }
                }
                $incompleteScores[] = $score;
            }
        }

        var_Dump($incompleteScores);

        $io->success("Part1: The syntax error score is $corruptSum");

        sort($incompleteScores);
        $io->success("Part2: The incomplete score is ".$incompleteScores[(count($incompleteScores) - 1) / 2]);

        return Command::SUCCESS;
    }
}
