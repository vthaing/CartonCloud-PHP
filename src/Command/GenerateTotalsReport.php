<?php
/**
 * Created by PhpStorm.
 * User: thain
 * Date: 5/8/2020
 * Time: 2:41 PM
 */

namespace App\Command;


use BearClaw\Warehousing\TotalsCalculator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class GenerateTotalsReport extends Command
{
    protected static $defaultName = 'app:generate-total-report';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $calculator = new TotalsCalculator();
        $calculator->generateReport([2344, 2345, 2346]);
        return 0;
    }
}