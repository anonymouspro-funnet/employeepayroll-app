<?php

namespace Payroll\Commands;

use Payroll\Utils\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePayrollFile extends Command
{

    protected static $defaultName = 'create-payroll';
    protected static $defaultDescription = 'Creates a new payroll file.';


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $utils=new Utils();

        $payroll_details = array(
            array(
                "Period: " . date("M") . "/" . date('Y'),
                "Basic Payment: " . date('Y-m-d'),
                "Bonus Payment: " . date('Y-m-d')
            )
        );

        $utils->populateCSV($payroll_details,$input,$output);

        return Command::SUCCESS;
    }
}