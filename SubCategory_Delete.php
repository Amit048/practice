<?php
include 'conn.php';

$sql = "delete from subcategory where id= '" . $_POST['id'] . "'";
$result = mysqli_query($conn,$sql);

if($result)
{
    $res['status'] = 1;
    $res['message'] = "Data Delete";
}
else
{
    $res['status'] = 0;
    $res['message'] = "Data Not Delete";
}

$jsondata = json_encode($res);
echo $jsondata;

?>