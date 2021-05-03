<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    include_once('./components/userfunctions/forms/forms.php');
    //Loading the page title and action buttons.
    //include_once('./components/userfunctions/search/search.php');
?>


<!-- Form Search -->
<div id="formSearch" class="w3-card-4 w3-padding w3-margin">
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
          
            <td><?php if($user_access_role == 4) echo "Dean";
                            elseif($user_access_role == 8) echo "Student";
                            elseif($user_access_role == 6) echo "Secretary";
                            elseif($user_access_role == 5) echo "Chair"; ?></td>
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
        <td>Student Standard Form</td>
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
        <td>Chair Standard Form</td>
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
