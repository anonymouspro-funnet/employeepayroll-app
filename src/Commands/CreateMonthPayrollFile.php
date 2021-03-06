<?php

namespace Payroll\Commands;

use Payroll\Utils\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateMonthPayrollFile extends Command
{

    protected static $defaultName = 'enter-period';
    protected static $defaultDescription = 'Creates payroll from month and year entered, please use m/y format';


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $utils=new Utils();
        $request_date = $utils->OutputResponse($input,$output,2,'Enter Month/Year');

        $date_arr = preg_split ("/\//", $request_date);
        $first_date_of_month=$date_arr[1]."-".$date_arr[0]."-01";
        $tenth_date_of_month=$date_arr[1]."-".$date_arr[0]."-10";
        $first_date_of_month=date("Y-m-d",strtotime($first_date_of_month));

        $payment_date=$utils->getPaymentDate($first_date_of_month);
        $bonus_date=$utils->getBonusDate($tenth_date_of_month);


        $request_date='01/'.$request_date;
        $request_date=date('d/m/Y',strtotime($request_date));

        $payroll_details = array(
            array(
                "Period: " . date("M",strtotime($request_date)) . "/" . date('Y',strtotime($request_date)),
                "Basic Payment: " . $payment_date,
                "Bonus Payment: " . $bonus_date
            )
        );

        $utils->populateCSV($payroll_details,$input,$output);

        return Command::SUCCESS;
    }
}