<?php
//including the database connection file
include_once("../config.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$result = mysqli_query($mysqli, "DELETE FROM form_T WHERE form_id=$id");

//redirecting to the display page (index.php in our case)
header("Location:d1-formAllView.php");
?>