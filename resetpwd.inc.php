<?php
include("php/connect.php");

if (isset($_POST["resetpwdsubmit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if (empty($password) || empty($cpassword)) {
        header("Location: createpwd.php?newpwd=empty");
        exit();
    } elseif ($password !== $cpassword) {
        header("Location: createpwd.php?newpwd=pwdnotsame");
        exit();
    }

    $currentDate = time();

    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $selector, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "You need to re-submit your reset request.";
        exit();
    }

    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

    if (!$tokenCheck) {
        echo "You need to re-submit your reset request.";
        exit();
    }

    $tokenEmail = $row['pwdResetEmail'];

    $sql = "SELECT * FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $tokenEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "There was an error.";
        exit();
    }

    $sql = "UPDATE users SET password = ? WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $newPwdHash, $tokenEmail);
    $stmt->execute();

    $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $tokenEmail);
    $stmt->execute();

    header("Location: login.php?newpwd=passwordupdated");
    exit();
} else {
    header("Location: index.html");
    exit();
}