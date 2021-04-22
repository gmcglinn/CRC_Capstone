<?php 
include_once('../backend/config.php');
include_once('../backend/db_connector.php');

$uid = $_GET['u'];
$wf_id = $_GET['q'];

$sql = "SELECT form_info FROM s21_active_form_info WHERE uid= '$uid' AND WF_ID='$wf_id'";
$result = mysqli_query($db_conn, $sql);
$row = mysqli_fetch_assoc($result);

$form_structure = json_decode($row['form_info'], True);
$html_form = "<div class='w3-card-4 w3-padding w3-margin'>";

$form_title = $form_structure['form_title'];
$html_form.= "<h3>$form_title</h3>";
foreach ($form_structure as $key => $value) {
	if($key != 'form_title') {
		$state = 'disabled';

		$sql = "SELECT user_access_role FROM s21_form_templates WHERE title = '$form_title'";
		$result = mysqli_query($db_conn, $sql);
		$row = mysqli_fetch_assoc($result);

		if ($row['user_access_role'] == $_SESSION['user_type']) {
			$state = '';

		}

		$html_form.="<label class='w3-margin'>  $key </label>";
		$html_form.="<input type=text class='w3-input w3-margin' $state value=$value>";
	}
}

$html_form.="</div>";

echo($html_form);
?>