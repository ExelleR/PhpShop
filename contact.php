<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$message = trim($_POST["message"]);
$email_body = "";
$email_body = $email_body . "Name: " . $name . "<br>";
$email_body = $email_body . "Email: " . $email . "<br>";
$email_body = $email_body . "Message: " . $message ;

    if($name == "" OR $email == "" OR $message == ""){
        $error_message =  "You must specify a value for the name and email address and message.";
    }

    if(!isset($error_message)){
        foreach($_POST as $value){
            if(stripos($value,'Content-Type:') !== FALSE){
                $error_message =  "There was a problem with the information you entered.";
            }

        }
    }
        if(!isset($error_message) && $_POST["address"] !=""){
        $error_message =  "Your form submission had adn error.";
    }
    require ("inc/phpmailer/PHPMailerAutoload.php");

    $mail = new PHPMailer;
    if(!isset($error_message) && !$mail ->ValidateAddress($email)){

        $error_message =  "You must specify valid email address.";
    }


   if (!isset($error_message)){
        // Set PHPMailer to use the sendmail transport
            $email->SetFrom($email,$name);
            $address = "orders@shirts4mike.com";
            $mail->isSendmail();
        //Set who the message is to be sent from
            $mail->setFrom('from@example.com', 'First Last');
        //Set who the message is to be sent to
            $mail->addAddress($address, 'Shirts 4 Mike');

        //Set the subject line
            $mail->Subject = "Shirts 4 Mike Contact Form Submission | " . $name;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($email_body);



        //send the message, check for errors
       if ($mail->send()) {
           header("Location: contact.php?status=thanks");
           exit;
       }
        else{
            $error_message =  "Mailer Error: " . $mail->ErrorInfo;
            exit;
        }
   }


}
?>
<?php
$pageTitle = "Contact Mike" ;
$section ="contact";
include('inc/header.php');
?>


   <div class="section page">

       <div class="wrapper">

       <h1>Contacts</h1>
           <?php if(isset($_GET["status"]) and $_GET["status"] == "thanks"){ ?>
               <p>Thanks for the email! I&rsquo;I'l be in touch shortly.</p>
            <?php }else{ ?>
               <?php

               if(!isset($error_message)){
                 echo '<p>I&rsquo;d love to hear from you! Complete the form to send me an email.</p>';

               }
               else{
                   echo '<p class="message">' . $error_message . '</p>';
               }

               ?>
          <form method="post" action="contact.php">
           <table>
               <tr>
                   <th>
                       <label for="name">Name</label>
                   </th>
                   <td>
                        <input type="text" name="name" id="name">
                   </td>
               </tr>
               <tr>
                   <th>
                       <label for="email">Email</label>
                   </th>
                   <td>
                       <input type="text" name="email" id="email">
                   </td>
               </tr>
               <tr>
                   <th>
                       <label for="message">Message</label>
                   </th>
                   <td>
                       <textarea name="message" id="message"></textarea>
                   </td>
               </tr>
               <tr style="display: none">
                   <th>
                       <label for="address">Message</label>
                   </th>
                   <td>
                       <input type="text"  name="address" id="address">
                       <p>Humans (and frogs): please leave this field blank.</p>
                   </td>
               </tr>
           </table>
            <input type="submit" value="Send">



          </form>

<?php }?>

       </div>
   </div>

<?php include('inc/footer.php'); ?>