<?php
include 'conn.php';

$sql = "Select * from category";
$result = mysqli_query($conn, $sql);  

if($result)
{
    $i = 0;
    while($data = mysqli_fetch_assoc($result))
    {
        $res['categorydata'][$i]['id'] = $data['id'];
        $res['categorydata'][$i]['name'] = $data['name'];
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

$jsondata = json_encode($res);
echo $jsondata;
?>