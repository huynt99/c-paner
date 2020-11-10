<?php

use MVC\Ktra;
use PHPUnit\Framework\TestCase;

class KtraTest extends TestCase
{

    private $ktra;

    protected function para()
    {
        $this->ktra = new MVC\Ktra();
        return $this;
    }

    public function testKtra()
    {
        $this->assertTrue($this->para()->ktra->Ktra(1, [1, 1, 1]));
    }

    public function testKtra2()
    {
        $this->assertTrue($this->para()->ktra->Ktra(1, [0, 1, 1, 1]));
    }

    public function testKtra3()
    {
        $this->assertTrue($this->para()->ktra->Ktra(2, array(1, 1, 1, 0)));
    }

    public function testKtra4()
    {
        $this->assertFalse($this->para()->ktra->Ktra(1, [0, 1, 2, 3]));
    }

}
