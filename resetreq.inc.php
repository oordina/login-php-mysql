<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

/* remember to connect */
    include ("php/connect.php");



/* the post for the function in resetpwd.php */

if (isset($_POST["resetreqsubmit"])) {

    /* we add a hash and token so it will be special, 32 is hard to break */

    $selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$hashedToken = password_hash($token, PASSWORD_DEFAULT);

$url = "laundry4food.ca/createpwd.php?selector=" . $selector . "&validator=" . bin2hex($token);

$expires = date("U") + 1800;




$userEmail = mysqli_real_escape_string($conn, $_POST["email"]);

/* again refrain from open source due to sql injection, try to always prepare but
in this case for simplicity here is to see where the conn is */

$sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql))
{
echo "There was an error";

} else{
mysqli_stmt_bind_param($stmt, "s", $userEmail);
mysqli_stmt_execute($stmt);

}
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

        try {
            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
    
            //Send using SMTP
            $mail->isSMTP();
    
            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';
    
            //Enable SMTP authentication
            $mail->SMTPAuth = true;
    
            //SMTP username
            $mail->Username = 'info@laundry4food.ca';

            //SMTP password
            $mail->Password = 'Password';
    
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;
                
            //Recipients
            $mail->setFrom('info@laundry4food.ca', 'laundry4food.ca');

             //Add a recipient
            $mail->addAddress($userEmail);
    
            //Set email format to HTML
            $mail->isHTML(true);

            $mail->Subject = 'Reset your password';
            $mail->Body    = '<p>We recieved a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email. <br>
            Here is your password reset link: <b style="font-size: 30px;"><a href="' . $url . ' ">'.$url.'</a></b></p>';
    
            $mail->send();
            // echo 'Message has been sent';


        /* again refrain from open source due to sql injection, try to always prepare statement but
in this case for simplicity here is to see where the conn is */

$sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES ('$userEmail', '$selector', '$hashedToken', '$expires');";
$stmt = mysqli_stmt_init($conn);

mysqli_query($conn, $sql);

} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

if (!mysqli_stmt_prepare($stmt, $sql))
{
echo "There was an error";

} 

mysqli_stmt_close($stmt);
mysqli_close($conn);



header("Location: resetpwd.php?reset=success");


} else {
    echo "E-mail does not match our records";
}



