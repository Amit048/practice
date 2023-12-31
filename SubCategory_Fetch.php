<?php
include 'conn.php';

$catid = isset($_POST['catid']) ? $_POST['catid'] : '';
$flag = isset($_POST['flag']) ? $_POST['flag'] : '';

if($flag == 1)
{
    $sql = "select s.id, c.name as catid, s.subcatname from category c inner join subcategory s on  c.id = s.catid where c.id = '$catid'";
}
else
{
    $sql = "select s.id, c.name as catid, s.subcatname from category c inner join subcategory s on  c.id = s.catid";
}



$result = mysqli_query($conn,$sql);

if($result)
{
    $i = 0;
    while($data = mysqli_fetch_assoc($result))
    {
        $res['categorydata'][$i]['id'] = $data['id'];
        $res['categorydata'][$i]['catid'] = $data['catid'];
        $res['categorydata'][$i]['subcatname'] = $data['subcatname'];
        $i++;
    }
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
}
else
{
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
}

$jsondata = json_encode($res);
echo $jsondata;

?>