<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Day4Command extends Command
{
    protected static $defaultName = 'app:day4';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lines = explode("\n", file_get_contents(dirname(__DIR__)."../../input/day4.txt"));

        $numbers = explode(',', $lines[0]);

        $boards = $this->readBoards($lines);

        $winner = [];
        for ($i = 0; $i < count($numbers); $i++) {
            $winner['number'] = $numbers[$i];
            for ($j = 0; $j < count($boards); $j++) {
                if ($this->markAndCheck($boards[$j], $numbers[$i])) {
                    $winner['board'] = $boards[$j];
                    break 2;
                }
            }
        }

        $sum = 0;
        for ($i = 0; $i < count($winner['board']); $i++) {
            for ($j = 0; $j < count($winner['board'][$i]); $j++) {
                if ($winner['board'][$i][$j] > 0) {
                    $sum += $winner['board'][$i][$j];
                }
            }
        }

        $io->success("Part 1:The winning number is ".$winner['number'].", the sum of the winning board is $sum, the product is ".$winner['number'] * $sum);

        $boards = $this->readBoards($lines);

        $winner = [];
        for ($i = 0; $i < count($numbers); $i++) {
            $winner['number'] = $numbers[$i];
            for ($j = 0; $j < count($boards); $j++) {
                if ($this->markAndCheck($boards[$j], $numbers[$i])) {
                    if (count($boards) == 1) {
                        $winner['board'] = $boards[$j];
                    }
                    unset($boards[$j]);
                    $j--;
                    $boards = array_values($boards);
                }
            }
            if (count($boards) == 0) {
                break;
            }
        }

        $sum = 0;
        for ($i = 0; $i < count($winner['board']); $i++) {
            for ($j = 0; $j < count($winner['board'][$i]); $j++) {
                if ($winner['board'][$i][$j] > 0) {
                    $sum += $winner['board'][$i][$j];
                }
            }
        }

        $io->success("Part 2: The winning number is ".$winner['number'].", the sum of the winning board is $sum, the product is ".$winner['number'] * $sum);


        return Command::SUCCESS;
    }

    private function readBoards($lines)
    {
        $boards = [];
        $counter = 0;
        $row = 0;
        for ($i = 2; $i < count($lines); $i++) {
            if ($lines[$i] == "") {
                $counter++;
                $row = 0;
            } else {
                $boards[$counter][$row++] = explode(' ', preg_replace("/\s+/", " ", trim($lines[$i])));
            }
        }

        return $boards;
    }

    private function markAndCheck(&$board, $number) {
        //mark
        for ($i = 0; $i < count($board); $i++) {
            for ($j = 0; $j < count($board[$i]); $j++) {
                if ($board[$i][$j] == $number) {
                    $board[$i][$j] = -1;
                }
            }
        }

        //check row
        for ($i = 0; $i < count($board); $i++) {
            $ok = true;
            for ($j = 0; $j < count($board[$i]); $j++) {
                if ($board[$i][$j] != -1) {
                    $ok = false;
                }
            }
            if ($ok) {
                return true;
            }
        }

        //check col
        for ($i = 0; $i < count($board); $i++) {
            $ok = true;
            for ($j = 0; $j < count($board[$i]); $j++) {
                if ($board[$j][$i] != -1) {
                    $ok = false;
                }
            }
            if ($ok) {
                return true;
            }
        }

        return false;
    }

    private function printBoard($board) {
        for ($i = 0; $i < count($board); $i++) {
            for ($j = 0; $j < count($board[$i]); $j++) {
                printf("%3d ", $board[$i][$j]);
            }
            echo "\n";
        }
        echo "\n";
    }
}
