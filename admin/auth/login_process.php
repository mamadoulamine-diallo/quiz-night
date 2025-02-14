<?php
session_start();
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Admin.php';

$admin = new Admin($mysqlClient); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email) $errors[] = "Email invalide.";
    if (empty($password)) $errors[] = "Le mot de passe est obligatoire.";

    if (empty($errors)) {
        
        if ($admin->login($email, $password)) {
            header("Location: /quiz-night/public/index.php"); 
            exit();
        } else {
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }

    $_SESSION['login_errors'] = $errors;
    $_SESSION['old_login'] = $_POST;
    header("Location: login.php"); 
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Inscription Réussie !</h1>
    
</body>
</html>



