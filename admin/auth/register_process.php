<?php
session_start();
require_once __DIR__ . '/../../classes/Database.php';

require_once __DIR__ . '/../../classes/Admin.php';

$admin = new Admin($mysqlClient); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $username = trim($_POST['username']); 
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (empty($username)) $errors[] = "Le nom d'utilisateur est obligatoire.";
    if (!$email) $errors[] = "Email invalide.";
    if (strlen($password) < 8) $errors[] = "Le mot de passe doit faire 8 caractères minimum.";

    if (empty($errors)) {
        $registerResult = $admin->register($username, $email, $password);

        if ($registerResult === true) {
            header("Location: login.php");
            exit();
        } else {
            $errors[] = $registerResult; 
        }
    }

    
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_data'] = $_POST;
    header("Location: register.php"); 
    exit();
}

?>
