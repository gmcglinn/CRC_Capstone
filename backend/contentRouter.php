<!-- File for redirection to the appropriate content based on get requests. -->
<?php
    //If the content requested is the home/dashboard.
    if($_GET['content'] == "home") {
        include_once('./components/dashboard/header.php');
        include_once('./components/dashboard/actionpanel.php');

        //The following are hidden for our final presentation because they were not yet implemented.

        //include_once('./components/dashboard/feed.php');
        //include_once('./components/dashboard/recentworkflows.php');
        //include_once('./components/dashboard/recentmessages.php');
    }
    //If the content requested is the search page.
    else if($_GET['content'] == "search") {
        //If the user requested the a specific section of the search page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./components/userfunctions/search/searchUser.php");
            }
            else if($_GET['contentType'] == "workflows") {
                include_once("./components/userfunctions/search/searchWorkflow.php");
            }
            else if($_GET['contentType'] == "workflowtemplate") {
                include_once("./components/userfunctions/search/searchWorkflowTemplates.php");
            }
            else if($_GET['contentType'] == "department") {
                include_once("./components/userfunctions/search/searchDepartment.php");
            }
            else if($_GET['contentType'] == "course") {
                include_once("./components/userfunctions/search/searchCourse.php");
            }
            else if($_GET['contentType'] == "steps") {
                include_once("./components/userfunctions/search/searchSteps.php");
            }
            else if($_GET['contentType'] == "steptemplates") {
                include_once("./components/userfunctions/search/searchStepTemplates.php");
            }
        }
        else {
            include_once("./components/userfunctions/search/search.php");
        }
    }
    //If the content requested is the create page.
    else if($_GET['content'] == "create") {
        //If the user requested the a specific section of the create page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./components/userfunctions/create/createUser.php");
            }
            else if($_GET['contentType'] == "workflow") {
                include_once("./components/userfunctions/create/createWorkflow.php");
            }
            else if($_GET['contentType'] == "department") {
                include_once("./components/userfunctions/create/createDepartment.php");
            }
            else if($_GET['contentType'] == "course") {
                include_once("./components/userfunctions/create/createCourse.php");
            }
			else if($_GET['contentType'] == "message") {
                include_once("./components/userfunctions/create/createMessage.php");
            }
			else if($_GET['contentType'] == "app") {
                include_once("./components/userfunctions/create/createApp.php");
            }
        }
        else {
            include_once("./components/userfunctions/create/create.php");
        }
    }
    else if($_GET['content'] == "messages") {
        include_once("./components/userfunctions/messages.php");
    }
    else if($_GET['content'] == "files") {
        include_once("./components/userfunctions/files.php");
    }
    //If the content requested is one of the many misc sidebar items.
    else if($_GET['content'] == "miscFunc") {
        //If the user requested the a specific section of the create page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "admin") {
                include_once("./components/userfunctions/miscFunc/adminTools.php");
            }
            else if($_GET['contentType'] == "users") {
                 include_once("./components/userfunctions/miscFunc/users.php");
            }            
        }
        else {//return home if requested incorrectly
            include_once('./components/dashboard/header.php');
            include_once('./components/dashboard/actionpanel.php');
        }
    }

    //If the content requested is the workflows page.
    else if($_GET['content'] == "workflows") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "active") {
                include_once("./components/userfunctions/workflows/activeWorkflows.php");

            if (isset($_GET['viewForm'])) {
                
                if($_GET['viewForm'] == 'true') {
                    include_once("./form/chooseForm.php");
                    }
                } 
            }
            else if($_GET['contentType'] == "new") {
                include_once("./components/userfunctions/workflows/newWorkflows.php");
            }
            else if($_GET['contentType'] == "start") {
                include_once("./components/userfunctions/workflows/startWorkflow.php");
            }
            else if($_GET['contentType'] == "completed") {
                include_once("./components/userfunctions/workflows/completedWorkflows.php");
            }
            else if($_GET['contentType'] == "viewWorkflow") {
                include_once("./components/userfunctions/workflows/viewWorkflow.php");
            } 

        }
        else {
            include_once("./components/userfunctions/workflows/workflows.php");

            if ( isset($_GET['formType'])) {
            
                if ($_GET['formType'] == 'secretary') {
                    include_once("./form/secretaryForm.php");
                }
                else if ($_GET['formType'] == 'student') {
                    include_once("./form/studentForm.php");
                }
                else if ($_GET['formType'] == 'student') {
                    include_once("./form/studentForm.php");
                }
                else if ($_GET['formType'] == 'faculty') {
                    include_once("./form/instructorForm.php");
                } 
                else if ($_GET['formType'] == 'dean' || $_GET['formType'] == 'chair') {
                    include_once("./form/deanForm.php");
                } 
                else if ($_GET['formType'] == 'chair' || $_GET['formType'] == 'chair') {
                    include_once("./form/chairForm.php");
                } 
                else if ($_GET['formType'] == 'supervisor' || $_GET['formType'] == 'chair') {
                    include_once("./form/supervisorForm.php");
                }           
            }
        }
    }

    //TEMP BANDAID SOLUTION TO FORMS
    else if($_GET['content'] == "forms") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "create") {
                include_once("./components/userfunctions/forms/createNewForm.php");
            }
            else if($_GET['contentType'] == "edit") {
                include_once("./components/userfunctions/forms/editForm.php");
            }
            else if($_GET['contentType'] == "view") {
                include_once("./components/userfunctions/forms/viewAllForms.php");
            }
            else if($_GET['contentType'] == "viewForm") {
                include_once("./components/userfunctions/forms/viewForm.php");
            }
            else if($_GET['contentType'] == "removeForm") {
                include_once("./components/userfunctions/forms/removeForm.php");
            }
            else if($_GET['contentType'] == "delete") {
                include_once("./components/userfunctions/forms/deleteForms.php");
            }
            else if($_GET['contentType'] == "editSingle") {
                include_once("./components/userfunctions/forms/editSingle.php");
            }
        }
        else {
            include_once("./components/userfunctions/forms/forms.php");
        }
    }

    //TEMP BANDAID SOLUTION TO COURSES
    else if($_GET['content'] == "courses") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "create") {
                include_once("./components/userfunctions/courses/createCourse.php");
            }
            else if($_GET['contentType'] == "edit") {
                include_once("./components/userfunctions/courses/editCourse.php");
            }
            else if($_GET['contentType'] == "view") {
                include_once("./components/userfunctions/courses/viewAllCourses.php");
            }
            else if($_GET['contentType'] == "delete") {
                include_once("./components/userfunctions/courses/deleteCourse.php");
            }
            else if($_GET['contentType'] == "editSingle") {
                include_once("./components/userfunctions/courses/editSingle.php");
            }
        }
        else {
            include_once("./components/userfunctions/courses/courses.php");
        }
    }

    else if($_GET['content'] == "adminTools") {
        //If the user requested the a specific section of the search page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./components/userfunctions/create/createUser.php");
            }
            else if($_GET['contentType'] == "dept") {
                include_once("./components/userfunctions/create/createDepartment.php");
            }
        }
        else {
            include_once("./components/userfunctions/miscFunc/adminTools.php");
        }
    }

    //router for user actions
    else if($_GET['content'] == "users") {
        
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "create") {
                include_once("./components/userfunctions/create/createUser.php");
            }
            else if($_GET['contentType'] == "view") {
                include_once("./components/userfunctions/search/searchUser.php");
            }
        }
        else {
            include_once("./components/userfunctions/miscFunc/users.php");
        }
    }



    //If the content requested is the view page.
    else if($_GET['content'] == "view") {
        //If the user requested the a specific section of the view page.
        if($_GET['contentType'] == "user") {
            include_once("./components/userfunctions/view/viewUser.php");
        }
        else if($_GET['contentType'] == "workflow") {
            include_once("./components/userfunctions/view/viewWorkflow.php");
        }
        else if($_GET['contentType'] == "workflowTemplate") {
            include_once("./components/userfunctions/view/viewWorkflowTemplate.php");
        }
        else if($_GET['contentType'] == "department") {
            include_once("./components/userfunctions/view/viewDepartment.php");
        }
        else if($_GET['contentType'] == "course") {
            include_once("./components/userfunctions/view/viewCourse.php");
        }
		else if($_GET['contentType'] == "message") {
            include_once("./components/userfunctions/view/viewMessage.php");
        }
		else if($_GET['contentType'] == "file") {
            include_once("./components/userfunctions/view/viewFile.php");
        }

        else if($_GET['contentType'] == "step") {
            include_once("./components/userfunctions/view/viewStep.php");
        }
        else if($_GET['contentType'] == "stepTemplate") {
            include_once("./components/userfunctions/view/viewStepTemplate.php");
        }
    }
    else if($_GET['content'] == "viewWorkflow") {
        include_once("./components/userfunctions/viewWorkflow.php");
    }
    else if($_GET['content'] == "startInternApp") {
        include_once("./components/userfunctions/workflows/internAppStart.php");
    }
    else if($_GET['content'] == "settings") {
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == 'myAccount') {
                include_once("./components/userfunctions/settings/viewProfile.php");
            }
            if($_GET['contentType'] == 'changeEmail') {
                include_once("./components/userfunctions/settings/changeEmail.php");
            }
            if($_GET['contentType'] == 'changePassword') {
                include_once("./components/userfunctions/settings/changePassword.php");
            }
        }
        else {
            include_once("./components/userfunctions/settings/settings.php");
        }
    }
     else if($_GET['content'] == "test") {
        include_once("./form/test.php");
     }
      else if($_GET['content'] == "test1") {
        include_once("./form/test1.php");
     }
?>