<?php
include 'conn.php';

$catid = $_POST['catid'];
$subcatid = $_POST['subcatid'];
$itemname = $_POST['itemname'];
$itemno = $_POST['itemno'];
$itemamount = $_POST['itemamount'];

$sql = "insert into item(catid,subcatid,itemname,itemno,itemamount) values ('$catid','$subcatid','$itemname','$itemno','$itemamount')";

$result = mysqli_query($conn,$sql);

if($result)
{
    $res['status'] = 1;
    $res['message'] = "Data Inserted";
}
else
{
    $res['status'] = 0;
    $res['message'] = "Data Not Inserted";
}

$jsondata = json_encode($res);
echo $jsondata;
?>