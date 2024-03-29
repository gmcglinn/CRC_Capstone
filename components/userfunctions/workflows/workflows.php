<?php
    //Connect database.
    include_once('./backend/db_connector.php');
    include_once('./backend/util.php');
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-share-alt"></i>  Workflow Dashboard</b></h5>
</header>

<!-- Action Panel -->
<?php if(($_SESSION['user_type'] == $GLOBALS['admin_type']) || ($_SESSION['user_type'] == $GLOBALS['secretary_type'])){
?>
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=active'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>In-Progress</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=new'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>New</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=completed'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-check w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Completed</h5></div>
    
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=workflows&contentType=start'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New WorkFlow</h5></div>
    </div>
    </div>
</div>
<?php
} else {
?>
    <div class="w3-third" onclick="window.location.href='./dashboard.php?content=workflows&contentType=active'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Active</h5></div>
    </div>
    </div>
    <div class="w3-third" onclick="window.location.href='./dashboard.php?content=workflows&contentType=new'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>New</h5></div>
    </div>
    </div>
    <div class="w3-third" onclick="window.location.href='./dashboard.php?content=workflows&contentType=completed'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-check w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Completed</h5></div>
    
    </div>
    </div>
<?php
}
?>
<!-- Feed could go here when implemented to fill the content of the page -->