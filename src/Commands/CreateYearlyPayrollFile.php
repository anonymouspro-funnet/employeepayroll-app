<?php

namespace Payroll\Commands;

use Payroll\Utils\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateYearlyPayrollFile extends Command
{

    protected static $defaultName = 'enter-year';
    protected static $defaultDescription = 'Creates payroll by year';


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $utils = new Utils();
        $request_year = $utils->OutputResponse($input, $output, 2, 'Enter Year');

        for ($m = 1; $m <= 12; $m++) {


            $first_date_of_month = $request_year . "-" . $m . "-01";
            $tenth_date_of_month = $request_year . "-" . $m . "-10";
            $first_date_of_month = date("Y-m-d", strtotime($first_date_of_month));

            $payment_date = $utils->getPaymentDate($first_date_of_month);
            $bonus_date = $utils->getBonusDate($tenth_date_of_month);



            $monthName = date('F', mktime(0, 0, 0, $m, 10));
            $payroll_details = array(
                array(
                    "Period: " . $monthName . "/" . $request_year,
                    "Basic Payment: " . $payment_date,
                    "Bonus Payment: " . $bonus_date
                )
            );
            $utils->populateCSV($payroll_details,$input,$output);

        }


        return Command::SUCCESS;
    }
}