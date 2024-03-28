<?php
$con = mysqli_connect('localhost:3307', 'root', '', 'drugbio');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
