<html>
   



   <body>
     
      <?php


      //accept these through session/post variables? SQL active user var?
         $to = ""; //Intake value
         $subject = "This is subject"; //Based on location of usage
         
         $message = "<b>This is HTML message.</b>"; //Body of text, fill in from form?
         /*
        Form Accepted
        Message Received
        Form Completed
        Account Created
        User Prompted for Response
         */


         $message .= "<h1>This is headline.</h1>"; //unsure what this is for yet
         


         $header = "From:CRC@cs.newpaltz.edu \r\n";


         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header); //mail.php may be a better alternative to mime
         







        //check if emailer sent
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }


         //return to previous session if POST used, otherwise just implement me when needed
      ?>
     
   </body>
</html>


