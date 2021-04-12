<?php

    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $approval = mysqli_real_escape_string($_POST['approval']);
        $comments = mysqli_real_escape_string($_POST['comments']);


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

<!-- Form that starts the internship workflow from the student's side.--> 
<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <h4>Dean Form</h4>
    <form method="post" action="./dashboard.php?content=startInternApp">
        <div id="approvalDecision">
            <h5> Approve or Decline Student Application </h5>
            <label class="w3-input" for="approval"> Choose: </label>
                <select class="w3-input" name="approval" id="approval" required>
                    <option value="approve">Approve</option>
                    <option value="decline">Decline</option>
                </select>
            
            <label class="w3-input" for="comments">Comments:</label>
            <input type="text" class="w3-input" name="comments" id="comments" placeholder="Provide Any Comments (if necessary)">
            <br>
            <?php
                if(isset($_GET['content']) && $_GET['content'] = 'view') {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
                }
                else {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
                }
            ?>            
        </div>  
    </form>
</div>