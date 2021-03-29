<?php
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/create/create.php');
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    
    if (isset($_POST['appCreate'])){
        if($_SESSION['user_type'] == $GLOBALS['student_type']){
		    $initiatorName = $_SESSION['user_name'];
		    $initiatorID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_name = '$initiatorName'"))['UID'];
		    $title = $_POST['title'];
		    $priority = $_POST['type'];
		    $deadline = $_POST['deadline'];
		    $templateID = $_POST['template'];
		    $template = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_app_template_table WHERE ATPID = '$templateID'"))['instructions'];
		

            $insertApp = "INSERT INTO f20_app_table (ASID, ATID, UID, title, instructions, deadline, created) 
                            VALUES (2, '$priority', '$initiatorID', '$title', '$template', '2020-11-28 21:47:51', '2020-11-10 21:47:51')";
            $insertAppQuery = mysqli_query($db_conn, $insertApp);

            //Database insert success
            if (mysqli_errno($db_conn) == 0) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Workflow app created successfully.</p></div>");
            } 
		    else { echo("<div class='w3-panel w3-margin w3-red'><p>Error - Form could not be sent.</p></div>");}
            //Database detected duplicate entry
            //else if (mysqli_errno($db_conn) == 1062) {  
            //   echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
            //}
        }
    }
?>

<!-- Student Form -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Fieldwork Form</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=app">
        <h5>Project Proposal</h5>
        <br>
		<label for="title">Project Title</label>
        <input id="title" name="title" type="project-title" class="w3-input" required>
        <br>
		<label for="organization">Name of Organization</label>
        <input id="organization" name="organization" type="organization-name" class="w3-input" required>
        <br>
		<label for="orgStreet">Street</label>
        <input id="orgStreet" name="orgStreet" type="org-streetname" class="w3-input" placeholder="Enter the Organization's street address." required>
        <br>
        <label for="orgAptNum">Apt#</label>
        <input id="orgAptNum" name="orgAptNum" type="org-AptNum" class="w3-input" placeholder="Enter the Apartment Number or Suite(if applicable)" >
        <br>
        <label for="orgCity">City</label>
        <input id="orgCity" name="orgCity" type="org-city" class="w3-input" placeholder="Enter the Organization's City." required>
        <br>
        <label for="orgState">State</label>
        <input id="orgState" name="orgState" type="org-state" class="w3-input" placeholder="Enter the Organization's State." required>
        <br>
        <label for="orgZipCode">Zip Code</label>
        <input id="orgZipCode" name="orgZipCode" type="org-zipCode" class="w3-input" placeholder="Enter the Organization's Zip Code." required>
        <br>
        <label for="supervisorName">Supervisor</label>
        <input id="supervisorName" name="supervisorName" type="supervisor-name" class="w3-input" required>
        <br>
        <label for="supervisorNum">Supervisor's Phone Number</label>
        <input id="supervisorNum" name="supervisorNum" type="supervisor-num" class="w3-input" required>
        <br>
        <h5> Learning Outcomes </h5>
        <label class="w3-input" for="outcomes1">
                1.) What are your responsibilities on site?<br>
                2.) What special project will you be working on?<br>
                3.) What do you expect to learn?
            </label>
            <input type="text" class="w3-input" name="outcomes1" id="outcomes1" required></input>
            <label class="w3-input" for="outcomes2">
                1.) How is the proposal related to your major areas of interest? Describe the course work you have completed which provides appropriate background to the project.
            </label>
            <input type="text" class="w3-input" name="outcomes2" id="outcomes2" required></input>
            <label class="w3-input" for="outcomes3">
                1.) What is the proposed method of study? Where appropriate, cite readings and practical experience.
            </label>
            <input type="text" class="w3-input" name="outcomes3" id="outcomes3" required></input>
            <br>
        <br>
		<label for="template">Workflow Template</label>
		<?php
			//Load templates
			include_once('./backend/config.php');
			include_once('./backend/db_connector.php');
			$sql = "SELECT ATPID, title from f20_app_template_table";
			$result = $db_conn->query($sql);
			if ($result->num_rows > 0){
				echo " <select class='w3-input' id='template' name='template'><option selected disabled hidden>Select a Workflow Template</option>";
				while($row = $result->fetch_assoc()){
			
					echo "<option value=".$row['ATPID']." id=".$row['ATPID'].">" .$row['title']. "</option>";
				}
			}
			echo "</select>";
        ?>
		<br>
        <button type="submit" class="w3-button w3-teal" name="appCreate">Submit</button>
    </form>
</div>