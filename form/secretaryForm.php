
<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $firstname = mysqli_real_escape_string($_POST['studentFirstName']);
        $lastname = mysqli_real_escape_string($_POST['studentLastName']);
        $studentEmail = mysqli_real_escape_string($_POST['studentEmail']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $sql = "INSERT INTO f20_student_info (fw_id, student_first_name, student_last_name, student_email) 
            VALUES ('$workflowID','$firstname', '$lastname', '$studentEmail')";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            echo("<div class='w3-card w3-green'>Student Information Successfully Updated.</div>");
        } 
        else {
            echo("<div class='w3-card w3-red'>Error. Student Information Update Unsuccessful .</div>");
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

<!-- Form that starts the internship workflow from the student's side.--> 
<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <form method="post" action="./dashboard.php?content=startInternApp">
        <div id="studentInformation">
            <h5>Student Information</h5>
            <input type="hidden" name="workflowID" value="<?php echo $workflowID ?>">
            <label class="w3-input" for="studentFirstName">First name</label>
            <input type="text" class="w3-input" name="studentFirstName" id="studentFirstName" placeholder="Enter the Student's First Name." required>
            <label class="w3-input" for="studentLastName">Last name</label>
            <input type="text" class="w3-input" name="studentLastName" id="studentLastName" placeholder="Enter the Student's Last Name." required>
            <label class="w3-input" for="studentEmail">Email</label>
            <input type="email" class="w3-input" name="studentEmail" id="studentEmail" placeholder="Enter the Student's Email." required>
            <br>
            <?php
                if(isset($_GET['content']) && $_GET['content'] = 'view') {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal' disabled>Submit</button>");
                }
            ?>
        <!-- Select field for the department -->
        <label class="w3-input" for="department">Department</label>
        <select class="w3-input" name="department" id="department" onchange="showCourse(this.value)">
            <option value="">Select a department:</option>
            <?php 
                $sql = "SELECT * FROM `f20_academic_dept_info`";
                $query = mysqli_query($db_conn, $sql);
                if ($query) {
                    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        echo("<option value='" . $row['dept_code'] . "'>" . $row['dept_name'] . "</option>");
                    }
                }
                else {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
                }
            ?>
        </select>            
        </div>  
    </form>
</div>