<?php
include 'conn.php';


$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';


$sql = "SELECT p.itemamount, p.quantity, c.name AS catid, s.subcatname AS subcatid, i.itemname AS itemid FROM purchasetbl2 p INNER JOIN item i ON p.itemid = i.id INNER JOIN subcategory s ON i.subcatid = s.id INNER JOIN category c ON s.catid = c.id  WHERE p.purchaseid = '$purchaseid'";


$result = mysqli_query($conn, $sql);

if ($result) {
    $i = 0;
    while ($data = mysqli_fetch_assoc($result)) {
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
