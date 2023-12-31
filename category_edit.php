<?php
include 'conn.php';

$sql = "select * from category where id= '" . $_POST['id'] . "'";
$result = mysqli_query($conn,$sql);

$data = mysqli_fetch_assoc($result);
if($result)
{

    $res['name'] = $data['name'];

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