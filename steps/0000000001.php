<!-- Handler for starting the old internship application. -->


<!-- This form is specficically for the internship application and may be adapted for
    custom workflows in the future -->

    
<label class="w3-input" for="studentEmail" class="w3-input">Student's Email</label>
<input type="email" name="studentEmail" class="w3-input">
<!-- Function to show the courses available in a selected department. -->
<script>
    function showCourse(str) {
        if (str == "") {
            document.getElementById("course").innerHTML = "";
            return;
        } 
        else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("course").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","./backend/getCourse.php?q="+str,true);
            xmlhttp.send();
        }
    }
</script>

<<<<<<< HEAD
<!-- This form is specficically for the internship application and may be adapted for
    custom workflows in the future -->
<div class="w3-card-4 w3-margin w3-padding" style="background-color: whitesmoke;">
    <form method="post">
        <h5>Application Start Form:</h5>
        <?php include_once('stepsMetaData.php')?>
        <label class="w3-input" for="studentEmail" class="w3-input">Student's Email</label>
        <input type="email" name="studentEmail" class="w3-input">
        <!-- Function to show the courses available in a selected department. -->
        <script>
            function showCourse(str) {
                if (str == "") {
                    document.getElementById("course").innerHTML = "";
                    return;
                } 
                else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("course").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","./backend/getCourse.php?q="+str,true);
                    xmlhttp.send();
                }
=======
<!-- Select field for the department -->
<label class="w3-input" for="department">Department</label>
<select class="w3-input" name="dept_code" id="dept_code" onchange="showCourse(this.value)">
    <option value="">Select a department:</option>
    <?php 
        $sql = "SELECT * FROM `f20_academic_dept_info`";
        $query = mysqli_query($db_conn, $sql);
        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                echo("<option value='" . $row['dept_code'] . "'>" . $row['dept_name'] . "</option>");
>>>>>>> b04d6b42fa2031ce0e6b3749528b649fd566ff26
            }
        }
    ?>
</select>

<label class="w3-input" for="course">Course</label>
<select class="w3-input" name="course_number" id="course">
    <option value="">Select a course:</option>
</select>

<label class="w3-input" for="semester">Semester</label>
<select class= "w3-input" name="semester" id="semester">
    <option value="">Select a semester:</option>
    <option value="Fall">Fall</option>
    <option value="Spring">Spring</option>
    <option value="Summer">Summer</option>
    <option value="Winter">Winter</option>
</select>

<label class="w3-input" for="semester">Year</label>
<input type="text" name="year" class="w3-input">

<label class="w3-input" for="gradeMethod">Grade Method</label>
<select name="gradeMethod" class="w3-input">
    <option value="">Select a grade method:</option>
    <option value="Letter Grades">Letter Grades</option>
    <option value="Pass/Fail">Pass/Fail</option>
</select>
 
