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

	
    <div class="container">
      <div class="box form-box">
        <?php

        $selector = $_GET["selector"];
        $validator = $_GET["validator"];

        if (empty($selector) || empty($validator)) {
            echo "Could not validate your request.";
        }else {
            if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !==false) {
?>

<!-- creating a new password  takes us to resetpwd.inc.php for posting-->

<form action="resetpwd.inc.php" method="post">
<input type="hidden" name="selector" value="<?php echo $selector; ?>">
<input type="hidden" name="validator" value="<?php echo $validator; ?>">
<input type="password" name="password" placeholder="Enter new password...">
<input type="password" name="cpassword" placeholder="Repeat new password...">
<br>
<button type="submit" name="resetpwdsubmit">Reset Password</button>
</form>




<?php

            }

        }

        
        ?>





      </div>
    </div>
  </body>
</html>
