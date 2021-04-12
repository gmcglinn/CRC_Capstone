<?php
    //If this field is set then the user submitted the form to start the workflow.
    if(isset($_POST['studentSubmit'])) {
        //First we gather all the input field information.
        $workflowID = mysqli_real_escape_string($_POST['workflowID']);
        $firstname = mysqli_real_escape_string($_POST['studentFirstName']);
        $lastname = mysqli_real_escape_string($_POST['studentLastName']);
        $middlename = mysqli_real_escape_string($_POST['studentMiddleName']);
        $phonenum = mysqli_real_escape_string($_POST['studentPhone']);
        $address = mysqli_real_escape_string($_POST['studentAddress']);
        $aptnum = mysqli_real_escape_string($_POST['studentAptNum']);
        $city = mysqli_real_escape_string($_POST['studentCity']);
        $state = mysqli_real_escape_string($_POST['studentState']);
        $zip = mysqli_real_escape_string($_POST['studentZip']);
        $credits = mysqli_real_escape_string($_POST['studentCredits']);
        $workflowType = mysqli_real_escape_string($_POST['appType']);
        $workflowCredits = mysqli_real_escape_string($_POST['appCredits']);
        $workflowHours = mysqli_real_escape_string($_POST['appHours']);
        $outcome1 = mysqli_real_escape_string($_POST['outcomes1']);
        $outcome2 = mysqli_real_escape_string($_POST['outcomes2']);
        $outcome3 = mysqli_real_escape_string($_POST['outcomes3']);
        $department = mysqli_real_escape_string($db_conn, $_POST['department']);
        $course = mysqli_real_escape_string($db_conn, $_POST['course']);

        //This creates an entry for the student's information in the database attached with the workflow ID.
        $sql = "INSERT INTO f20_student_info (fw_id, student_first_name, student_last_name, student_middle_initial, 
            student_phone, student_address, student_apt_num, student_city, student_state, student_zip) 
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
            VALUES ('$workflowID','$organization', '$supervisorEmail', '$supervisorNum', '$supervisorName', '$orgStreet', '$orgAptNum', '$orgCity','$orgState', '$orgZip')";
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

<!-- Student Form -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h4>Student Form</h4>
    <form name="studentForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <h5>Project Proposal</h5>
		<label for="title">Project Title</label>
        <input id="title" name="title" type="text" class="w3-input" placeholder="Enter your Project Title." required>
        <br>
		<label for="organization">Name of Organization</label>
        <input id="organization" name="organization" type="text" class="w3-input" placeholder="Enter the Name of the Organization/Company." required>
        <br>
		<label for="orgStreet">Street</label>
        <input id="orgStreet" name="orgStreet" type="text" class="w3-input" placeholder="Enter the Organization's Street Address." required>
        <br>
        <label for="orgAptNum">Apt#</label>
        <input id="orgAptNum" name="orgAptNum" type="text" class="w3-input" placeholder="Enter the Apartment Number or Suite(if applicable)" >
        <br>
        <label for="orgCity">City</label>
        <input id="orgCity" name="orgCity" type="text" class="w3-input" placeholder="Enter the Organization's City." required>
        <br>
        <label for="orgState">State</label>
        <select class="w3-input" name="employerState" id="employerState" required>
                <option value="">Select the State.</option>
                <?php include('./backend/states.php') ?>
        </select>
        <br>
        <label for="orgZipCode">Zip Code</label>
        <input id="orgZipCode" name="orgZipCode" type="text" class="w3-input" placeholder="Enter the Organization's Zip Code." required>
        <br>
        <label for="supervisorName">Supervisor</label>
        <input id="supervisorName" name="supervisorName" type="text" class="w3-input" placeholder="Enter your Supervisor's Name." required>
        <br>
        <label for="supervisorNum">Supervisor's Phone Number</label>
        <input id="supervisorNum" name="supervisorNum" type="text" class="w3-input" placeholder="Enter your Supervisor's Number." required>
        <br>
        <label for="supervisoEmail">Supervisor's Email</label>
        <input id="supervisorEmail" name="supervisorEmail" type="text" class="w3-input" placeholder="Enter your Supervisor's Email Address." required>
        <br>
        <h5>Learning Outcomes</h5>
        <label class="w3-input" for="outcomes1">
                1a) What are your responsibilities on site?<br>
                b) What special project will you be working on?<br>
                c) What do you expect to learn?
            </label>
            <input type="text" class="w3-input" name="outcomes1" id="outcomes1" required></input>
            <br>
            <label class="w3-input" for="outcomes2">
                1.) How is the proposal related to your major areas of interest?<br>
                Describe the course work you have completed which provides appropriate background to the project.
            </label>
            <input type="text" class="w3-input" name="outcomes2" id="outcomes2" required></input>
            <br>
            <label class="w3-input" for="outcomes3">
                1.) What is the proposed method of study?<br>
                Where appropriate, cite readings and practical experience.
            </label>
            <input type="text" class="w3-input" name="outcomes3" id="outcomes3" required></input>
            <br>
            <?php
                if(isset($_GET['content']) && $_GET['content'] = 'view') {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'>Submit</button>");
                }
                else {
                    echo("<button type='submit' name='studentSubmit' class='w3-button w3-teal'disabled>Submit</button>");
                }
            ?>            
        </div>
    </form>
</div>