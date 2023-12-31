<?php
include 'conn.php';

/*$catid = $_POST['catid'];
$subcatid = $_POST['subcatid'];
$itemname = $_POST['itemname'];
$itemno = $_POST['itemno'];
$itemamount = $_POST['itemamount'];*/

$sql = "update item set catid= '" . $_POST['catid'] . "', subcatid= '" . $_POST['subcatid'] . "', itemname= '" . $_POST['itemname'] . "', itemno= '" . $_POST['itemno'] . "',itemamount= '" . $_POST['itemamount'] . "' where id='" . $_POST['id'] . "'";

$result = mysqli_query($conn,$sql);
if($result)
{
    $res['status'] = 1;
    $res['message'] = "Data Updated";
}
else
{
    $res['status'] = 0;
    $res['message'] = "Data Not Updated";
}

$jsonData = json_encode($res);
echo $jsonData;

?>