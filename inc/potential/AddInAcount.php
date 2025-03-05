<?php
require_once '../config.php';


if (isset($_POST["userId"])) {
    $userId = $_POST["userId"];
    $received_amount = $_POST['received_amount'];


    $data = mysqli_query($conn, "SELECT * FROM potential WHERE id = '$userId'");
    $person = mysqli_fetch_array($data);

    // echo  $person['id'];

    $CDB_HOST = 'localhost';
    $CDB_USER = 'account_crm';
    $CDB_PASS = 'q^Qgm8%uOH!e';
    $CDB_NAME = 'account_crm';

    $connAcc = mysqli_connect("$CDB_HOST", "$CDB_USER", "$CDB_PASS", "$CDB_NAME");
    mysqli_select_db($connAcc, $CDB_NAME);

    $newDate = date("d/m/Y", strtotime($person['travel_date']));

    $id = $person['id'];
    $sales_person = $person['sales_person'];
    $name = $person['name'];
    $email = $person['email'];
    $mo_number = $person['mo_number'];
    $wtp_no = $person['wtp_no'];
    $destination = $person['destination'];
    $no_person = $person['no_person'];
    $description = $person['description'];
    $last_response = $person['last_response'];
    $status = $person['status'];
    $amount = $person['amount'];
    $travel_date = $newDate;
    // check douplicate 

    $check = mysqli_query($connAcc, "SELECT * FROM leads WHERE client_id = '$userId'");
$lead = mysqli_fetch_array($check);
    if (mysqli_num_rows($check) > 0) {
        if ($lead['received_amount'] > 0) {
            echo '<i class="text-success">Previous invoice not generate</i>';
        } else {
            $updated = mysqli_query($connAcc, "UPDATE leads SET  received_amount = '$received_amount' WHERE WHERE client_id = '$userId'");
            if ($updated) {
                echo '<i class="text-success"><img src="images/img/small-done.gif" width="25px"> Amount successfully added </i>';
            } else {
                echo '<i class="text-success">Data successfully Updated</span>';
            }
        }
    } else {
        $insert = mysqli_query($connAcc, "INSERT INTO leads (client_id, employee_id, name, email, number, wtp_number, destination_id, no_person, description, response,current_status, received_amount,  travel_date, lead_status) VALUES ('$id','$sales_person','$name','$email','$mo_number','$wtp_no','$destination','$no_person','$description','$last_response','$status','$received_amount','$travel_date','potential')");
        if ($insert) {
?>
            <i id="message_descr" class="text-success"><img src="images/img/small-done.gif" width="25px">successfully added</i>

<?php
        } else {
            echo 'Something Went Wrong';
        }
    }
}

?>