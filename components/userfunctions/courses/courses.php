<?php
    //Connect database.
    include_once('./backend/db_connector.php');
    include_once('./backend/util.php');
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-share-alt"></i>  Courses (Workflow Template) Dashboard</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
<div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=courses&contentType=view'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>View Courses</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=courses&contentType=create'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New Course</h5></div>
    </div>
    </div>

    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=courses&contentType=edit'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-gear w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Edit Courses</h5></div>
    </div>
    </div>
    
    
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=courses&contentType=delete'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-minus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Delete Course</h5></div>
    </div>
    </div>
</div>

<!-- Feed could go here when implemented to fill the content of the page -->