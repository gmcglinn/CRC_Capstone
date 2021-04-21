<?php
include_once('../backend/config.php');
include_once('../backend/db_connector.php');

$wf_id= $_GET['q'];
$sql = "SELECT form_assignments FROM s21_active_workflow_info AS s JOIN s21_course_workflow_steps AS s2 ON s.ATPID = s2.ATPID WHERE WF_ID = '$wf_id' ";

$result = mysqli_query($db_conn, $sql);
$row = mysqli_fetch_assoc($result);

$forms = $row['form_assignments'];
$forms = json_decode($forms, True);

$form_list_html = "
<header class='w3-container' style='padding-top:22px'>
   <h2>Form Selection:</h2>
   <h3>Select your form.</h3>

</header>

<div class='w3-row-padding w3-margin-bottom'> ";
foreach ($forms as $key => $value) {
    $form_list_html.="<div class='w3-quarter' onClick=displayForm('$wf_id',". $_SESSION['user_id'].")>
                      <div class='w3-container w3-blue w3-padding-16 w3-border'>
                        <div class='w3-left'><i class='fa fa-users w3-xxxlarge'></i></div>
                        <div class='w3-clear'><h5>$value</h5></div>
                    </div>
                    </div>";
    }

$form_list_html.="</div>";
echo($form_list_html);
?>