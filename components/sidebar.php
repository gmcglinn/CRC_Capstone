<?php include_once('./backend/config.php'); ?>


<nav class="w3-sidebar w3-collapse w3-white" style="z-index:3;width:300px;" id="mySidebar"><br>
  <!-- Sidebar Header -->
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="./images/w3avatar.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <br><strong><?php echo $_SESSION['user_name']; ?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="./dashboard.php?content=settings" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>

  <!-- Sidebar Content
  Dr Pham wants all to have: 
  Home, Search, Messages, Files, Settings, Signout
  Admin = All tabs
  Secretary = Workflows (Create/View)
  All other users = View (My) Workflow
  -->
  
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="./dashboard.php?content=home" id="homeBar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i>  Home</a>
    <!-- <a href='./dashboard.php?content=search' id='searchBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-search fa-fw'></i>  Search</a> -->
    <?php

      //Displaying the create option for all users except employer
      // if(!($_SESSION['user_type'] == $GLOBALS['employer_type'])) {
      //     echo("<a href='./dashboard.php?content=create' id='createBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-plus fa-fw'></i>  Create</a>");
      // }

      if(($_SESSION['user_type'] == $GLOBALS['secretary_type'] || $_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=search' id='searchBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-search fa-fw'></i>  Search</a>");
      }

      //Displaying admin only tools
      if($_SESSION['user_type'] == $GLOBALS['admin_type']) {
        echo("<a href='./dashboard.php?content=adminTools' id='adminToolsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-diamond fa-fw'></i>  Admin Tools</a>");
      }

      if(($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=users' id='usersBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-user fa-fw'></i>  Manage Users</a>");
      }

      //Displaying the workflows option for users involved in only their own Workflows.
      if(!($_SESSION['user_type'] == $GLOBALS['secretary_type'] || $_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=workflows' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  View My Workflow</a>");
      }
      //Create Workflow
      if(($_SESSION['user_type'] == $GLOBALS['secretary_type'])) {
        echo("<a href='./dashboard.php?content=workflows' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  Create Workflow</a>");
      }
      //Displaying the workflows options for users involved in administrating workflows.
      if(($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=courses' id='courseBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-wrench fa-fw'></i>  Courses (Workflow Templates)</a>");
      }
      //Displaying the workflow option for user involved in administrating workflows.
      if(($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=workflows' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-wrench fa-fw'></i>  Workflows</a>");
      }

      //April 14 showing creation of new types of customization Forms, Courses
      if(($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=forms' id='formsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-wrench fa-fw'></i>  Forms</a>");
      }



    ?>
      
    <a href='./dashboard.php?content=messages' id='messagesBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-comment fa-fw'></i>  Messages</a>
    <a href='./dashboard.php?content=files' id='filesBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-files-o fa-fw'></i>  Files</a>
    <a href='./dashboard.php?content=settings' id='settingsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-cog fa-fw'></i>  Settings</a>
    <a href='./backend/logout.php' class='w3-bar-item w3-button w3-padding'><i class='fa fa-sign-out fa-fw'></i>  Sign-Out</a><br><br>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
    //Highlighting the active sidebar option.
    var tempURL = window.location.href;
    tempURL = tempURL.split("=");

    if(tempURL[1] == "home")
    {
        document.getElementById('homeBar').className += " w3-blue";
    }
    else if(tempURL[1] == "files")
    {
        document.getElementById('filesBar').className += " w3-blue";
    }
    else if(tempURL[1] == "adminTools" || tempURL[1] == "adminTools&contentType")
    {
        document.getElementById('adminToolsBar').className += " w3-blue";
    }
    else if(tempURL[1] == "users" || tempURL[1] == "users&contentType")
    {
        document.getElementById('usersBar').className += " w3-blue";
        
    }
    else if(tempURL[1] == "courses" || tempURL[1] == "courses&contentType")
    {
        document.getElementById('courseBar').className += " w3-blue";
    }
    else if(tempURL[1] == "forms" || tempURL[1] == "forms&contentType")
    {
        document.getElementById('formsBar').className += " w3-blue";
    }
    else if(tempURL[1] == "workflows" || tempURL[1] == "workflows&contentType")
    {
        document.getElementById('workflowsBar').className += " w3-blue";
    }
    else if(tempURL[1] == "history")
    {
        document.getElementById('historyBar').className += " w3-blue";
    }
    else if(tempURL[1] == "settings" || tempURL[1] == "settings&contentType")
    {
        document.getElementById('settingsBar').className += " w3-blue";
    }
    else if(tempURL[1] == "search" || tempURL[1] == "view&contentType" || tempURL[1] == "search&contentType")
    {
        document.getElementById('searchBar').className += " w3-blue";
    }
    else if(tempURL[1] == "create" || tempURL[1] == "create&contentType")
    {
        document.getElementById('createBar').className += " w3-blue";
    }
    else if(tempURL[1] == "messages")
    {
        document.getElementById('messagesBar').className += " w3-blue";
    }
    else if(tempURL[1] == "search")
    {
        document.getElementById('usersBar').className += " w3-blue";
    }

    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
      if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
          overlayBg.style.display = "none";
      } else {
          mySidebar.style.display = 'block';
          overlayBg.style.display = "block";
      }
    }

    // Close the sidebar with the close button
    function w3_close() {
      mySidebar.style.display = "none";
      overlayBg.style.display = "none";
    }
</script>