<?php include_once('./backend/config.php') ?>

<!-- Action Panel 
The action panel contains four buttons for navigation which include that user type's 
main functions. Since the application does not allow UI-customization all action
panels are contained in this file and printed based on the user type.
-->

<?php 
    if($_SESSION['user_type'] == $GLOBALS['admin_type']) {
?>
        <!-- Currently, only the admin has a unique action panel. -->
        <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter" onClick="location.href = './dashboard.php?content=adminTools'">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-diamond w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Admin Tools</h4>
                </div>
            </div>

            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=search'">
                <div class="w3-container w3-blue w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-search w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Search</h4>
                </div>
            </div>

            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=courses'">
                <div class="w3-container w3-teal w3-padding-16">
                    <div class="w3-left"><i class="fa fa-wrench w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Courses</h4>
                </div>
            </div>
            
            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=users'">
                <div class="w3-container w3-green w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-user w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Users</h4>
                </div>
            </div>


        </div>
<?php
    }
    else if (($_SESSION['user_type'] == $GLOBALS['secretary_type'])){
?>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=messages'">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Messages</h4>
                </div>
            </div>
            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=search'">
                <div class="w3-container w3-blue w3-padding-16">
                    <div class="w3-left"><i class="fa fa-search w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Search</h4>
                </div>
            </div>
    
            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=files'">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-files-o w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Files</h4>
                </div>
            </div>

            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=workflows'">
                <div class="w3-container w3-teal w3-padding-16">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Workflows</h4>
                </div>
            </div>
        </div>
<?php
    }
    else {
?>
        <!-- All other users see the same action panel. -->
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=alerts'">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Alerts</h4>
                </div>
            </div>

            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=messages'">
                <div class="w3-container w3-blue w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Messages</h4>
                </div>
            </div>

            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=workflows'">
                <div class="w3-container w3-teal w3-padding-16">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Workflows</h4>
                </div>
            </div>

            <div class="w3-quarter" onClick="location.href = './dashboard.php?content=files'">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-files-o w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4>Files</h4>
                </div>
            </div>
        </div>
<?php
    }
?>



