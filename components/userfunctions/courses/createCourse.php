<!--
    This file is for the creation of workflows work may be needed:
    1. Organization.
    2. May need database work.
-->
<?php
    include_once('./components/userfunctions/courses/courses.php');
    
    if (isset($_POST['workflowCreate'])) {
        include_once('./backend/config.php');
		include_once('./backend/db_connector.php');
		
		if (isset($_POST['hiddeninput'])) {
			$newWorkflowOrder = str_replace(',', '=>', $_POST['hiddeninput']);
			$workflow_title = $_POST['workflowTitle'];
			$course_number = $_POST['course_number'];
			$form_type = $_POST['form_type'];
            $form_assignments = $_POST['formAssignments'];
            //Insert into Dattabase
			$sql = "INSERT INTO s21_course_workflow_steps (TSID, workflow_title, instructions, form_assignments, form_type, course_number) 
				VALUES (1, '$workflow_title', '$newWorkflowOrder', '$form_assignments','$form_type', '$course_number')";
			mysqli_query($db_conn, $sql);
        	//Database insert success
        	if (mysqli_errno($db_conn) == 0) {
            	echo("<div class='w3-panel w3-margin w3-green'><p>New Workflow Successfully Created.</p></div>");
        	} 
        	//Database detected duplicate entry
        	else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course - Duplicate Found.</p></div>");
        	}
        	else {
            	echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course</p></div>");

        	}

		}
		else {
			echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Workflow. No Entry for workflow order</p></div>");
		}
		
    }
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-plus"></i>  Admin Create Tool</b></h5>
</header>

<!-- Create Workflow -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin" style="display: block;">
    <h5 onload="LoadFormOptions()">Create New Course (Workflow Template)</h5>
    <p>You can create a custom course (workflow template) here.</p>
    <form id="subform" method="post">
        <label for="workflowTitle">Course Title (Workflow Template Title)</label>
        <input class="w3-input" type="text" name="workflowTitle" required></input>
        
        <label for="form_type">Course Type (Workflow Type):</label>
        <select name="form_type" class="w3-input">
            <option value="internship">Internship/Fieldwork (General)</option>
            <option value="transferCred">Transfer Credit Evaluation (Not Implemented)</option>
        </select>
		<label class="w3-input" for="department">Department</label>
        <select class="w3-input" name="department" id="department" onchange="showCourse(this.value)">
            <option value="">Select a Department:</option>
            <?php 
                include_once('./backend/db_connector.php');

                $sql = "SELECT * FROM `f20_academic_dept_info`";
                $query = mysqli_query($db_conn, $sql);
                if ($query) {
                    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        echo("<option value='" . $row['dept_code'] . "'>" . $row['dept_name'] . "</option>");
                    }
                }
            ?>
        </select>
        
        <label class="w3-input" for="course_number">Course</label>
        <select class="w3-input" name="course_number" id="course">
            <option value="">Select a course:</option>
        </select>
        <div class='w3-quarter w3-margin'>
            <br>
            <h2>Participant List</h2>
            <p>Drag and Drop participants to their appropriate order</p>

            <?php
                $userLabels = array('Records & Registration', 'Career Resource Center', 'Dean', 'Chair', 'Secretary', 'Student', 'Employer', 'Faculty [Advisor/Instructor]');
                $userTypes = array('Recreg', 'Crc', 'Dean', 'Chair', 'Secretary', 'Student', 'Employer', 'Faculty');
                $length = count($userTypes);
                for ($i=0; $i < $length; $i++) {
            ?>
                <label for=""><?php echo $userLabels[$i]; ?></label>
                <div id='labelContOrig<?php echo $i; ?>' class='labelContainer' ondrop='drop(event)' ondragover='allowDrop(event)'>
                    <strong id='<?php echo $userTypes[$i]; ?>' draggable='true' ondragstart='drag(event)'><?php echo $userTypes[$i]; ?></strong>
                </div>
    			
            <?php
                }
    		?>
        </div>	
        <br>
        <div class='w3-half w3-margin'>
            <div class='w3-right'>
            <!-- Workflow visualizer -->
            <h2>Workflow Order</h2>
            <p>Click the circle with a "+" to add another participant.</p>
            <div id='workflowOrder' class="w3-border w3-center w3-row">
                    <div id="circleList" class="circleList w3-center">
                        <div class="circle" onclick="addParticipant(event)">+</div>
                    </div>
            </div>
        <br>
        <input type="submit" value="Create Workflow Template" class="w3-button w3-teal w3-center" name="workflowCreate"></input>
        <input id=formAssignments name=formAssignments type="hidden"> </input>
        </div>
    </form>
</div>

<!-- Script for enabling drag and drop-->
<script>
    var numParticipants = 1;

    function allowDrop(event) {
        event.preventDefault();
    }
    function drag(event) {
        event.dataTransfer.setData("text", event.target.id);
    }
	
	let arr =["null", "null", "null", "null", "null", "null", "null", "null"];
    function drop(event) {
        event.preventDefault();
        var data = event.dataTransfer.getData("text");
		var thisStep = event.target.id;

		if (thisStep == "labelContainer1"){ 
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[0] = data;
		}
		else if (thisStep == "labelContainer2"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[1] = data;
		}
		else if (thisStep == "labelContainer3"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[2] = data;
		}
		else if (thisStep == "labelContainer4"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[3] = data;
		}
		else if (thisStep == "labelContainer5"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[4] = data;
		}
		else if (thisStep == "labelContainer6"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[5] = data;
		}
		else if (thisStep == "labelContainer7"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[6] = data;
		}
		else if (thisStep == "labelContainer8"){
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
			arr[7] = data;
		}
		else{
			if(arr.includes(data)){
				for(i = 0; i < arr.length; i++){
					if(arr[i] == data){
						arr[i] = "null";
					}
				}
			}
		}

		//testing
		//alert("current order: " + arr[0] + ", " + arr[1] + ", " + arr[2] + ", " + arr[3] + ", " + arr[4] + ", " + arr[5] + ", " + arr[6] + ", " + arr[7]);
		
		workflow_size = numParticipants - 1;
		if (workflow_size > 0){  
			var x = document.createElement("INPUT");
			x.setAttribute("id", "submission");
			x.setAttribute("type", "hidden");
			x.setAttribute("value", arr.slice(0, workflow_size));
			x.setAttribute("name", "hiddeninput");
			var element =  document.getElementById("submission");
			if (typeof(element) != 'undefined' && element != null)
			{
			document.getElementById("subform").replaceChild(x, element);
			}
			else document.getElementById("subform").appendChild(x);
		}
		event.target.appendChild(document.getElementById(data));

        //Removing fixed-size box from the visualizer (may need work - doesn't reset if the user changes position).
        document.getElementById(event.target.id).style.border = "none";
    }

</script>

<!-- Script for adding more participants to the workflow. -->
<script> 
    var options = "";
    window.onload = function LoadFormOptions() {
        fetch("backend/formUtils/getFormTitles.php", {
            method:'POST',
             headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
        })
        .then(response => response.text())
        .then(data => data.split("=>"))
        .then( forms => {

            for (let i =  0; i < forms.length - 1; i++) {
                options += "<option value='" + forms[i] + "'>" + forms[i] +  "</option>";
            }
        });
    }


    function addParticipant(event) {   
        event.preventDefault();
        num = numParticipants;

        if(numParticipants < 9) {
            //Add a line, circle, and label.
            var addParticipantHTML = "<div class='w3-row w3-margin'><div class='w3-col m4 13'><div class='circle'>" + numParticipants + "</div></div>"
            
            addParticipantHTML += "<div class='spacer'></div><div class='w3-col m4 13'><div id='labelContainer" + numParticipants + "' class='userType' style='border: 1px solid black;' ondrop='drop(event)' ondragover='allowDrop(event)'></div></div>";

            addParticipantHTML += "<div class='spacer'></div><div class='w3-col m4 13 w3-margin'><div id='formContainer' class='formType' ><select id =form"+ num +  " onChange= 'UpdateFormAssignments(" + num + ");'> <option>Select Form</option>"+ options + " </select> </div></div> </div>";

            document.getElementById('workflowOrder').innerHTML += addParticipantHTML;
        }
        if(numParticipants == 8) {
            //Remove the + circle
            circleList = document.getElementById('circleList');
            circleList.removeChild(circleList.children[0]);
            circleList.removeChild(circleList.children[0]);
            //Remove the label from the + circle
            labelList = document.getElementById('labelList');
            labelList.removeChild(labelList.children[0]);
            labelList.removeChild(labelList.children[0]);
        }

        numParticipants++;   
    } 

</script>

<script>
    form_assignments = {};

    function UpdateFormAssignments(num) {
        container_check = document.getElementById("labelContainer"+num).children;
        
        if(container_check.length != 0) {
            user_role = document.getElementById("labelContainer"+num).children[0].innerText
            user_form = document.getElementById("form"+num).value
            form_assignments[user_role] = user_form;
            
            parsed_vals = JSON.stringify(form_assignments);
            document.getElementById('formAssignments').value = parsed_vals;
       }
        
    }

</script>

<script>
    function showCourse(str) {
        if (str == "") {
            document.getElementById("course").innerHTML = "";
            return;
        } 
        else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("course").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","./backend/getCourse.php?q="+str,true);
            xmlhttp.send();
        }
    }
</script>