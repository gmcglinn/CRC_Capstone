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

<!Instructor Form--> 
<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <form method="post" action="./dashboard.php?content=startInternApp">
        <div id="instructorInformation">
            <h5>Instructor Information</h5>
            <input type="hidden" name="workflowID" value="<?php echo $workflowID ?>">
            <label class="w3-input" for="instructotFirstName">First name</label>
            <input type="text" class="w3-input" name="instructorFirstName" id="instructorFirstName" required>
            <label class="w3-input" for="instructorLastName">Last name</label>
            <input type="text" class="w3-input" name="instructorLastName" id="instructorLastName" required>
            <button type="button" name="continue" class="w3-button w3-teal" onclick="document.getElementById('studentInformation').style.display = 'none'; document.getElementById('internshipInformation').style.display = 'block';">Next</button>
        </div>
        <div id="instructorLearningOutcomes" style="display:none;">
            <h5>Learning Outcomes</h5>
            <label class="w3-input" for="outcomes1">
                1.) What are the student learning outcomes?<br>
                2.) If applicable, include any reading material and/or assignments.
            </label>
            <input type="text" class="w3-input" name="outcomes1" id="outcomes1" required></input>
            <label class="w3-input" for="outcomes2">
                3.) Explanation of course grading policies and method of determining final grade.
            </label>
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
            <button type="button" name="back" class="w3-button w3-teal" onclick="document.getElementById('internshipInformation').style.display = 'block'; document.getElementById('employerInformation').style.display = 'none';">Back</button>
        </div>  
    </form>
</div>