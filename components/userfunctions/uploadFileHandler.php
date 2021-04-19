<?php
if(!isset($_SESSION)) {
    session_start();
}
//User has not signed in.
if(!isset($_SESSION['user_type'])) {
    header('Location: ./index.php');
}

include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    if($_SESSION['user_type'] == 1){
		$thisUser = $_SESSION['user_id'];
    }


if (isset($_POST['submit'])){
    $file = $_FILES['file'];
    
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowedFileTypes = array('jpg','jpeg','png','pdf');
    
    if(in_array($fileActualExt, $allowedFileTypes)){
        if($fileError === 0){
            if($fileSize < 100000){//filesize limit
                $fileNameUnique = uniqid('', true).".".$fileActualExt;
                $fileDestination = '../../files/'.$fileNameUnique;
                if(move_uploaded_file($fileTmpName, $fileDestination)){
                    //MYSQL upload filename and attach username
                    $tempUser = $_SESSION['user_name'];
                    $insertMessage = "INSERT INTO f20_file_upload (file, owner, file_type) 
                            VALUES ('$fileDestination', '$tempUser', '$fileType')";
                    $insertMessageQuery = mysqli_query($db_conn, $insertMessage);

                }else{
                    echo "An unexpected error occured, please try again";
                }
            }else{
                echo "File exceeds upload size limit";
            }
        }
        else{
            echo "There was an unexpected error uploading your file";
        }
    }
    else{
        echo "File must be a JPEG, JPG, PNG, or PDF";
    }
}


?>