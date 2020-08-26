<?php

define('base', 'http://localhost:8080/PHPBasic/izcms/');

//dieu huong trang
function redirectTo($page = 'index.php')
{
    $url = base . $page;
    header("Location: $url");
    die();
}

//xac nhan truy van co so du lieu 
function confirmQuery($res, $que)
{
    global $con;
    if (empty($res)) {
        die("Query: {$que} \n<br/>  Error: " . mysqli_error($con));
    }
}

//truy van co so du lieu, xac nhan lenh truy van co thuc hien khong -> roi tra ve ket qua
function resultQuery($que)
{
    global $con;
    $res = mysqli_query($con, $que);
    confirmQuery($res, $que);
    return $res;
}

//lam dep van ban hien thi tren trang 
function beautifyText($text)
{
    return substr($text, 0, strrpos($text, ' '));
}

//kiem tra $_GET['id'] tren url
function validateId($id)
{
    if (filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
        return $id;
    } else {
        return NULL;
    }
}

// kiem tra $_GET['id'] cung voi $_GET['name']
function validateIDName($id, $name)
{
    if (filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $aIdAndName = [
            $id,
            $name
        ];
        return $aIdAndName;
    } else {
        return NULL;
    }
}

//kiem tra id co trong csdl khong
function checkID($getId, $idSelect, $tableSelect)
{
    $que = "SELECT $idSelect FROM $tableSelect";
    $que .= " WHERE cat_id = {$getId}";
    $res = resultQuery($que);
    if (mysqli_num_rows($res) == 0) {
        // $cid ko hợp lệ sẽ thông báo 
        return "<p class='warning'>The categories does not exists</p>";
    } else {
        return NULL;
    }
}
