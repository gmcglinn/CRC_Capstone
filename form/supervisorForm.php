<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $outcome1 = mysqli_real_escape_string($_POST['outcomes1']);
    

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
    <h4>Supervisor Form</h4>
    <form name="supervisorForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <h5>Learning Outcomes</h5>
        <br>
        <label class="w3-input" for="outcome1">
                1.) What are the student learning outcomes?<br>
                2.) If applicable, include any reading material and/or assignments.
            </label>
            <input type="text" class="w3-input" name="outcome1" id="outcome1" required></input>
        <br>
        <?php
            if(isset($_GET['content']) && $_GET['content'] = 'view') {
                echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
            }
            else {
                echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
            }
        ?>            
    </form>
</div>