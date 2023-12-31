<?php
include 'conn.php';

$res = array();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';

$purchasename = $_POST['purchasename'];

// Update the purchasetbl1 table
$sql = "UPDATE purchasetbl1 SET purchasename = '$purchasename' WHERE id = '$purchaseid'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Delete existing records in purchasetbl2 for the given purchaseid
    $sqlDeleteAll = "DELETE FROM purchasetbl2 WHERE purchaseid = '$purchaseid'";
    $resultDeleteAll = mysqli_query($conn, $sqlDeleteAll);

    // Insert new records into purchasetbl2
    for ($i = 0; $i < count($_POST['tblcatid']); $i++) {
        $tblcatid = $_POST['tblcatid'][$i];
        $tblcatname = $_POST['tblcatname'][$i];
        $tblsubcatid = $_POST['tblsubcatid'][$i];
        $tblsubcatname = $_POST['tblsubcatname'][$i];
        $tblitemid = $_POST['tblitemid'][$i];
        $tblitemname = $_POST['tblitemname'][$i];
        $tblitemamount = $_POST['tblitemamount'][$i];
        $tblquantity = $_POST['tblquantity'][$i];

        // Insert new records into purchasetbl2 with additional fields
        $sqlInsert = "INSERT INTO purchasetbl2 (purchaseid, catid, catname, subcatid, subcatname, itemid, itemname, itemamount, quantity) VALUES ('$purchaseid', '$tblcatid', '$tblcatname', '$tblsubcatid', '$tblsubcatname', '$tblitemid', '$tblitemname', '$tblitemamount', '$tblquantity')";
        $resultInsert = mysqli_query($conn, $sqlInsert);

        if (!$resultInsert) {
            $res['status'] = 0;
            $res['message'] = "Error inserting data into purchasetbl2";
            echo json_encode($res);
            exit();
        }
    }

    $res['status'] = 1;
    $res['message'] = "Data Updated";
} else {
    $res['status'] = 0;
    $res['message'] = "Data Not Updated";
}

echo json_encode($res);
?>


<?php
/*include 'conn.php';

$res = array();

$id = isset($_POST['id']) ? $_POST['id'] : '';
$purchaseid = isset($_POST['purchaseid']) ? $_POST['purchaseid'] : '';

$purchasename = $_POST['purchasename'];


$sql = "UPDATE purchasetbl1 SET purchasename = '$purchasename' WHERE id = '$purchaseid'";
$result = mysqli_query($conn, $sql);

if ($result) {

    $sqlDeleteAll = "DELETE FROM purchasetbl2 WHERE purchaseid = '$purchaseid'";
    $resultDeleteAll = mysqli_query($conn, $sqlDeleteAll);

    // Insert new records into purchasetbl2
    for ($i = 0; $i < count($_POST['tblcatid']); $i++) {
        $tblcatid = $_POST['tblcatid'][$i];
        $tblcatname = $_POST['tblcatname'][$i];
        $tblsubcatid = $_POST['tblsubcatid'][$i];
        $tblsubcatname = $_POST['tblsubcatname'][$i];
        $tblitemid = $_POST['tblitemid'][$i];
        $tblitemname = $_POST['tblitemname'][$i];
        $tblitemamount = $_POST['tblitemamount'][$i];
        $tblquantity = $_POST['tblquantity'][$i];

        // Insert new records into purchasetbl2 with additional fields
        $sqlInsert = "INSERT INTO purchasetbl2 (purchaseid, catid, catname, subcatid, subcatname, itemid, itemname, itemamount, quantity) VALUES ('$purchaseid', '$tblcatid', '$tblcatname', '$tblsubcatid', '$tblsubcatname', '$tblitemid', '$tblitemname', '$tblitemamount', '$tblquantity')";
        $resultInsert = mysqli_query($conn, $sqlInsert);

        if (!$resultInsert) {
            $res['status'] = 0;
            $res['message'] = "Error inserting data into purchasetbl2";
            echo json_encode($res);
            exit();
        }
    }

    $res['status'] = 1;
    $res['message'] = "Data Updated";
} else {
    $res['status'] = 0;
    $res['message'] = "Data Not Updated";
}

echo json_encode($res);*/
?>