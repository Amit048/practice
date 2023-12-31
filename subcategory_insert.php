<?php
include 'conn.php';

$catid = $_POST['catid'];
$subcatname = $_POST['subcatname'];

$sql = "insert into subcategory(catid,subcatname) values ('$catid','$subcatname')";

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