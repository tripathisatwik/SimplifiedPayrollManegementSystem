<?php
$conn = mysqli_connect('localhost', 'root', '', 'newpayroll');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>