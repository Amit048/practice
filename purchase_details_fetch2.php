<?php
include 'conn.php';

$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';

$sql = "select p.itemamount, p.quantity, c.name as catid, s.subcatname as subcatid,i.itemname as itemid from purchasetbl2 p inner join item i on p.itemid = i.id inner join subcategory s on i.subcatid = s.id inner join category c on s.catid = c.id where p.purchaseid = '$purchaseid'";

$result = mysqli_query($conn,$sql);

if($result)
{
    $i = 0;
    while($data = mysqli_fetch_assoc($result))
    {
       // $res['categorydata'][$i]['id'] = $data['id'];
        //$res['categorydata'][$i]['purchaseid'] = $data['purchaseid'];
        $res['categorydata'][$i]['catid'] = $data['catid'];
        $res['categorydata'][$i]['subcatid'] = $data['subcatid'];
        $res['categorydata'][$i]['itemid'] = $data['itemid'];
        $res['categorydata'][$i]['itemamount'] = $data['itemamount'];
        $res['categorydata'][$i]['quantity'] = $data['quantity'];
        $i++;
    }
    $res['status'] = 1;
    $res['message'] = "Data Fetched";
} else {
    $res['status'] = 0;
    $res['message'] = "Data Not Found: " . mysqli_error($conn);
}

$jsonData = json_encode($res);
echo $jsonData;

?>