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


    if(isset($_POST['remove'])) {
        
        include_once('./backend/db_connector.php');
        $TID = mysqli_real_escape_string($db_conn, $_POST['TID']);
        
        $sql = "DELETE FROM s21_form_templates WHERE TID = '$TID'";
        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Terminated this Form Congratulations</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
        }
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
        $sql = "SELECT * FROM s21_form_templates";
        $query = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_array($query);


        
?>
        

<!-- View Forms -->


<div id="formForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        
        
    </div>

    <h5>Form:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=workflow">
        <!-- Workflow ID, never displayed to the user but here for when the user submits the form to edit or remove. -->
        <input id="TID" name="TID" type="hidden" class="w3-input" value="<?php echo $TID; ?>" readonly>

        <label for="title" class="w3-input">Title:</label>
        <input id="title" name="forTitle" type="text" class="w3-input" value="<?php echo $row[1]; ?>" readonly>

        <!-- 
            
            PLEASE LOOK AT THIS 
        
        -->

        <label for="title" class="w3-input">Instructions:</label>
        <input id="title" name="formInstructions" type="text" class="w3-input" value="<?php echo $row[2]; ?>" readonly>

        <label for="title" class="w3-input">Responsibility:</label>
        <input id="title" name="formResponsible" type="text" class="w3-input" value="<?php echo $row[3]; ?>" readonly>

        <label for="title" class="w3-input">Created:</label>
        <input id="title" name="formCreateDate" type="text" class="w3-input" value="<?php echo $row[4]; ?>" readonly>

        <label for="title" class="w3-input">Changed:</label>
        <input id="title" name="formChangedDate" type="text" class="w3-input" value="<?php echo $row[5]; ?>" readonly>

        

        
        </select>

        <label for="created" class="w3-input">Created:</label>
        <input id="created" name="created" type="text" class="w3-input" value="<?php echo $row['created']; ?>" readonly>
        <br>
        <button type="button" class="w3-button w3-red" name="removeForm" onclick="removeEntry('<?php echo $TID ?>')">Remove</button>
        
    </form>
    
</div>


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange">
            <p>Warning!!</p>
            <p>Removing a form will terminate the entirety of a form, proceed with caution</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=forms&contentType=removeForm">
                    <input id="removeData" name="TID" type="hidden">
                    <button class="w3-button w3-red" type="submit" name="remove">Yes</button>
                    <button class="w3-button w3-blue" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(TID)
    {
        
        
        
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = TID;
    }
</script>


<?php 
    }
?>
