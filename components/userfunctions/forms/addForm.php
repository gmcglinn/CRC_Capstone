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
	<a href="d1-formAllView.php">Home</a>
	<br/><br/>

	<form action="d1-formCreateNew.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr> 
				<td>UserId</td>
				<td><input type="text" name="userId"></td>
			</tr>
			<tr> 
				<td>Template Id</td>
				<td><input type="text" name="templateId"></td>
			</tr>
			<tr> 
				<td>Form Template Title</td>
				<td><input type="text" name="formTemplateTitle"></td>
            </tr>
			<select id="example-getting-started" multiple="multiple" name="category">

				<?php
				$query = "select * from formTemplate";
				$results = mysql_query($query);
			
				while ($rows = mysql_fetch_assoc(@$results)){ 
				?>
				<option value="<?php echo $rows['form_title'];?>"><?php echo $rows['form_title'];?></option>
			
				<?php
				} 
				?>
			</select>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit" value="Add"></td>
			</tr>
		</table>
	</form>
</body>
</html>