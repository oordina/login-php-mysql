<!-- html start -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css">
    <title>Reset password</title>
    <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Aldrich&amp;display=swap">
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

	
    <div class="container"  align="center">
      <div class="box form-box"  align="center">
        <h1   align="center">Reset your password</h1>
        <p   align="center">
            An e-mail will be sent to you with instructions in order to reset your password.
        </p>

        <!-- using the resetreq.inc.php where the function will be stored -->

<form action="resetreq.inc.php" method="post">
<input type="text" name="email" placeholder="Enter your email address...">
<button type="submit" name="resetreqsubmit">Recieve new password by e-mail</button>
</form>
<?php
/* send email to reset passowrd and let them know */

if (isset($_GET["reset"])) {
    if ($_GET["reset"] == "success") {
        echo '<p class="signupsuccess">Check your e-mail!</p>';
    }
}

?>
      </div>
    </div>
  </body>
</html>
