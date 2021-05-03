<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/courses/courses.php');


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


    if(isset($_POST['saveCourseChanges'])) {
        include_once('./backend/db_connector.php');
        //Get all user input.
        $workflowID = mysqli_real_escape_string($db_conn, $_POST['workflowID']);
        $title = mysqli_real_escape_string($db_conn, $_POST['workflowTitle']);
        $initiator = mysqli_real_escape_string($db_conn, $_POST['initiator']);
        $priority = mysqli_real_escape_string($db_conn, $_POST['priority']);
        $status = mysqli_real_escape_string($db_conn, $_POST['status']);
        $created = mysqli_real_escape_string($db_conn, $_POST['created']);
        $deadline = mysqli_real_escape_string($db_conn, $_POST['deadline']);

        $sql = "UPDATE f20_app_table 
                    SET ASID = $status,
                    ATID = '$priority',
                    `UID` = $initiator,
                    title = '$title',
                    created = '$created',
                    deadline = '$deadline'                     
                WHERE AID = $workflowID";
        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Edited this Workflow.</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error updating the workflow: " . $db_conn->error . "</p></div>");
        }
    }



    if(!isset($_POST['TID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No Course ID recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $TID = mysqli_real_escape_string($db_conn, $_POST['TID']);

        //Find all data related to the course.
        $sql = "SELECT * FROM s21_course_workflow_steps";
        $query = mysqli_query($db_conn, $sql);
        $row = mysqli_fetch_array($query);

        $TID = $row['ATPID'];
        $title = $row['workflow_title'];
        $instructions = $row['instructions'];
        $form_assignments = $row['form_assignments'];
        $form_assignments = str_replace(':', '=>', $form_assignments);
        $form_assignments = str_replace(',', ' | ', $form_assignments);
        $form_assignments = str_replace('"', '', $form_assignments);

?>


<!-- View Forms -->


<div id="courseForm" class="w3-card-4 w3-padding w3-margin">
    

    <h5>Course:</h5>
    <form method="post" action="./dashboard.php?content=courses&contentType=editSingle">
        <!-- Workflow ID, never displayed to the user but here for when the user submits the course to edit or remove. -->
        <input id="TID" name="TID" type="hidden" class="w3-input" value="<?php echo $TID; ?>" readonly>

        <label for="title" class="w3-input">Title:</label>
        <input id="title" name="courseTitle" type="text" class="w3-input" value="<?php echo $title; ?>" >

        <!--
        For the presentation we may only want to make title editable 
        Otherwise I was thinking we take the CREATE COURSE functionality and auto-fill it from the sql query    
        -->
        

        <label for="title" class="w3-input">Instructions:</label>
        <input id="title" name="instruction" type="text" class="w3-input" value="<?php echo $instructions; ?>" readonly>

        <label for="title" class="w3-input">Assignments:</label>
        <input id="title" name="assignments" type="text" class="w3-input" value="<?php echo $form_assignments; ?>" readonly>



        <br>
        <div id="editButtons" style="display: inline-block;">
            <button type="submit" class="w3-button w3-blue" name="saveCourseChanges">Save Changes</button>
        </div>
    </form>
    
</div>

<?php 
    }
?>
