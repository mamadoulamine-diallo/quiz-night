<?php 
session_start(); 

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/Admin.php';

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
        try {
            $checkQuery = "SELECT COUNT(*) FROM user WHERE email = :email";
            $checkStmt = $mysqlClient->prepare($checkQuery);
            $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $checkStmt->execute();
            $emailExists = $checkStmt->fetchColumn();

            if ($emailExists) {
                $errors[] = "Cet email est déjà utilisé.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

              
                $sqlQuery = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
                $insertUsers = $mysqlClient->prepare($sqlQuery);
                $insertUsers->bindParam(':username', $username, PDO::PARAM_STR);
                $insertUsers->bindParam(':email', $email, PDO::PARAM_STR);
                $insertUsers->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $insertUsers->execute();

                
                header("Location: login.php");
                exit();
            }
            
        } catch (PDOException $e) {
            $errors[] = "Une erreur technique est survenue.";
        }
    }

  
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_data'] = $_POST;
    header("Location: register.php"); 
    exit();
}
?>
