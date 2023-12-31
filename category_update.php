<?php
include 'conn.php';

$sql = "update category set name = '" . $_POST['name'] . "' where id= '" . $_POST['id'] . "'";

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

$jsondata = json_encode($res);
echo $jsondata;


?>