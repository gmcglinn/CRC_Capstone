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
        $employerOrganization = mysqli_real_escape_string($_POST['employerOrganization']);
        $employerFirstName = mysqli_real_escape_string($_POST['employerFirstName']);
        $employerLastName = mysqli_real_escape_string($_POST['employerLastName']);
        $employerEmail = mysqli_real_escape_string($_POST['employerEmail']);
        $employerPhone = mysqli_real_escape_string($_POST['employerPhone']);
        $employerStreet = mysqli_real_escape_string($_POST['employerStreet']);
        $employerBldNum = mysqli_real_escape_string($_POST['employerBldNum']);
        $employerCity = mysqli_real_escape_string($_POST['employerCity']);
        $employerState = mysqli_real_escape_string($_POST['employerState']);
        $employerZipcode = mysqli_real_escape_string($_POST['employerZipcode']);

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

<!-- Student Form -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Fieldwork Form</h5>
    <form name="studentForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <h5>Project Proposal</h5>
        <br>
		<label for="title">Project Title</label>
        <input id="title" name="title" type="text" class="w3-input" required>
        <br>
		<label for="organization">Name of Organization</label>
        <input id="organization" name="organization" type="text" class="w3-input" required>
        <br>
		<label for="orgStreet">Street</label>
        <input id="orgStreet" name="orgStreet" type="text" class="w3-input" placeholder="Enter the Organization's street address." required>
        <br>
        <label for="orgAptNum">Apt#</label>
        <input id="orgAptNum" name="orgAptNum" type="text" class="w3-input" placeholder="Enter the Apartment Number or Suite(if applicable)" >
        <br>
        <label for="orgCity">City</label>
        <input id="orgCity" name="orgCity" type="text" class="w3-input" placeholder="Enter the Organization's City." required>
        <br>
        <label for="orgState">State</label>
        <input id="orgState" name="orgState" type="text" class="w3-input" placeholder="Enter the Organization's State." required>
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
            <button type="button" name="continue" class="w3-button w3-teal" onclick="document.getElementById('internshipInformation').style.display = 'none'; document.getElementById('employerInformation').style.display = 'block';">Next</button>
            <button type="button" name="back" class="w3-button w3-teal" onclick="document.getElementById('studentInformation').style.display = 'block'; document.getElementById('internshipInformation').style.display = 'none';">Back</button>
        </div>
        <div id="employerInformation" style="display:none;">
            <h5>Employer Information</h5>
            <label class="w3-input" for="employerOrganization">Name of Organization: </label>
            <input type="text" class="w3-input" name="employerOrganization" id="employerOrganization" placeholder="Enter the Organization or Business's Name.">
            <label class="w3-input" for="employerFirstName">First name</label>
            <input type="text" class="w3-input" name="employerFirstName" id="employerFirstName" placeholder="Enter the Employer's First Name." required>
            <label class="w3-input" for="lastName">Last name</label>
            <input type="text" class="w3-input" name="employerLastName" id="employerLastName" placeholder="Enter the Employer's Last Name." required>
            <label class="w3-input" for="employerEmail">Email </label>
            <input type="email" class="w3-input" name="employerEmail" id="employerEmail" placeholder="Enter the Employer's Email.">
            <label class="w3-input" for="employerPhone">Phone number</label>
            <input type="tel" class="w3-input" name="employerPhone" id="employerPhone" maxlength=10 placeholder="Enter the Employer's Phone.">
            <br>
            <h5>Organization/Business Location</h5>
            <label class="w3-input" for="employerStreet">Street</label>
            <input type="text" class="w3-input" name="employerStreet" id="employerStreet" required>
            <label class="w3-input" for="employerBldNum">Building/Suite#</label>
            <input type="text" class="w3-input" name="employerBldNum" id="employerBldNum">
            <label class="w3-input" for="employerCity">City</label>
            <input type="text" class="w3-input" name="employerCity" id="employerCity" required>
            <label class="w3-input" for="employerState">State</label>
            <select class="w3-input" name="employerState" id="employerState" required>
                <option value="">Select the State.</option>
                <?php include('./backend/states.php') ?>
            </select>
            <label class="w3-input" for="employerZipcode">Zip</label>
            <input type="text" name="employerZipcode" id="employerZipcode" class="w3-input" required>
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