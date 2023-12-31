<?php
include 'conn.php';

$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';

$purchasename = $_POST['purchasename'];

$sql = "update purchasetbl1 set purchasename = '$purchasename' where id = '$purchaseid'";

$result = mysqli_query($conn,$sql);

if($result)
{
    $sql = "delete from purchasetbl2 where purchaseid = '$purchaseid'";

    $result = mysqli_query($conn,$sql);

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
    $res['message'] = "Data Updated";
}
else
{
    $res['status'] = 0;
    $res['message'] = "Data Not Updated";
}


?>