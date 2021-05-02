<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
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


    if(isset($_POST['remove'])) {
        
        include_once('./backend/db_connector.php');
        $ATPID = mysqli_real_escape_string($db_conn, $_POST['ATPID']);
        
        $sql = "DELETE FROM s21_course_workflow_steps WHERE ATPID = '$ATPID'";
        if ($db_conn->query($sql) === TRUE) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Terminated this Workflow</p></div>");
        } 
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Error removing record: " . $db_conn->error . "</p></div>");
        }
    }

?>
<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-wrench"></i>  Forms Dashboard</b></h5>
</header>

<!-- Form Search -->
<div id="formSearch" class="w3-card-4 w3-padding w3-margin">
    <h5>Course Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class='w3-center'>Course Title</th>
            <th class='w3-center'>Instructions</th>
            <th class='w3-center'>Form Assignments</th>
        </tr>

        <?php
            $sql = "SELECT * FROM s21_course_workflow_steps";
            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $ATPID = $row['ATPID'];
                $title = $row['workflow_title'];
                $instructions = $row['instructions'];
                $form_assignments = $row['form_assignments'];
                $form_assignments = str_replace(':', '=>', $form_assignments);
                $form_assignments = str_replace(',', ' | ', $form_assignments);
                $form_assignments = str_replace('"', '', $form_assignments);
        ?>
        <tr>
            <td class='w3-center'><?php echo $title; ?></td>
            <td class='w3-center'><?php echo $instructions; ?></td>
            <td class='w3-center'><?php echo $form_assignments; ?></td>
            <td>
                <button type="submit" name="removeForm" class="w3-button w3-red"  onclick="removeEntry(<?php echo $ATPID ?>)">REMOVE</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange">
            <p>Warning!!</p>
            <p>Removing a form will terminate the entirety of a form, proceed with caution</p>
            <p>Are you sure?
                <br>
                <form method="post" action="./dashboard.php?content=courses&contentType=delete">
                    <input id="removeData" name="ATPID" type="hidden">
                    <button class="w3-button w3-red" type="submit" name="remove">Yes</button>
                    <button class="w3-button w3-blue" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(ATPID) {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = ATPID;
    }
</script>
