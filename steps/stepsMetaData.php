<?php
    if (isset($_POST['startInternshipWF'])) {
        //make default values None
        //put all in try catch block for exception handling
        //error handling (no such email was found)
        $studentEmail = mysqli_real_escape_string($db_conn, $_POST['studentEmail']);
        $dept_code = mysqli_real_escape_string($db_conn, $_POST['dept_code']);
        $course_number = mysqli_real_escape_string($db_conn, $_POST['course_number']);
        $semester = mysqli_real_escape_string($db_conn, $_POST['semester']);
        $year = mysqli_real_escape_string($db_conn, $_POST['year']);
        $gradeMethod = mysqli_real_escape_string($db_conn, $_POST['gradeMethod']);
        $title = mysqli_real_escape_string($db_conn, $_POST['title']);
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);
        $form_type = mysqli_real_escape_string($db_conn, $_POST['form_type']);
        $priority = mysqli_real_escape_string($db_conn, $_POST['priority']);
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);

        $wf_id = bin2hex(random_bytes(32));  //duplication is unlikely with this one. 1 in 20billion apparently
        $newappsql = "INSERT INTO s21_active_workflow_info(WF_ID, title, dept_code, course_number, student_email, semester, year, grade_mode, priority, deadline) 
                        VALUES ('$wf_id','$title', '$dept_code', '$course_number','$studentEmail', '$semester', '$year', '$gradeMethod', '$priority', '$deadline');";
        
        //get instructions
        $sql = "SELECT * FROM s21_course_workflow_steps WHERE course_number = $course_number AND form_type = '$form_type' ";
        $result = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $instructions= $row['instructions'];
        
        $participants = explode("=>", $instructions);

        //get department participant emails
        $sql = "SELECT `chair_email`,`dean_email`,`secretary_email` FROM `f20_academic_dept_info` WHERE `dept_code` = '$dept_code' ";
        $result = mysqli_query($db_conn, $sql);
        $dept_emails = mysqli_fetch_assoc($result);

        //sql prep to insert into active_workflow_ids
        $columns  = "INSERT INTO s21_active_workflow_ids(WF_ID ";
        $values = " VALUES('{$wf_id}' ";
        
        //get participant ids
        $partial_sql = "SELECT `UID` FROM f20_user_table WHERE `user_email` = ";

        foreach($participants as $p) {
                $missing_sql = "";
                if ($p == 'Dean') {
                        $missing_sql =  "'{$dept_emails['dean_email']}'";
                        $columns.= ',DN_ID ';     
                }
                elseif ($p == 'Chair') {
                        $missing_sql = "'{$dept_emails['chair_email']}'";
                        $columns.= ',CHR_ID ';
                } elseif ($p == 'Secretary') {
                        $missing_sql = "'{$dept_emails['secretary_email']}'";
                        $columns.= ',SCRTY_ID ';
                } elseif ($p == 'Student') {
                        $missing_sql = "'{$studentEmail}'";
                        $columns.= ',STDNT_ID ';
                }

                $sql = $partial_sql.$missing_sql;
                $result = mysqli_query($db_conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $values.= ",{$row['UID']} ";

        }

        $wf_ids_sql = $columns.")".$values.");";

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

        //get instructions


    }
?>

<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
        <form method="post">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" class="w3-input" required>
                <br>
                <label for="priority">Priority</label>
                <select id="type" name="priority" class="w3-input">
        		<option selected="" disabled="" hidden=""> Select a priority. </option>
        		<option value="urgent" id="1">urgent</option>
        		<option value="normal" id="2">normal</option>
        		</select>
                <br>
		<label for="deadline">Deadline</label>
                <input id="deadline" name="deadline" type="datetime-local" class="w3-input" required>
                <br>
                <label for="form_type">Workflow Template</label>
                
                <?php
                //Load templates
                include_once('./backend/config.php');
                include_once('./backend/db_connector.php');
                $sql = "SELECT DISTINCT `form_type` FROM `s21_course_workflow_steps`";
                $result = $db_conn->query($sql);
                if ($result->num_rows > 0){
                        echo " <select class='w3-input' id='template' name='form_type'><option selected disabled hidden>Select a Workflow Template</option>";
                        while($row = $result->fetch_assoc()){
                                echo $row['form_type'];
                                echo "<option value=".$row['form_type']." id=".$row['form_type'].">" .$row['form_type']. "</option>";
                        }
                }
                echo "</select>";

                if($_GET['workflowSelect'] == 'internship') {
                        include_once('0000000009.php');
                }

                ?>

                <br>
                <button class="w3-button w3-teal" type="submit" name="startInternshipWF">Start</button>
        </form>
</div>