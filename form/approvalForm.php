<?php

    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $firstname = mysqli_real_escape_string($_POST['firstName']);
        $lastname = mysqli_real_escape_string($_POST['lastName']);
        $approval = mysqli_real_escape_string($_POST['approval']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $sql = "INSERT INTO f20_student_info (fw_id, student_first_name, student_last_name, student_middle_initial, 
            student_phone, student_address, student_apt_num, student_city, student_state, student_zip, credits_registered) 
            VALUES ('$workflowID','$firstname', '$lastname','$middlename','$phonenum','$address', '$aptnum', '$city', '$state','$zip', '$credits')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Student Information Update Unsuccessful .</div>");
        }
        
        //This updates the missing fields from the workflow in the database.
        $sql = "UPDATE f20_application_info SET project_name = '$workflowType', academic_credits = '$workflowCredits', 
            hours_per_wk = '$workflowHours' WHERE fw_id = '$workflowID'";
        $query = mysqli_query($db_conn, $sql);
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Student Information Successfully Updated.</div>");
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

        //This creates an entry in the company info table of the database.
        $sql = "INSERT INTO f20_company_info (fw_id, company_name, supervisor_email, supervisor_phone, supervisor_first_name,
            supervisor_last_name, company_address, company_address2, company_city, company_state, company_zip) 
            VALUES ('$workflowID','$employerOrganization', '$employerEmail', '$employerPhone', '$employerFirstName', '$employerLastName', '$employerStreet', '$employerBldNum', '$employerCity','$employerState', '$employerZip')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Business/Organization Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Business/Student Information Update Unsuccessful .</div>");
        }
    }
    //If this field is set then the user came here from their list of active workflows.
    else if(isset($_POST['wfID'])) {
        $workflowID = $_POST['wfID'];
    }
?>

<!-- Form that starts the internship workflow from the student's side.--> 
<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <form method="post" action="./dashboard.php?content=startInternApp">
        <div id="approvalDecision">
            <h5> Personal Information </h5>
            <input type="hidden" name="workflowID" value="<?php echo $workflowID ?>">
            <label class="w3-input" for="firstName">First name</label>
            <input type="text" class="w3-input" name="firstName" id="firstName" required>
            <br>
            <label class="w3-input" for="studentLastName">Last name</label>
            <input type="text" class="w3-input" name="lastName" id="lastName" required>
            <br>
            <h5> Approve or Decline Student Application </h5>
            <label class="w3-input" for="approval"> Approve or Decline </label>
                <select class="w3-input" name="approval" id="approval" required>
                    <option value="approve">Approve</option>
                    <option value="decline">Decline</option>
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