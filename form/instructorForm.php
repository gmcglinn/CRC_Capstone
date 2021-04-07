<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $firstname = mysqli_real_escape_string($_POST['instructorFirstName']);
        $lastname = mysqli_real_escape_string($_POST['instructorLastName']);
        $outcome1 = mysqli_real_escape_string($_POST['outcomes1']);
        $outcome2 = mysqli_real_escape_string($_POST['outcomes2']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $sql = "INSERT INTO f20_faculty_info (fw_id, faculty_first_name, faculty_last_name ) 
            VALUES ('$workflowID','$firstname', '$lastname')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Faculty Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Faculty Information Update Unsuccessful .</div>");
        }
        
        //This updates the missing fields from the workflow in the database.
        $sql = "UPDATE f20_application_info SET project_name = '$workflowType', academic_credits = '$workflowCredits', 
            hours_per_wk = '$workflowHours' WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Faculty Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Faculty Information Successfully Updated.</div>");
        }

        //This updates the application utility table in the database.
        $sql = "UPDATE f20_application_util SET rejected = '0', progress = '1', assigned_to = 'instructor@email.com' 
            WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Student Information Successfully Updated.</div>");
        }

    }
    //If this field is set then the user came here from their list of active workflows.
    else if(isset($_POST['wfID'])) {
        $workflowID = $_POST['wfID'];
    }
?>

<!-- Instructor Form -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Fieldwork Form</h5>
    <form name="instructorForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <label for="fname">First Name</label>
        <input id="fname" name="fname" type="text" class="w3-input" required>
        <br>
	    <label for="lname">Last Name</label>
        <input id="lname" name="lname" type="text" class="w3-input" required>
        <br>
        <label class="w3-input" for="gradeMethod">Grade Method</label>
        <select name="gradeMethod" class="w3-input">
            <option value="">Select a grade method:</option>
            <option value="Letter Grades">Letter Grades</option>
            <option value="Pass/Fail">Pass/Fail</option>
        </select>
        <br>
        <h5>Instructor - Learning Outcomes</h5>
        <br>
        <label class="w3-input" for="outcomes1">
                1.) What are the student learning outcomes?<br>
                2.) If applicable, include any reading material and/or assignments.
            </label>
            <input type="text" class="w3-input" name="outcomes1" id="outcomes1" required></input>
            <br>
            <label class="w3-input" for="outcomes2">
                2.) Explanation of course grading policies and method of determining final grade.
            </label>
            <input type="text" class="w3-input" name="outcomes2" id="outcomes1" required></input>
            <br>
        </div>
        <br>
            <?php
                if(isset($_GET['content']) && $_GET['content'] = 'view') {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal' disabled>Submit</button>");
                }
                else {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
                }
            ?>            
        </div>  
    </form>
</div>