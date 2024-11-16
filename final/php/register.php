<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $role = "owner";

    if ($password != $repeat_password) {
        header('Location: ../register?failed=password_mismatch');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password, role, fullname) VALUES (?, ?, ?, ?)");
    
    try {
        $stmt->execute([$email, $hashed_password, $role, $fullname]);
        header('Location: ../login?success');
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Code for duplicate entry
            header('Location: ../register?failed=duplicate_entry');
        } else {
            header('Location: ../register?failed=error');
        }
        exit();
    }
}
?>
