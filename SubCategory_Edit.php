<?php
include 'conn.php';

$sql = "select * from subcategory where id='" . $_POST['id'] . "'";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($result);
if($result)
{
    $res['catid'] = $data['catid'];
    $res['subcatname'] = $data['subcatname'];
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