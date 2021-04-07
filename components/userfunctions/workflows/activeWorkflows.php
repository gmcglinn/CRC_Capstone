<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php')
?>

<!-- Active Workflows -->
<div class="w3-container">
    <h5>Active Workflows</h5>
    <!-- Getting the current user's workflows from the database and printing them in a preview. -->
    <?php
        include_once('./backend/db_connector.php');

        //Find user type
        $user = $_SESSION['user_id'];
        $type = $_SESSION['user_type'];
        $where_sql = "";
        
        //Find corresponding column from wf user id table
        if($type == 2) {
            //statement that grabs corresponding active wf ids
            $where_sql = "m.CRC_ID";  
        }
        elseif($type == 3){
            $where_sql = "m.RCRG_ID";
        }
        elseif($type == 4){
            $where_sql = "m.DN_ID";
        }
        elseif($type == 5){
            $where_sql = "m.CHR_ID";
        }
        elseif($type == 6) {
            $where_sql = "m.SCRTY_ID";
        }
        elseif($type == 7) {
            $where_sql = "m.FCLTY_ID";
        }
        elseif($type == 8) {
            $where_sql = "m.STDNT_ID";
        }
        elseif($type == 9) {
            $where_sql = "m.EMP_ID";
        }

        $sql= "SELECT * FROM s21_active_workflow_ids as m
        INNER JOIN s21_active_workflow_info as n
	    ON n.WF_ID=m.WF_ID
        INNER JOIN s21_active_workflow_status as s
	    ON s.WF_ID=m.WF_ID
        INNER JOIN s21_course_workflow_steps as t
	    ON t.ATPID=n.ATPID
        WHERE ";
        
        $sql.= $where_sql."=$user";

        $query = mysqli_query($db_conn, $sql);
        $count = mysqli_num_rows($query);
        
        if($count > 0) {
            $rowNum = 1;
            while($result = mysqli_fetch_array($query)) {
                echo('<div class="w3-row w3-card-4 w3-margin">'
                    .'<div class="w3-quarter w3-border" style="height: 90px; padding-left: 10px;">'
                    . '<p>Title: '
                    . $result['title']
                    . '<br>Priority: '
                    . $result['priority'] 
                    . '<br>Status: In Progress'
                    //. $result['28']
                    . '</p></div>');

                $workflowID = $result['WF_ID'];

                echo('<div class="w3-half w3-padding w3-border" style="height: 90px;">');
                //The instructions field comes from the app_table and determines what order the
                //participants recieve the workflow in.
                $order = $result['instructions'];
                $order = explode("=>", $order);
                for($i = 0; $i < sizeof($order); ++$i) {
                    //When printing the workflow visualizer, the first thing to print is the skeleton.
                    if($i == 0) {
    ?>
                        <div class="circleList" id="circleList rowNum<?php echo $rowNum; ?>">
                            <div class="circle" id="participant<?php echo $i + 1; ?> rowNum<?php echo $rowNum; ?>"><strong><?php echo $i + 1; ?></strong></div>
                        </div>
                        <div class="labelList" id="labelList rowNum<?php echo $rowNum; ?>">
                            <div class="usertype"><?php echo $order[$i]; ?></div>
                        </div>
    <?php
                    }
                    //For the remaining participants in the visualizer we expand using DOM and JS.
                    else {
    ?>
                        <script>
                            document.getElementById('circleList rowNum<?php echo $rowNum; ?>').innerHTML += "<div class='line'></div><div class='circle' id='participant<?php echo $i + 1; ?> rowNum<?php echo $rowNum; ?>'><?php echo $i + 1; ?> </div>";
                            document.getElementById('labelList rowNum<?php echo $rowNum; ?>').innerHTML += "<div class='spacer'></div><div id='labelContainer' class='userType'><?php echo $order[$i]; ?></div>";
                        </script>
    <?php
                    }
                }
                echo('</div>');
                //$query = mysqli_query($db_conn, $sql);
                $instructions = explode("=>", $result['instructions']);
                $status = '';

                for ($s = 0; $s < sizeof($instructions); ++$s){
                    if ($instructions[$s] == 'Recreg') {
                        $status = $result['records_status'];
                    } elseif ($instructions[$s] == 'Student') {
                        $status = $result['student_status'];
                    } elseif ($instructions[$s] == 'Dean') {
                        $status = $result['dean_status'];
                    } elseif ($instructions[$s] == 'Chair') {
                        $status = $result['chair_status'];
                    } elseif ($instructions[$s] == 'Secretary') {
                        $status = $result['secretary_status'];
                    } elseif ($instructions[$s] == 'Faculty') {
                        $status = $result['faculty_status'];
                    } elseif ($instructions[$s] == 'Employer') {
                        $status = $result['supervisor_status'];
                    } elseif ($instructions[$s] == 'Admin') {
                        $status = $result['admin_status'];
                    }
                  //}
                    if ($status == '1') {
                        echo("<script>
                            document.getElementById('participant" . (string)($s+1) . ' rowNum' . $rowNum . "').style.backgroundColor = 'lawngreen';
                        </script>");
                    }
                    elseif ($status == '2') {
                        echo("<script>
                            document.getElementById('participant" . (string)($s+1) . ' rowNum' . $rowNum . "').style.backgroundColor = 'cyan';
                        </script>");
                    }
                    elseif ($status == '3') {
                        echo("<script>
                            document.getElementById('participant" . (string)($s+1) . ' rowNum' . $rowNum . "').style.backgroundColor = 'red';
                        </script>");
                    } elseif ($status == '4') {
                        echo("<script>
                            document.getElementById('participant" . (string)($s+1) . ' rowNum' . $rowNum . "').style.backgroundColor = 'gray';
                        </script>");
                    }
                }
               
                echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                . '<form action="./dashboard.php?content=workflows&contentType=active&viewForm=true" method="post" >'
                    . '<input type="hidden" name="stepLocation" value="'
                    
                    . '"></input>'
                    . '<button class="w3-button w3-teal" type="submit">View</button>'
                    . '</div></div>');
                    ++$rowNum;
            }
            //++$rowNum;
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin w3-padding">'
                . '<p>No Workflows Found!</p></div>');
        }
    ?>
</div>