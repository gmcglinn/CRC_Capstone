<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php');
?>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=app'">Start Workflow</button>
    <h5>Workflow Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Created</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>

        <?php
            $sql = "SELECT * FROM s21_active_workflow_ids as m
                    INNER JOIN s21_active_workflow_info as n
                    ON n.WF_ID=m.WF_ID
                    INNER JOIN s21_active_workflow_status as s
                    ON s.WF_ID=m.WF_ID
                    INNER JOIN s21_course_workflow_steps as t
                    ON t.ATPID=n.ATPID";

            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $workflowID = $row['ATPID'];
                $title = $row['title'];
                $priority = $row['priority'];
                $status = $row['status'];
                $created = $row['created'];
                $deadline = $row['deadline'];
        ?>
        <tr>
            <td><?php echo $title; ?></td>
            <td><?php echo $priority; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $created; ?></td>
            <td><?php echo $deadline; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input type="hidden" name="workflowID" value="<?php echo $workflowID;?>">
                    <button type="submit" name="viewWorkflow" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>