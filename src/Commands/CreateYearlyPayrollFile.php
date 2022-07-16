<?php

namespace Payroll\Commands;

use Payroll\Utils\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateYearlyPayrollFile extends Command
{

    protected static $defaultName = 'enter-period';
    protected static $defaultDescription = 'Creates payroll from month and year entered, please use m/y format';


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $utils=new Utils();
        $requestdate = $utils->OutputResponse($input,$output,2,'Enter Month/Year');

        $requestdate='01/'.$requestdate;
        $requestdate=date('d/m/Y',strtotime($requestdate));

        $lastdateofthemonth=date('Y-m-t',strtotime($requestdate));


        $lastworkingday = date('l', strtotime($lastdateofthemonth));

        if($lastworkingday == "Saturday") {
            $newdate = strtotime ('-1 day', strtotime($lastdateofthemonth));
            $lastworkingday = date ('Y-m-j', $newdate);
        }
        elseif($lastworkingday == "Sunday") {
            $newdate = strtotime ('-2 day', strtotime($lastdateofthemonth));
            $lastworkingday = date ( 'Y-m-j' , $newdate );
        }

        $payroll_details = array(
            array(
                "Period: " . date("M",strtotime($lastdateofthemonth)) . "/" . date('Y',strtotime($lastdateofthemonth)),
                "Basic Payment: " . date('Y-m-d',strtotime($lastworkingday)),
                "Bonus Payment: " . date('Y-m-d',strtotime($lastworkingday))
            )
        );

        if (!file_exists("./files/payrolldates.csv")) {
            $message="File successfully created";
        }else{
            $message="File contents replaced".$lastdateofthemonth;
        }
        $file = fopen("./files/payrolldates.csv", 'a');
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