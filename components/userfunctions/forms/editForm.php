<?php
// including the database connection file
include_once("../config.php");

if(isset($_POST['update']))
{	

	
	
	$form_id = mysqli_real_escape_string($mysqli, $_POST['form_id']);
	$form_status = mysqli_real_escape_string($mysqli, $_POST['form_status']);
    $form_title = mysqli_real_escape_string($mysqli, $_POST['form_title']);
    $form_instructions = mysqli_real_escape_string($mysqli, $_POST['form_instructions']);
    $form_server = mysqli_real_escape_string($mysqli, $_POST['form_server']);
    $form_modifier = mysqli_real_escape_string($mysqli, $_POST['form_modifier']);	
	$form_changed = mysqli_real_escape_string($mysqli, $_POST['form_changed']);
	$form_owner = mysqli_real_escape_string($mysqli, $_POST['form_owner']);
    $form_created = mysqli_real_escape_string($mysqli, $_POST['form_created']);	
	
	
	// checking empty fields
    if(empty($form_id) || empty($form_status)) {	
			
    
	} else {	
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE form_T SET form_id='$form_id',form_status='$form_status',form_title='$form_title',form_instructions='$form_instructions',form_server='$form_server',form_modifier='$form_modifier',form_changed='$form_changed',form_owner='$form_owner',form_created='$form_created' WHERE form_id=$form_id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: d1-formAllView.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM form_T WHERE form_id=$id");

while($res = mysqli_fetch_array($result))
{
  	
	$form_id = $res['form_id'];
	$form_status = $res['form_status'];
    $form_title = $res['form_title'];
    $form_instructions = $res['form_instructions'];
    $form_server = $res['form_server'];
    $form_modifier = $res['form_modifier'];	
	$form_changed = $res['form_changed'];
	$form_owner = $res['form_owner'];
    $form_created = $res['form_created'];
}
?>
<html>
<head>	
	<title>Edit Data</title>
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
	<a href="d1-formAllView.php">View All Forms</a>
	<br/><br/>
	
	<form name="form1" method="post" action="d1-formEdit.php">
		<table border="0">
			<tr> 
				<td>Id</td>
				<td><input type="text" name="form_id" value="<?php echo $form_id;?>"></td>
			</tr>
			<tr> 
				<td>Status</td>
				<td><input type="text" name="form_status" value="<?php echo $form_status;?>"></td>
			</tr>
			<tr> 
				<td>Title</td>
				<td><input type="text" name="form_title" value="<?php echo $form_title;?>"></td>
            </tr>
            <tr> 
				<td>Instructions</td>
				<td><input type="text" name="form_instructions" value="<?php echo $form_instructions;?>"></td>
            </tr>
            <tr> 
				<td>Server</td>
				<td><input type="text" name="form_server" value="<?php echo $form_server;?>"></td>
            </tr>
            <tr> 
				<td>Modifier</td>
				<td><input type="text" name="form_modifier" value="<?php echo $form_modifier;?>"></td>
			</tr>
			  <tr> 
				<td>Changed</td>
				<td><input type="text" name="form_changed" value="<?php echo $form_changed;?>"></td>
			</tr>
			<tr> 
				<td>Owner</td>
				<td><input type="text" name="form_changed" value="<?php echo $form_owner;?>"></td>
			</tr>
			  <tr> 
				<td>Created</td>
				<td><input type="text" name="form_created" value="<?php echo $form_created;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>