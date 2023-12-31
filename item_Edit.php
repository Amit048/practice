<?php
include 'conn.php';

$sql = "select * from item where id='" . $_POST['id'] . "'";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($result);
if($result)
{
    $res['catid'] = $data['catid'];
    $res['subcatid'] = $data['subcatid'];
    $res['itemname'] = $data['itemname'];
    $res['itemno'] = $data['itemno'];
    $res['itemamount'] = $data['itemamount'];
    
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
}
else
{
    $res['status'] = 0;
    $res['message'] = "Data Not Found";
}

$jsondata = json_encode($res);
echo $jsondata;

?>