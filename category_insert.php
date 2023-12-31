<?php
include 'conn.php';
$name = $_POST['name'];
$sql = "insert into category(name) values ('$name')";

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