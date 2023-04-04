<?php
// Prepare the query to insert the form data into the table
$sql = "INSERT INTO services_bookings (cname, cemail, cnumber, plan, charges, date_created)
VALUES ('" . $_POST['cname'] . "', '" . $_POST['cemail'] . "', '" . $_POST['cnumber'] . "', '" . $_POST['plan'] . "', '" . $_POST['charges'] . "', '" . date('Y-m-d') . "')";


if (mysqli_query($conn, $sql)) {
    $success_msg = '
    <div class="d-flex align-items-center justify-content-center text-center p-5" style="height:60vh">
        <div>
        <h3 style="color: rgb(250, 171, 0)" class="mb-5">Your Booking has been done successfully...!</h3>
        <a aria-current="page" href="./?p=home" class="btn">Go Back</a>
        </div>
    </div>';
    echo $success_msg;
} else {
    $error_msg = '
    <div class="d-flex align-items-center justify-content-center text-center p-5" style="height:60vh">
        <div>
        <h3 style="color: rgb(250, 171, 0)" class="mb-5">There was an error in booking...!</h3>
        <a aria-current="page" href="./?p=home" class="btn">Go Back</a>
        </div>
    </div>';
    echo $error_msg;
}
?>

<style>
    .col {
        color: rgb(250, 171, 0);
    }
</style>