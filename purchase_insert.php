<?php
//purchase_insert.php
include 'conn.php';

$purchasename = $_POST['purchasename'];

$sql = "insert into purchasetbl1 (purchasename) values ('$purchasename')";
$result = mysqli_query($conn,$sql);

$purchaseid = mysqli_insert_id($conn);

if($result)
{
    foreach($_POST['tblcatid'] as $index => $tblcatid)
    {
        $tblcatname = $_POST['tblcatname'][$index];
        $tblsubcatid = $_POST['tblsubcatid'][$index];
        $tblsubcatname = $_POST['tblsubcatname'][$index];
        $tblitemid = $_POST['tblitemid'][$index];
        $tblitemname = $_POST['tblitemname'][$index];
        $tblitemamount = $_POST['tblitemamount'][$index];
        $tblquantity = $_POST['tblquantity'][$index];

        $sql = "insert into purchasetbl2 (purchaseid,catid,catname,subcatid,subcatname,itemid,itemname,itemamount,quantity) values ('$purchaseid','$tblcatid','$tblcatname','$tblsubcatid','$tblsubcatname','$tblitemid','$tblitemname','$tblitemamount','$tblquantity')";

        $result = mysqli_query($conn,$sql);
    }

    $res['status'] = 1;
    $res['message'] = "Data Inserted";
}
else
{
    $res['status'] = 0;
    $rs['message'] = "Data Not Inserted";
}

$jsonData = json_encode($res);
echo $jsonData;
?>