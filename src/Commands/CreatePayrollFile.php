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

        if (!file_exists("./files/payrolldates.csv")) {
            $message="File successfully created";
        }else{
            $message="File contents replaced";
        }
        $file = fopen("./files/payrolldates.csv", 'w+');
        if ($file === false) {
            $utils->OutputResponse($input,$output,0,'Cannot open the file ');
            die();
        }
        foreach ($payroll_details as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        $utils->OutputResponse($input,$output,1,$message);
        return Command::SUCCESS;
    }
}