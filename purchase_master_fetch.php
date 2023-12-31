<?php
include 'conn.php';

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
    $res['message'] = "Data Not Found";
}

$jsonData = json_encode($res);
echo $jsonData;



?>