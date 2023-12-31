<?php
include 'conn.php';

$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';
$sql = "select * from purchasetbl1";

$result = mysqli_query($conn,$sql);

if($result)
{
    $i = 0;
    while($data = mysqli_fetch_assoc($result))
    {
        $res['categorydata'][$i]['id'] = $data['id'];
        $res['categorydata'][$i]['purchasename'] = $data['purchasename'];
        $i++;
    }
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
}
else
{
    $res['status'] = 0;
    $res['message'] = "No Data Found";
}

echo json_encode($res);
?>