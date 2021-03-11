<label for="title">Title</label>
        <input id="title" name="title" type="text" class="w3-input" required>
        <br>
        <label for="type">Priority</label>
        <select id="type" name="type" class="w3-input">
		<option selected="" disabled="" hidden=""> Select a priority. </option>
		<option value="1" id="1">urgent</option>
		<option value="2" id="2">normal</option>
		</select>
        <br>
		<label for="deadline">Deadline</label>
        <input id="deadline" name="deadline" type="datetime-local" class="w3-input" required>
        <br>
<label for="template">Workflow Template</label>
<?php
//Load templates
include_once('./backend/config.php');
include_once('./backend/db_connector.php');
$sql = "SELECT ATPID, title from f20_app_template_table";
$result = $db_conn->query($sql);
if ($result->num_rows > 0){
        echo " <select class='w3-input' id='template' name='template'><option selected disabled hidden>Select a Workflow Template</option>";
        while($row = $result->fetch_assoc()){

                echo "<option value=".$row['ATPID']." id=".$row['ATPID'].">" .$row['title']. "</option>";
        }
}
echo "</select>";
?>