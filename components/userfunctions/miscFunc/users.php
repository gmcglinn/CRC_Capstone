<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <?php 
        if($_SESSION['user_type'] == $GLOBALS['admin_type']) {
            echo("<h5><b><i class='fa fa-plus'></i>  Admin User Tools</b></h5>");
        }
        else if($_SESSION['user_type'] == $GLOBALS['secretary_type']) {
            echo("<h5><b><i class='fa fa-plus'></i>  Secretary User Tools</b></h5>");
        }
        else{
            echo("<div class='w3-card w3-red w3-margin w3-padding'>You do not have access to this feature</div>");
            exit();
        }
    ?>
</header>

<!-- Action Panel -->


    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=users&contentType=view'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>View Users</h5></div>
    </div>
    </div>


    <!-- User Creation only available to Admin -->
    <?php if($_SESSION['user_type'] == $GLOBALS['admin_type']) { ?>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=users&contentType=create'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New User</h5></div>
    </div>
    </div>
    <?php } ?>
    
</div>