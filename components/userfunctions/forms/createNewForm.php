<html>
<head>
	<title>Add Data</title>
	<style>
	  table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,th {
  border: 1px solid #ddd;
  padding: 8px;
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
}

input {
	width: 260px;
	height: 40px;
	padding: 10px;
	border-radius: 5px;
}

 tr:nth-child(even){background-color: #f2f2f2;}

tr:hover {background-color: #ddd;}


  </style>
</head>

<body>


<?php
//including the database connection file
include_once("../config.php");




$link = mysqli_connect("localhost", "b_f20_25", "nk4vbq", "b_f20_25_db");
session_start();

if(isset($_POST['Submit'])) {	
	
	$form_modifier = mysqli_real_escape_string($mysqli, $_POST['userId']);
	$form_owner = mysqli_real_escape_string($mysqli, $_POST['userId']);
	$templateId = mysqli_real_escape_string($mysqli, $_POST['templateId']);
	$formTemplateTitle = mysqli_real_escape_string($mysqli, $_POST['formTemplateTitle']);
	
	$getTemplate = mysqli_query($mysqli, "SELECT * FROM formTemplate_T WHERE formTemplate_id=$templateId");

	while($getres = mysqli_fetch_array($getTemplate))
	{	
	$instructions = $getres['formTemplate_instructions'];
	$title = $getres['formTemplate_title'];
	}


	$sql = "SELECT COUNT(*) FROM form_T";
	$result_1 = mysqli_query($mysqli, $sql);
	$count = mysqli_fetch_assoc($result_1)['COUNT(*)'];
	$count1 = $count+1;
	$form_id = '000'.$count1;
	$formserver_location = '/form/form_000'.$count1.'_server.php';
	$formTemplate_created = date('Y/m/d H:i:s');
	$formStatus = 1;


	$fI = mysqli_real_escape_string($mysqli, $form_id);
	$fS = mysqli_real_escape_string($mysqli, $formStatus);
	$ftt = mysqli_real_escape_string($mysqli, $formTemplateTitle);
 	$instruction = mysqli_real_escape_string($mysqli, $instructions);
	$fsl = mysqli_real_escape_string($mysqli, $formserver_location);
	$fto = mysqli_real_escape_string($mysqli, $form_owner);
	$ftc = mysqli_real_escape_string($mysqli, $formTemplate_created);

	
	$sql = "INSERT INTO form_T(`form_id`, `form_status`,`form_title`,`form_instructions`,`form_server`,`form_modifier`,`form_changed`,`form_owner`,`form_created` )VALUES
							  ('$fI', '$fS','$ftt','$instruction','$fsl','$fto', '$ftc','$fto', '$ftc')";

	

	if(empty($templateId) || empty($formTemplateTitle)) {
			
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
	
		if(mysqli_query($link, $sql)){
			echo "Records inserted successfully.";

			// $result = mysqli_query($mysqli, "SELECT * FROM formDetails_T WHERE form_id=$templateId");


		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}

	
}
}
?>
</body>
</html>