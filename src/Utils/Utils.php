<?php

namespace Payroll\Utils;

use Symfony\Component\Console\Style\SymfonyStyle;

class Utils
{
    public function OutputResponse($input, $output, $status, $message)
    {
        $io = new SymfonyStyle($input, $output);
        if ($status == 1) {

            $io->success($message);

        } elseif ($status == 2) {
            return $io->ask($message);
        } else {
            $io->error(sprintf('Something went wrong %s', $message));

        }
    }


    public function getPaymentDate($date): string
    {


        $last_date_of_the_month=date('Y-m-t',strtotime($date));
        $last_working_day = date('l', strtotime($last_date_of_the_month));

        if($last_working_day == "Saturday") {
            $new_date = strtotime ('-1 day', strtotime($last_date_of_the_month));
            $last_date_of_the_month = date ('Y-m-d', $new_date);
        }
        elseif($last_working_day == "Sunday") {
            $new_date = strtotime ('-2 day', strtotime($last_date_of_the_month));
            $last_date_of_the_month = date ( 'Y-m-d' , $new_date );
        }
        return $last_date_of_the_month;
    }


    public function getBonusDate($date): string
    {

        $bonus_date=date('Y-m-d',strtotime($date));
        $bonus_day = date('l', strtotime($bonus_date));

        if($bonus_day == "Saturday") {
            $bonus_date = date('Y-m-d', strtotime($bonus_date. ' + 2 days'));
        }
        elseif($bonus_day == "Sunday") {
            $bonus_date = date('Y-m-d', strtotime($bonus_date. ' + 1 days'));
        }

        return $bonus_date;
    }
}