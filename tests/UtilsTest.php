<?php

class UtilsTest extends \PHPUnit\Framework\TestCase{
    public function testgetPaymentDate(){
        $utils=new Payroll\Utils\Utils();

        $payment_date=$utils->getPaymentDate('2022-01-01');

        $this->assertEquals('2022-01-31',$payment_date);
    }

    public function testgetBonusDate(){
        $utils=new Payroll\Utils\Utils();

        $bonus_date=$utils->getBonusDate('2022-01-10');

        $this->assertEquals('2022-01-10',$bonus_date);
    }
}