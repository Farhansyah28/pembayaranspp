<?php
$conn = mysqli_connect('localhost', 'root', '', 'pembayaranspp');
$res = mysqli_query($conn, "DESC pembayaran");
$output = "";
while ($row = mysqli_fetch_assoc($res)) {
    $output .= print_r($row, true);
}
file_put_contents('pembayaran_schema.txt', $output);
?>