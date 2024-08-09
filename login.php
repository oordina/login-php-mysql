<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css">
    <title>Log In</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aldrich&amp;display=swap">
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
            include("php/connect.php");

            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = $_POST['password'];

                $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if($user && password_verify($password, $user['password'])) {
                    if($user['email_verified_at'] == null) {
                        echo "<div class='message'><p>Please verify your email <a href='emailvar.php?email=" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "'>from here</a></p></div>";
                    } else {
                        $_SESSION['valid'] = $user['Email'];
                        $_SESSION['username'] = $user['Username'];
                        $_SESSION['postalcode'] = $user['Postalcode'];
                        $_SESSION['id'] = $user['Id'];
                        header("Location: home.php");
                        exit();
                    }
                } else {
                    echo "<div class='message'><p>Wrong Email or Password</p></div><br>";
                    echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
                }
                $stmt->close();
            } else {
            ?>
            <header>Login to Lend Laundry Room</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required />
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required />
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" />
                </div>
                <div class="links">
                    Don't have account? <br>
                    <a href="register.php">Sign up as a lender</a>
                    OR <a href="registerdo.php">Sign up to do Laundry</a>
                </div>
            </form>
            <?php
            if (isset($_GET["newpwd"]) && $_GET["newpwd"] == "passwordupdated") {
                echo '<p><br><br> Your Password has been reset. </p>';
            }
            ?>
            <a href="resetpwd.php">Forgot my password</a>
        </div>
        <?php } ?>
    </div>
</body>
</html>