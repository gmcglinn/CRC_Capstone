<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    //include_once('./components/userfunctions/search/search.php');
?>
<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-wrench"></i>  Forms Dashboard</b></h5>
</header>
<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=view'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>View Form</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=create'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Create New Form</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=edit'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-gear w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Edit Form</h5></div>
    </div>
    </div>
    
    
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=forms&contentType=delete'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-minus w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Delete Form</h5></div>
    </div>
    </div>
</div>

<!-- Form Search -->
<div id="formSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=forms&contentType=create'">Start New Form</button>
    <h5>Forms Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Form Title</th>
            <th>Responsible</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Created</th>
            <!--<th>Deadline</th>
            <th>Actions</th>-->
        </tr>

        <?php
            $sql = "SELECT * FROM s21_form_templates";

            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $TID = $row['TID'];
                $title = $row['title'];
                $instructions = $row['instructions'];
                $user_access_role = $row['user_access_role'];
                $created = $row['created'];
                $changed = $row['changed'];
        ?>
        <tr>
            
            <td><?php echo $title; ?></td>
          
            <td><?php echo $user_access_role; ?></td>
            <td><?php echo $created; ?></td>
            <td><?php echo $changed; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=forms&contentType=viewForm">
                    <input type="hidden" name="TID" value="<?php echo $TID;?>">
                    <button type="submit" name="viewForm" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
        <tr>
        <td>Student Form</td>
        <td>" " </td>
        <td>" "</td>
        <td> " " </td>
        <td>
        <form method="post" action="./dashboard.php?content=workflows&formType=student">
                    <input type="hidden" name="TID" value="<?php echo $TID;?>">
                    <button type="submit" name="viewForm" class="w3-button w3-blue">View</button>
        </form>
        </td>
        </tr>
        <tr>
        <td>Chair Form</td>
        <td>" " </td>
        <td>" "</td>
        <td> " " </td>
        <td>
        <form method="post" action="./dashboard.php?content=workflows&formType=chair">
                    <input type="hidden" name="TID" value="<?php echo $TID;?>">
                    <button type="submit" name="viewForm" class="w3-button w3-blue">View</button>
        </form>
        </td>
        </tr>
    </table>
</div>
