<?php


use MVC\KtraNguyenTo;
use PHPUnit\Framework\TestCase;

class KtraNguyenToTest extends TestCase
{

    private $ktra;

    protected function newKtra()
    {
        $this->ktra = new MVC\KtraNguyenTo();
        return $this->ktra;
    }

    public function testIsNT()
    {
        $this->assertTrue($this->newKtra()->isNT(13));
    }

    public function testIsNT1()
    {
        $this->assertTrue($this->newKtra()->isNT(17));
    }

    public function testIsNT2()
    {
        $this->assertFalse($this->newKtra()->isNT(10));
    }

    public function testIsNT3()
    {
        $this->assertFalse($this->newKtra()->isNT(0));
    }
}
