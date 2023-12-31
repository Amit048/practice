<?php
include 'conn.php';

//$sql = "select * from item";


    $sql = "select i.id,i.itemname,i.itemno,i.itemamount, s.subcatname as subcatid,c.name as catid from item i inner join subcategory s on i.subcatid = s.id inner join category c on i.catid = c.id";


$result = mysqli_query($conn,$sql);
if($result)
{
    $i = 0;
    while($data = mysqli_fetch_assoc($result))
    {
        $res['categorydata'][$i]['id'] = $data['id'];
        $res['categorydata'][$i]['catid'] = $data['catid'];
        $res['categorydata'][$i]['subcatid'] = $data['subcatid'];
        $res['categorydata'][$i]['itemname'] = $data['itemname'];
        $res['categorydata'][$i]['itemno'] = $data['itemno'];
        $res['categorydata'][$i]['itemamount'] = $data['itemamount'];
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