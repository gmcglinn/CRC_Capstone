<!--
    This file is for the creation of workflows work may be needed:
    1. Organization.
    2. May need database work.
-->
<?php
    if (isset($_POST['workflowCreate'])) {
        include_once('./backend/config.php');
		include_once('./backend/db_connector.php');
		
		if (isset($_POST['hiddeninput'])) {
			$newWorkflowOrder = str_replace(',', '=>', $_POST['hiddeninput']);
			$title = $_POST['workflowTitle'];
			$course_number = $_POST['course_number'];
			$form_type = $_POST['form_type'];

            //Insert into Dattabase
			$sql = "INSERT INTO s21_course_workflow_steps (TSID, title, instructions, form_type, course_number) 
				VALUES (1, '$title', '$newWorkflowOrder', '$form_type', '$course_number')";

			mysqli_query($db_conn, $sql);
        	//Database insert success
        	if (mysqli_errno($db_conn) == 0) {
            	echo("<div class='w3-panel w3-margin w3-green'><p>Workflow Successfully Created.</p></div>");
        	} 
        	//Database detected duplicate entry
        	else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Workflow - Duplicate Found.</p></div>");
        	}
        	else {
            	echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Workflow.</p></div>");

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

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
<div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=courses&contentType=active'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>View Courses</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=courses&contentType=new'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New Course</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=start'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-gear w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Edit Courses</h5></div>
    </div>
    </div>
    
    
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=start'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-minus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Delete Course</h5></div>
    </div>
    </div>
</div>
 
<!-- Create Workflow -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin" style="display: block;">
    <h5>Create Course Template</h5>
    <p>You can create a custom Course template here.</p>
    <form id="subform" method="post">
	<div class =row>
        <label for="workflowTitle">Course Template Title</label>
        <input class="w3-input" type="text" name="workflowTitle"></input>
        
        <label for="form_type">Course Type:</label>
        <select name="form_type" class="w3-input">
            <option value="internship">Internship/Fieldwork (General)</option>
            <option value="transferCred">Transfer Credit Evaluation (Not Implemented)</option>
        </select>
        
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

		<label class="w3-input" for="department">Department</label>
        <select class="w3-input" name="department" id="department" onchange="showCourse(this.value)">
            <option value="">Select a department:</option>
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
        <!-- Workflow visualizer -->
        <h2>Course Order</h2>
        <p>Click the circle with a "+" to add another participant.</p>
        <div class="w3-padding w3-border">
            <div id="circleList" class="circleList">
                <div class="circle" onclick="addParticipant()">+</div>
            </div>
            <div id="labelList" class="labelList">
                <div id="labelContainer" class="userType" style="border: 1px solid black;"></div>
            </div>
        </div>
        <br>
        <input type="submit" value="Create Workflow Template" class="w3-button w3-teal" name="workflowCreate"></input>
    </form>
</div>


<!-- Script for enabling drag and drop-->
<script>
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
		
		workflow_size = parseInt(document.getElementById('circleList').lastChild.innerHTML);
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
    function addParticipant()
    {
        //Find how many participants there are.
        numParticipants = Math.ceil(document.getElementById('circleList').children.length/2);

        if(numParticipants < 9) {
            //Add a line, circle, and label.
            document.getElementById('circleList').innerHTML += "<div class='line'></div><div class='circle'>" + numParticipants + "</div>";
            document.getElementById('labelList').innerHTML += "<div class='spacer'></div><div id='labelContainer" + numParticipants + "' class='userType' style='border: 1px solid black;' ondrop='drop(event)' ondragover='allowDrop(event)'></div>";
        
            //Participant list is full
            if(numParticipants == 8)
            {
                //Remove the + circle
                circleList = document.getElementById('circleList');
                circleList.removeChild(circleList.children[0]);
                circleList.removeChild(circleList.children[0]);
                //Remove the label from the + circle
                labelList = document.getElementById('labelList');
                labelList.removeChild(labelList.children[0]);
                labelList.removeChild(labelList.children[0]);
            }
        }
	} 
</script>