<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/forms/forms.php');


    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }
    //User is not an admin/sec.
    if(!($_SESSION['user_type'] == $GLOBALS['admin_type']) && !($_SESSION['user_type'] == $GLOBALS['secretary_type'])){
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! You do not have permission to access this information.</p></div>";
        exit();
    }




    if(!isset($_POST['TID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No Form ID recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $TID = mysqli_real_escape_string($db_conn, $_POST['TID']);

        //Find all data related to the workflow.
        $sql = "SELECT * FROM s21_form_templates WHERE TID = $TID";
        $query = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_array($query);
    }

    include_once('./backend/util.php');
    include_once('./backend/db_connector.php');
if(isset($_POST['formCreate'])) {	
	$form_structure = $_POST['formStructure'];
	$form_name = mysqli_real_escape_string($db_conn, $_POST['formName']);
	$user_access_type = mysqli_real_escape_string($db_conn, $_POST['user_type']);
	
	$sql = "SELECT URID FROM f20_user_role_table WHERE user_role_title = '$user_access_type'";
	$result = mysqli_query($db_conn, $sql);
	$row = mysqli_fetch_assoc($result);

	$user_access_type = $row['URID'];

	$sql = "UPDATE `s21_form_templates` SET title = '$form_name', instructions = '$form_structure', user_access_role = '$user_access_type' WHERE TID = '$TID'";



	$result = mysqli_query($db_conn, $sql);

	if ($result) {
            
        echo("<div class='w3-card w3-green w3-margin w3-padding'>Successfully Edited Form.</div>");
    }       
	else {
            echo("<div class='w3-card w3-red w3-margin w3-padding'> Error Editing Form.</div>");
    }
}
	
?>

<script>
	var fieldNames = [];

	function AddW3Classes() {
		if (document.getElementById('formPreview').classList.length == 0) {
			document.getElementById('formPreview').classList.add('w3-card-4');
			document.getElementById('formPreview').classList.add('w3-padding');
			document.getElementById('formPreview').classList.add('w3-margin');
		}
	}

	function AddField(event) {
		event.preventDefault();
		fieldNames.push(document.getElementById('addField').value);
		document.getElementById('addField').value = '';
		
		AddW3Classes();
		UpdateHiddenInput();

		if (!document.getElementById('templateHeader')) {
				document.getElementById('userForm').outerHTML += "<h2 id=templateHeader class=w3-padding > Form Preview </h2>";
		}
		
		if (fieldNames.length == 1) {
			document.getElementById('submit').innerHTML += `<br>
                                                                <input type="hidden" name="TID" value="<?php echo $TID;?>">
																<button class='w3-button w3-green' type="submit" name="formCreate"> Modify Form </button> 
																`;

		}
		
		let newField = fieldNames[fieldNames.length - 1];
		let fieldNumber = fieldNames.length

		document.getElementById('formPreview').innerHTML +=  `
															<div id = field` + newField + `
																<label class="w3-margin">  ` + newField + `</label> 
																<div class = 'w3-row '>

																	<div class="w3-threequarter" > 
																		<input type=text class="w3-input w3-gray"/> 
																	</div>
																
																	<div class="w3-margin-left w3-center" > 
																		<button class="w3-button w3-margin-right w3-green" onClick='document.ge'> Edit</button>
																		<button class="w3-button w3-red" onclick='RemoveField(event, "` + newField + `")'> 
																			Delete
																		</button>
																	</div>

																</div>
															</div>
															`  ;
		
	}

	function AddFormTitle(event) {
		event.preventDefault();
		title = document.getElementById('addTitle').value;
		document.getElementById('addTitle').value = '';
		document.getElementById('formTitle').innerHTML = title;
		document.getElementById('formName').value = title;

		AddW3Classes();

		if (!document.getElementById('templateHeader')) {
			document.getElementById('userForm').outerHTML += "<h2 id=templateHeader class=w3-padding > Form Preview </h2>";
		}
	}
	
	function RemoveField(event,  fieldName) {
		event.preventDefault();
		
	    for( var i = 0; i < fieldNames.length; i++){ 
    
        if ( fieldNames[i] === fieldName) { 
    
            	fieldNames.splice(i, 1); 
			}
    
    	}
		
		console.log(fieldNames + "deletion");
		document.getElementById('field'+fieldName).remove();
		
		UpdateHiddenInput();
	}

	function EditField(event, fieldName) {
		event.preventDefault();
		document.getElementById('field'+fieldName)
	}

	function UpdateHiddenInput(formName) {
		values = fieldNames.slice(0, fieldNames.length);
		obj = {}
		

		for (let i = 0; i < values.length; i++) {
			obj[values[i]] = "";
		}
		
		obj['form_title'] = document.getElementById('formName').value;
		parsed_vals = JSON.stringify(obj);

		document.getElementById("formStructure").value = parsed_vals;
		console.log(parsed_vals);
	}
	
</script>

<h2 class='w3-margin'> Edit Form</h2>
<div id=userForm class='w3-card-4 w3-padding w3-margin'>
	<form onSubmit= 'AddFormTitle(event)'/>
		<h4>Form Title</h4>
    	<input id=addTitle  name= addTitle  type= text placeholder="Modify Course Title" class= 'w3-input' required/>		
    	<br>
    	<button type='submit' name=addTitle class='w3-button w3-teal'>Change Form Title</button>
    	<!--<button onclick='Increment()' name='studentSubmit' class='w3-button w3-teal'>Create Form</button>
		-->
	</form>
	
	<form onSubmit= 'AddField(event)'/>
		<h4>New Field</h4>
    	<input id=addField  name= addField  type= text placeholder="Enter Field Name" class= 'w3-input' required/>		
    	<br>
    	<button type='submit' name=addField class='w3-button w3-teal'>Add Input</button>
	</form>

	<form id=submit method=post>
		<input id='formStructure' type="hidden" name="formStructure"/>
		<input id='formName' type="hidden" name="formName"/>
		<input id='user' type="hidden" name="user"/>
		<br>
        <select id="user_type" name="user_type" class="w3-input">
            <option value="">Please select the user who has access to this form.</option>
            <?php
                $sql = "SELECT DISTINCT user_role_title FROM `f20_user_role_table`";
                $result  = mysqli_query($db_conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $user_type = $row['user_role_title'];
                    echo("<option value=" . $user_type . ">" . $user_type . "</option>");
                }
            ?>
        </select>
	</form>
</div>

<div id="formPreview">
	<div class = 'w3-blue'>
		<h3 id='formTitle' class='w3-margin-left'></h3>
	</div>
	<br>
</div>
