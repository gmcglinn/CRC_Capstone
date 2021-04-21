<?php 

if (isset($_POST['TID'])) {
    include_once('./backend/config.php');
	include_once('./backend/db_connector.php');

	$tid = $_POST['TID'];
	$sql = "SELECT title, instructions FROM s21_form_templates WHERE TID = '$tid'";
	$result = mysqli_query($db_conn, $sql);
	$row = mysqli_fetch_array($result);

	$instructions = $row['instructions'];
	$instructions = json_decode($instructions, True);
	$title = $row['title'];

	echo("<div id=userForm class='w3-card-4 w3-padding w3-margin'>");
	echo("<h4> $title</h4>");
	echo("<br>");

	foreach ($instructions as $key => $value) {
		echo("<label class='w3-margin'>  $key </label>");
		echo("<input type=text class='w3-input w3-margin w3-gray' disabled/>" );
		echo("<br>");
	}

	echo("</div>");
}

?>