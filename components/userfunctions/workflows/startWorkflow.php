<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php');


?>

<?php
    if (isset($_POST['startWF'])) {
        //make default values None
        //put all in try catch block for exception handling
        //error handling (no such email was found)
        
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);
        $ATPID = mysqli_real_escape_string($db_conn,  $_POST['ATPID']);
        $priority = mysqli_real_escape_string($db_conn, $_POST['priority']);
        $form_assignments = $_POST['form_assignments'];   
        $form_assignments = json_decode($form_assignments, True);


        $wf_id = bin2hex(random_bytes(32));  //duplication is unlikely with this one. 1 in 20billion apparently
        
        $newappsql = "INSERT INTO s21_active_workflow_info(WF_ID, ATPID, priority, deadline) 
            VALUES ('$wf_id','$ATPID', '$priority', '$deadline');";

        //get workflow steps info
        $sql = "SELECT * FROM s21_course_workflow_steps WHERE ATPID = '$ATPID'";
        $result = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $instructions= $row['instructions'];
        $participants = explode("=>", $instructions);
 

        //sql prep to insert into active_workflow_ids
        $active_wf_ids_columns_sql  = "INSERT INTO s21_active_workflow_ids(WF_ID ";
        $active_wf_ids_values_sql = " VALUES('{$wf_id}' ";
        
        //sql prep to insert into active_user_forms
        $active_user_forms_info = "INSERT INTO s21_active_workflow_ids(WF_ID ";
        $active_user_forms_values = " VALUES( '{$wf_id}' ";

        //get participant ids
        foreach($participants as $p) {
                $user_email = "";

                if ($p == 'Dean') {
                        $active_wf_ids_columns_sql.= ',DN_ID ';
                        $user_email = $_POST['Dean'];     
                }
                elseif ($p == 'Chair') {
                        $active_wf_ids_columns_sql.= ',CHR_ID ';
                        $user_email = $_POST['Chair'];
                } 
                elseif ($p == 'Secretary') {
                        $active_wf_ids_columns_sql.= ',SCRTY_ID ';
                        $user_email = $_POST['Secretary'];
                } 
                elseif ($p == 'Student') {
                        $active_wf_ids_columns_sql.= ',STDNT_ID ';
                        $user_email = $_POST['Student'];
                }
                elseif ($p == 'Employer') {
                        $active_wf_ids_columns_sql.= ',EMP_ID ';
                        $user_email = $_POST['Employer'];
                }
                elseif ($p == 'Crc') {
                        $active_wf_ids_columns_sql.= ',CRC_ID ';
                        $user_email = $_POST['Crc'];
                }
                elseif ($p == 'Faculty') {
                        $active_wf_ids_columns_sql.= 'FCLTY_ID ';
                        $user_email = $_POST['Faculty'];
                }
                elseif ($p == 'Recreg') {
                        $active_wf_ids_columns_sql.= ',RCRG_ID ';
                        $user_email = $_POST['Recreg'];
                }

                $uid_sql = $partial_sql = "SELECT `UID` FROM f20_user_table WHERE `user_email` = '$user_email'";
                $result = mysqli_query($db_conn, $uid_sql);
                $row = mysqli_fetch_assoc($result);
                $UID =  $row['UID'];
                $active_user_forms_values .= ",'$UID' ";

                //Get the form template for the form assigned to the user
                $form_title = $form_assignments[$p];
                
                $sql = "SELECT instructions FROM s21_form_templates WHERE title='$form_title'";
                $result = mysqli_query($db_conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $form_info = $row['instructions'];

                $sql = "INSERT INTO s21_active_form_info(WF_ID, UID, form_info) VALUES ('$wf_id', '$UID', '$form_info')";
                mysqli_query($db_conn, $sql);
                


        }

        $wf_ids_sql = $active_wf_ids_columns_sql.")".$active_user_forms_values.");";

        //are intitally set to not started
        $default_workflow_status_sql = "INSERT INTO s21_active_workflow_status(WF_ID) 
                                VALUES ('$wf_id');";
        //insert into db
        mysqli_query($db_conn, $default_workflow_status_sql);
        mysqli_query($db_conn, $newappsql);
        
        if (mysqli_errno($db_conn) == 0) {
            mysqli_query($db_conn, $wf_ids_sql);

            if (mysqli_errno($db_conn) == 0) {

                echo("<div class='w3-card w3-green w3-margin w3-padding'>Application Successfully Started.</div>");
            }
            else {
                echo("<div class='w3-card w3-red w3-margin w3-padding'>Error starting application application.</div>");
            }
        }
        else {
            echo("<div class='w3-card w3-red w3-margin w3-padding'>Error starting application.</div>");
        }

    }
?>

<div id='wf-start' class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <h4>Start A Workflow</h4>
        <form method="post">
           <div class='w3-container'>
           <label for="form_type">Course (Workflow Template)</label>
            <select class="w3-input" name="ATPID" id="wf_title" onchange="showFormUsers(this.value)">
            <option value="">Select a Workflow:</option>
            <?php

            	$sql = "SELECT ATPID, workflow_title FROM s21_course_workflow_steps";
            	$result = mysqli_query($db_conn, $sql);

            	while($row = mysqli_fetch_array($result)) {
            		echo("<option value=".$row['ATPID'].">".$row['workflow_title']."</option>");
            	}

            ?>
            </select>    
			<br>
            <label for="priority">Priority</label>
            <select id="type" name="priority" class="w3-input">
    		<option selected="" disabled="" hidden=""> Select a priority. </option>
    		<option value="">Select a priority</option>
    		<option value="urgent" id="1">urgent</option>
    		<option value="normal" id="2">normal</option>
    		</select>
            <br>
	        <label for="deadline">Deadline</label>
            <input id="deadline" name="deadline" type="datetime-local" class="w3-input" >
            <br>
        	</div>
            <div for="form_users" id="formUsers" type="hidden"></div>
            <button class="w3-button w3-teal" type="submit" name="startWF">Start</button>
        </form>
</div>

<script>

function showFormUsers(str) {
	fetch("backend/getFormUsers.php?q="+str, {
            method:'POST',
             headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
        })
        .then(response => response.text())
        .then( formUsers => {
        	document.getElementById('formUsers').innerHTML = formUsers;
    });
}
</script>
