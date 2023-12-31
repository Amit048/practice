<?php
include 'conn.php';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';


$sql = "SELECT * FROM purchasetbl1 WHERE id = '$purchaseid'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($result) {
    $res['purchasename'] = $data['purchasename'];
    $res['status'] = 1;
    $res['message'] = "Data Found";
} else {
    $res['status'] = 0;
    $res['message'] = "No Data Found in purchasetbl1";
}


$sql = "SELECT * FROM purchasetbl2 WHERE purchaseid = '$purchaseid'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        
        $res['catid'] = $data['catid'];
        $res['subcatid'] = $data['subcatid'];
        $res['itemid'] = $data['itemid'];
        $res['itemamount'] = $data['itemamount'];
        $res['quantity'] = $data['quantity'];
        
        $res['status'] = 1;
        $res['message'] = "Data Found";
    } else {
        $res['status'] = 0;
        $res['message'] = "No Data Found in purchasetbl2 for the given purchaseid";
    }
} else {
    $res['status'] = 0;
    $res['message'] = "Error querying purchasetbl2";
}

echo json_encode($res);
?>
