<?php

include 'conn.php';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';


$sql = "select * from purchasetbl1 where id = '$purchaseid'";
$result = mysqli_query($conn,$sql);

$data = mysqli_fetch_assoc($result);

if($result)
{
    $res['purchasename'] = $data['purchasename'];
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
}
else
{
    $res['status'] = 0;
    $res['message'] = "No Data Found";
}

$sql = "select * from purchasetbl2 where purchaseid = '$purchaseid'";
$result = mysqli_query($conn,$sql);

if($result)
{
    $i = 0;
    while($data = mysqli_fetch_assoc($result))
    {
        //$res['categorydata'][$i]['id'] = $data['id'];
        //$res['categorydata'][$i]['purchaseid'] = $data['purchaseid'];
        $res['categorydata'][$i]['catid'] = $data['catid'];
        $res['categorydata'][$i]['catname'] = $data['catname'];
        $res['categorydata'][$i]['subcatid'] = $data['subcatid'];
        $res['categorydata'][$i]['subcatname'] = $data['subcatname'];
        $res['categorydata'][$i]['itemid'] = $data['itemid'];
        $res['categorydata'][$i]['itemname'] = $data['itemname'];
        $res['categorydata'][$i]['itemamount'] = $data['itemamount'];
        $res['categorydata'][$i]['quantity'] = $data['quantity'];
        $i++;
    }
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
}
else
{
    $res['status'] = 0;
    $res['message'] = "No Data Found";
}

echo json_encode($res);
?>