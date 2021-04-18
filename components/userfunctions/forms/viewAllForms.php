<?php
//including the database connection file
include_once("../config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
$result = mysqli_query($mysqli, "SELECT * FROM form_T"); // using mysqli_query instead
?>

<html>
<head>	
	<title>Homepage</title>
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
<a href="d1-formAdd.html">Add New Form</a><br/><br/>

	<table width='80%' border=0>

	<tr bgcolor='#7fcbae'>
		<td>Id</td>
		<td>Status</td>
		<td>Title</td>
        <td>Insrtuctions</td>
        <td>Server</td>
        <td>Modifier</td>
		<td>Changed</td>
		<td>owner</td>
        <td>Created</td>
        
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['form_id']."</td>";
		echo "<td>".$res['form_status']."</td>";
        echo "<td>".$res['form_title']."</td>";
        echo "<td>".$res['form_instructions']."</td>";
        echo "<td>".$res['form_server']."</td>";
        echo "<td>".$res['form_modifier']."</td>";	
		echo "<td>".$res['form_changed']."</td>";
		echo "<td>".$res['form_owner']."</td>";
        echo "<td>".$res['form_created']."</td>";
		// echo "<td><a href=\"d1-formAllView.php?id=$res[form_id]\">Edit</a> | <a href=\"d1-formdelete.php?id=$res[form_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
	}
	?>
	</table>
</body>
</html>