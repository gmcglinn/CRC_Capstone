<?php
$_SESSION['WF_ID'] = $_POST['WF_ID'];
?>
<header class="w3-container" style="padding-top:22px">
   <h2>Form Selection:</h2>
   <h3>Select your form.</h3>

</header>
<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&formType=secretary'"/>
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Secretary Form</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&formType=student'"/>
    <div class="w3-container w3-deep-orange w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Student Form</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&formType=faculty'"/>
    <div class="w3-container w3-green w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Instructor Form</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&formType=dean'"/>
    <div class="w3-container w3-red w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Dean Form</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&formType=chair'"/>
    <div class="w3-container w3-blue-grey w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Chair Form</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&formType=supervisor'"/>
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Supervisor Form</h5></div>
    </div>
    </div>
</div>