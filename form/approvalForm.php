<?php
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/create/create.php');
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    
    if (isset($_POST['appCreate'])){
        if($_SESSION['user_type'] == $GLOBALS['chair_type'] || $_SESSION['user_type'] == $GLOBALS['dean_type']){
		    $initiatorName = $_SESSION['user_name'];
		    $initiatorID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_name = '$initiatorName'"))['UID'];
		    $fname = mysqli_real_escape_string($db_conn, $_POST['fname']);
            $lname = mysqli_real_escape_string($db_conn, $_POST['lname']);
            $approval = mysqli_real_escape_string($db_conn, $_POST['approval']);
            $comments = mysqli_real_escape_string($db_conn, $_POST['comments']);
		
            $insertApp = "INSERT INTO f20_app_table (ASID, ATID, UID, approval, fname, lname, comments, created) 
                            VALUES (2, '$initiatorID', '$approval', '$fname', '$lname', '$comments', '2020-11-28 21:47:51', '2020-11-10 21:47:51')";
            $insertAppQuery = mysqli_query($db_conn, $insertApp);

            //Database insert success
            if (mysqli_errno($db_conn) == 0) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Workflow app created successfully.</p></div>");
            } 
		    else { echo("<div class='w3-panel w3-margin w3-red'><p>Error - Form could not be sent.</p></div>");}
        }
    }
?>

<!-- Approval Form -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <form name="approvalForm" method="post" action="./dashboard.php?content=create&contentType=app">
        <label for="fname">First Name</label>
        <input id="fname" name="fname" type="text" class="w3-input" required>
        <br>
	    <label for="lname">Last Name</label>
        <input id="lname" name="lname" type="text" class="w3-input" required>
        <br>
        <label class="w3-input" for="approval">Approve or Decline</label>
            <select class= "w3-input" name="approval" id="approval">
                <option value="">Select:</option>
                <option value="Fall">Approve</option>
                <option value="Spring">Decline</option>
            </select>
        <br>
	    <label for="comments">Comments</label>
        <input id="comments" name="comments" type="text" class="w3-input">
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