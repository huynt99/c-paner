<?php

//require "../vendor/autoload.php";

use MVC\KtraID;
use PHPUnit\Framework\TestCase;

class KtraIDTest extends TestCase
{
    private $test;

    protected function newTest()
    {
        $this->test = new MVC\KtraID();
        return $this->test;
    }

//    public function testResultQuery()
//    {
//        $que = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `pass`, `registrantion_date`)";
//        $que .= " VALUE ('Huhu', 'Haha', 'huhuhaha@gmail.com', '123', now())";
//        $this->assertTrue($this->newTest()->resultQuery($que));
//    }

    public function testCheckID()
    {
        $this->assertTrue($this->newTest()->checkID('user_id',10, '*', 'users'));
    }

    public function testCheckID1()
    {
        $this->assertTrue($this->newTest()->checkID('user_id',8, '*', 'users'));
    }

    public function testCheckID2()
    {
        $this->assertFalse($this->newTest()->checkID('user_id',99, '*', 'users'));
    }
}

