<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
include("php/connect.php");

$showAlert = false;
$showError = false;
$exists = false;

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dolend = mysqli_real_escape_string($conn, $_POST['dolend']);
    $postalcode = mysqli_real_escape_string($conn, $_POST['postalcode']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $verify_query = $conn->prepare("SELECT Email, Username FROM users WHERE Email=? OR Username=?");
    $verify_query->bind_param("ss", $email, $username);
    $verify_query->execute();
    $verify_result = $verify_query->get_result();

    if($verify_result->num_rows == 0) {
        if($password == $cpassword) {
            $mail = new PHPMailer(true);
            try {
                // PHPMailer configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@laundry4food.ca';
                $mail->Password = 'Password'; // Consider using environment variables for sensitive data
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                $mail->setFrom('info@laundry4food.ca', 'laundry4food.ca');
                $mail->addAddress($email, $username);
                $mail->isHTML(true);

                $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                
                $mail->Subject = 'Email verification';
                $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
                
                $mail->send();

                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

                $insert_query = $conn->prepare("INSERT INTO users (Username, Email, Password, Postalcode, verification_code, email_verified_at, dolend) VALUES (?, ?, ?, ?, ?, NULL, ?)");
                $insert_query->bind_param("ssssss", $username, $email, $encrypted_password, $postalcode, $verification_code, $dolend);
                $insert_query->execute();

                header("Location: emailvar.php?email=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $showError = "Passwords do not match";
            echo "<div class='message'><p>Your passwords do not match.</p></div><br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
        }
    } else {
        $exists = "Username or Email not available";
        echo "<div class='message'><p>This Email or Username is already in use, please try another one!</p></div><br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Laundry4food</a></p>
        </div>
        <div class="right-links">
            <a href="index.html"><button class="btn">Home Page</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php if (!isset($_POST['submit'])) { ?>
                <header>Sign Up To Lend Laundry Room</header>
                <form action="#" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                        <input type='hidden' name='dolend' value='lend'>
                    </div>
                    <div class="field input">
                        <label for="postalcode">Postal Code/Zip Code<i><b><br>ex: A1A 1A1 or 12345</b></i></label>
                        <input type="text" name="postalcode" id="postalcode" placeholder="A1A 1A1" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="field input">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" placeholder="Confirm Password" required>
                    </div>
                    <div class="field">
                        <input type="checkbox" id="checkbox" name="checkbox" value="terms" required>
                        <label for="terms"><a href="createownterms" target="_blank">Terms and Conditions</a></label>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register">
                    </div>
                    <div class="links">
                        Already a member? <a href="login.php">Sign in</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>