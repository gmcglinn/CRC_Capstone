<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');

    include_once('./components/userfunctions/courses/courses.php');
?>
<!-- Content Title -->


<!-- Form Search -->
<div id="formSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=courses&contentType=create'">Start New Course</button>
    <h5>Course Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Course Title</th>
            <th>Instructions</th>
            <th>Form Assignments</th>
            <th></th>
        </tr>

        <?php
            $sql = "SELECT * FROM s21_course_workflow_steps";
            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $TID = $row['ATPID'];
                $title = $row['workflow_title'];
                $instructions = $row['instructions'];
                $form_assignments = $row['form_assignments'];
                $form_assignments = str_replace(':', '=>', $form_assignments);
                $form_assignments = str_replace(',', ' | ', $form_assignments);
                $form_assignments = str_replace('"', '', $form_assignments);
        ?>
        <tr>
            
            <td class='w3-center'><?php echo $title; ?></td>
            <td class='w3-center'><?php echo $instructions; ?></td>
            <td class='w3-center'><?php echo $form_assignments; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=courses&contentType=editSingle">
                    <input type="hidden" name="TID" value="<?php echo $TID;?>">
                    <button type="submit" name="viewCourse" class="w3-button w3-blue">Edit</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
