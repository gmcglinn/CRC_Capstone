<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Session Expired, Please sign in again.</p></div>";
        exit();
    }

    //Message ID was not sent to the page.
    if(!isset($_POST['message_ID'])) {
        echo "<div class='w3-panel w3-margin w3-red'><p>Error! No message recieved</p></div>";
        exit();
    }
    else {
        include_once('./backend/util.php');
        include_once('./backend/db_connector.php');

        //Gather data passed to this page.
        $messageID = mysqli_real_escape_string($db_conn, $_POST['message_ID']);

        //User chooses to delete message.
        if(isset($_POST['remove'])) {
            $sql = "UPDATE f20_user_table SET USID = 3 WHERE user_email = '$userEmail'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Terminated " . $userEmail . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error terminating user: " . $db_conn->error . "</p></div>");
            }
        }
        else if(isset($_POST['saveUserChanges'])) {
            //Gather all input form fields.
            $userRole = mysqli_real_escape_string($db_conn, $_POST['type']);
            $userStatus = mysqli_real_escape_string($db_conn, $_POST['status']);
            $userName = mysqli_real_escape_string($db_conn, $_POST['name']);
            $userNewEmail = mysqli_real_escape_string($db_conn, $_POST['userEmail']);
            $userPassword = mysqli_real_escape_string($db_conn, $_POST['password']);
                
            $sql = "UPDATE f20_user_table 
                        SET `URID` = $userRole,
                        `USID` = $userStatus,
                        `user_name` = '$userName',
                        `user_email` = '$userEmail',
                        `user_password` = '$userPassword'
                        WHERE `user_email` = '$userEmail'";
            if ($db_conn->query($sql) === TRUE) {
                echo("<div class='w3-panel w3-margin w3-green'><p>Successfully Updated " . $userEmail . "</p></div>");
            } 
            else {
                echo("<div class='w3-panel w3-margin w3-red'><p>Error updating user: " . $db_conn->error . "</p></div>");
            }
        }
        else {
            //Find all data related to the user.
            $sql = "SELECT * FROM f20_message_T WHERE message_id = '$messageID'";
			//echo $sql;
            $query = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($query);
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Message View</b></h5>
</header>

<!-- Message Information -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <div class="w3-right" id="actionButtons">
        <button type="button" class="w3-button w3-blue" name="editUser" style="margin-right: 5px;" onclick="enableEdit()">Edit</button>
        <button type="button" class="w3-button w3-red" name="removeUser" onclick="removeEntry('<?php echo $userEmail ?>')">Remove</button>
    </div>

    <h5>Message:</h5>
    <form method="post" action="./dashboard.php?content=view&contentType=user">
	<?php
        $messageSenderId = $row['message_sender'];
        $messageReceiverId = $row['message_receiver'];
        $messageTypeId = $row['message_type'];
		$messageStatusId = $row['message_status'];
	?>
        <label class="w3-input" for="sender">Sender</label>
        <input class="w3-input" id="sender" name="sender" type="text" value="<?php echo mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$messageSenderId'"))['user_name']; ?>" readonly>
        <label class="w3-input" for="receiver">Receiver</label>
        <input class="w3-input" id="receiver" name="receiver" type="text" value="<?php echo mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE UID = '$messageReceiverId'"))['user_name']; ?>" readonly>
        <label class="w3-input" for="type">Message Type</label>
        <input class="w3-input" id="type" name="type" type="type" value="<?php echo mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_messageType_T WHERE messageType_id = '$messageTypeId'"))['messageType_Title']; ?>" readonly>
        <label class="w3-input" for="status">Message Status</label>
        <input class="w3-input" id="status" name="status" type="status" value="<?php
		//update message status from new to read if it is being opened by the receiver
		if($messageStatusId == 1 && $messageReceiverId == $_SESSION['user_id']){
			$update_stmt = "UPDATE f20_message_T SET message_status = 2 WHERE message_id = '$messageID'";
			mysqli_query($db_conn, $update_stmt);
			$messageStatusId = 2;
		}
		echo mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_messageStatus_T WHERE messageStatus_id = '$messageStatusId'"))['messageStatus_title'];
		?>" readonly>	
		
        <label class="w3-input" for="subject">Message Subject</label>
		<input class="w3-input" id="subject" name="subject" type="text" value="<?php echo $row['message_subject']; ?>" readonly>		
        <br>
		<label class="w3-input" for="contents">Message Contents</label>
		<textarea id="contents" name="contents" type="text" class="w3-input" readonly><?php echo $row['message_contents']; ?></textarea>
        <div id="editButtons" style="display: none;">
            <button type="submit" class="w3-button w3-blue" name="saveUserChanges">Save</button>
            <button type="button" class="w3-button w3-red" onclick="disableEdit()">Cancel</button>
        </div>
    </form>
</div>


<!-- Modal Pop-up to warn of deletion -->
<div id="warningHolder" class="w3-modal w3-center">
    <div class="w3-modal-content">
        <div class="w3-container w3-orange">
            <p>Warning!!</p>
            <p>'Removing' a user will terminate their account.</p>
            <p>Are you sure this is what you want to do?
                <br>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <input id="removeData" name="userEmail" type="hidden">
                    <button class="w3-button w3-red" type="submit" name="remove">Yes</button>
                    <button class="w3-button w3-black" type="button" onclick="document.getElementById('warningHolder').style.display='none'">No</button>
                </form>
            </p>
        </div>
    </div>
</div>

<!-- Remove from database Script -->
<script>
    function removeEntry(user)
    {
        //Display the warning modal.
        document.getElementById('warningHolder').style.display='block';
        //Replace hidden input data to prepare for if the user chooses to submit.
        document.getElementById('removeData').value = user;
    }
</script>

<!-- Enable/Disable table editing Script -->
<script>
    function enableEdit()
    {
        //Disable readonly on inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=false;
        }
        //Hide the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "none";
        //Show the save and cancel buttons.
        document.getElementById("editButtons").style.display = "inline-block";
    }
    function disableEdit()
    {
        //Re-enable readonly on all inputs.
        var inputs = document.querySelectorAll(".w3-input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly=true;
        }
        //Hide the save and cancel buttons.
        document.getElementById("editButtons").style.display = "none";
        //Show the edit and remove buttons.
        document.getElementById("actionButtons").style.display = "inline-block";
    }
</script>

<?php }
    }
?>