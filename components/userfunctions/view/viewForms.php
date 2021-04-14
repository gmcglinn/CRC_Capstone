<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/forms/workflows.php')
?>

<!-- View Forms -->
<div class="w3-container">
    <h5>Form Types</h5>
    <!-- Getting the tables from the database that are labeled as a Form Type and printing them in a preview. -->
    <?php
        include_once('./backend/db_connector.php');
        //$user = $_SESSION['user_id'];

        $sql = "SELECT table_name FROM p_s21_2_db WHERE COLUMN_NAME LIKE '%Form';";

        $query = mysqli_query($db_conn, $sql);
        $count = mysqli_num_rows($query);
        
        if($count > 0) {
            while($result = mysqli_fetch_array($query)) {
                $stepLocation = $result['location'];

                echo($row);
            
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin w3-padding">'
                . '<p>No Forms Found!</p></div>');
        }
    ?>
</div>