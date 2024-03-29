<!--
    Consolidate "Create Message" into "View Message"
-->
<?php
    //Loading the page title and action buttons.
	if($_SESSION['user_type'] == 1){
    include_once('./components/userfunctions/create/create.php');
	}
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');

    include('./backend/emailPlugin.php');
    

    if (isset($_POST['messageCreate'])) {
		$senderName = $_POST['sender'];
		$senderID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_login_name = '$senderName'"))['UID'];
        $sender = mysqli_real_escape_string($db_conn, $senderID);
		$receiverName = $_POST['receiver'];
		$receiverID = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_login_name = '$receiverName'"))['UID'];
		$receiver = mysqli_real_escape_string($db_conn, $receiverID);
        $type = mysqli_real_escape_string($db_conn, $_POST['type']);
        $status = mysqli_real_escape_string($db_conn, $_POST['status']);
		$subject = mysqli_real_escape_string($db_conn, $_POST['subject']);
        $contents = mysqli_real_escape_string($db_conn, $_POST['contents']);
		
		//sends email to receiver is message type is urgent
		if($type == 1){
		$to = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT * FROM f20_user_table WHERE user_login_name = '$receiverName'"))['user_email'];
        
         //test email function
         sendMail("mcglinng1@hawkmail.newpaltz.edu","TEST EMAIL","<html><h1>This is a test <br></h1><p>hello world</p></html>");

        }
		


        $insertMessage = "INSERT INTO f20_message_T (message_type, message_status, task_id, message_sender, message_receiver, message_subject, message_contents) 
                            VALUES ('$type', '$status', 1, '$sender', '$receiver', '$subject', '$contents')";
        $insertMessageQuery = mysqli_query($db_conn, $insertMessage);

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Message sent.</p></div>");
        } 
		else { echo("<div class='w3-panel w3-margin w3-red'><p>Error - Message could not be sent.</p></div>");}
        //Database detected duplicate entry
        //else if (mysqli_errno($db_conn) == 1062) {  
         //   echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create User - Duplicate Found.</p></div>");
        //}
    }
?>

<?php 
if($_SESSION['user_type'] == 1){
	?>
<!-- Admin Create Message -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Compose Message</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=message">
        <label for="sender">Sender</label>
        <input id="sender" name="sender" type="text" class="w3-input" placeholder="Enter the user's login name" required>
        <br>
		<label for="receiver">Receiver</label>
        <input id="receiver" name="receiver" type="text" class="w3-input" placeholder="Enter the user's login Name" required>
        <br>
        <label for="type">Type</label>
        <select id="type" name="type" class="w3-input">
		<option selected="" disabled="" hidden=""> Select a message type. </option>
		<option value="1" id="1">Urgent</option>
		<option value="2" id="2">Normal</option>
		</select>
        <br>
		<label for="status">Status</label>
        <select id="status" name="status" class="w3-input">
		<option selected="" disabled="" hidden=""> Select a status type. </option>
		<option value="1" id="1">New</option>
		<option value="2" id="2">Read</option>
		<option value="3" id="3">Deleted</option>
		</select>
        <br>
		<label for="subject">Message Subject</label>
        <input id="subject" name="subject" type="text" class="w3-input" required>
        <br>
        <label for="contents">Message Contents</label>
        <textarea id="contents" name="contents" type="text" class="w3-input" required></textarea>
        <br>
        <button type="submit" class="w3-button w3-teal" name="messageCreate">Send</button>
    </form>
</div>
<?php } else {?>
<!-- User Create Message -->
<div id="userForm" class="w3-card-4 w3-padding w3-margin">
    <h5>Compose Message</h5>
    <form method="post" action="./dashboard.php?content=create&contentType=message">
        <label for="sender">Sender</label>
        <input id="sender" name="sender" type="text" class="w3-input" value='<?php echo $_SESSION['user_login_name']?>' required readonly>
        <br>
		<label for="receiver">Receiver</label>
        <input id="receiver" name="receiver" type="text" class="w3-input" placeholder="Enter the user's login Name" required>
        <br>
        <label for="type">Type</label>
        <select id="type" name="type" class="w3-input">
		<option selected="" disabled="" hidden=""> Select a message type. </option>
		<option value="1" id="1">Urgent</option>
		<option value="2" id="2">Normal</option>
		</select>
        <br>
		<!--<label for="status">Status</label>-->
        <input id="status" name="status" type="hidden" class="w3-input" value="1" required readonly>
        <!-- <br> -->
		<label for="subject">Message Subject</label>
        <input id="subject" name="subject" type="text" class="w3-input" required>
        <br>
        <label for="contents">Message Contents</label>
        <textarea id="contents" name="contents" type="text" class="w3-input" required></textarea>
        <br>
        <button type="submit" class="w3-button w3-teal" name="messageCreate">Send</button>
    </form>
</div>
<?php }?>