<?php

namespace MVC;

class Ktra
{
    public function ktra($x,array $aArray)
    {
        if ($aArray[$x] == $aArray[$x - 1] && $aArray[$x] == $aArray[$x + 1])
            return true;
        if ($aArray[$x] == $aArray[$x + 1] && $aArray[$x] == $aArray[$x + 2])
            return true;
        if ($aArray[$x] == $aArray[$x - 1] && $aArray[$x] == $aArray[$x - 2])
            return true;
        return false;
    }
}

