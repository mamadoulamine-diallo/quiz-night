<?php
require_once __DIR__ . '/../classes/Database.php';


class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function register($username, $email, $password) {
        if ($this->getUserByEmail($email)) {
            return "Cet email est déjà utilisé.";
        }
    
        if (strlen($password) < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères.";
        }
    
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = "INSERT INTO user (Username, Email, Password, Role, CreatedAt) 
                VALUES (:username, :email, :password, 'user', NOW())";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
    
        return $stmt->execute();
    }
    

    
    public function login($email, $password) {
        $query = "SELECT * FROM user WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['Password'])) {
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role']; 
            return true;
        }
        
        return false;
    }
    

   
    public function isAdmin($userId) {
        $query = "SELECT Role FROM user WHERE UserID = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && $user['Role'] === 'admin';
    }

   
    private function getUserByEmail($email) {
        $query = "SELECT * FROM user WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
