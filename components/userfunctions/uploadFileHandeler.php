<?php
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
            if($fileSize < 100000){
                $fileNameUnique = uniqid('', true).".".$fileActualExt;
                $fileDestination = '../../userfiles/'.$fileNameUnique;
                move_uploaded_file($fileTmpName, $fileDestination);
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