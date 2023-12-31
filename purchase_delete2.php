<?php

include 'conn.php';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';

$sql = "delete from purchasetbl1 where id = '$purchaseid'";

$result = mysqli_query($conn,$sql);

$sql = "delete from purchasetbl2 where purchaseid = '$purchaseid'";
$result2 = mysqli_query($conn,$sql);

if($result && $result2)
{
    $res['status'] = 1;
    $res['message'] = "Data Deleted";
}
else
{
    $res['status'] = 0;
    $res['message'] = "Data Not Deleted";
}

echo json_encode($res);
?>