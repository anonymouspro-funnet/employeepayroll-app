<?php

namespace Payroll\Utils;

use Symfony\Component\Console\Style\SymfonyStyle;

class Utils
{
    public function OutputResponse($input,$output,$status, $message)
    {
        $io = new SymfonyStyle($input, $output);
        if ($status == 1) {

                $io->success($message);

        } else {
            $io->error(sprintf('Something went wrong %s', $message));

        }
    }
}