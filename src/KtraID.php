<?php


namespace MVC;

include __DIR__ . "/../db/connect.php";

class KtraID
{
    private $con;

    protected function connect()
    {
        $this->con = mysqli_connect('127.0.0.1', 'dkmmysql', 'root', 'huy_izcms');
        return $this->con;
    }

    //xac nhan truy van co so du lieu
//    function confirmQuery($res, $que)
//    {
//        $con = $this->connect();
//        if (empty($res)) {
//            die("Query: {$que} \n<br/>  Error: " . mysqli_error($con));
//        }
//    }

    // truy van co so du lieu, xac nhan lenh truy van co thuc hien khong -> roi tra ve ket qua
    function resultQuery($que)
    {
        $con = $this->connect();
        $res = mysqli_query($con, $que);
        if (empty($res))
            return false;
        else
            return $res;
    }

    function checkID($clomun, $getId, $idSelect, $tableSelect)
    {
        $que = "SELECT $idSelect FROM $tableSelect";
        $que .= " WHERE $clomun = {$getId}";
        $res = $this->resultQuery($que);
        if (mysqli_num_rows($res) == 0) { // $cid ko hợp lệ sẽ false
            return false;
        } else {
            return true;
        }
    }
}