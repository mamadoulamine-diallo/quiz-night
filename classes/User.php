<?php
require_once __DIR__ . '/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Inscription d'un administrateur
    public function register($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user (Username, Email, Password, Role) VALUES (:username, :email, :password, 'admin')";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    // Connexion
    public function login($email, $password) {
        $query = "SELECT * FROM user WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['role'] = $user['Role'];
            return true;
        }
        return false;
    }

    // Vérifier si l'utilisateur est admin
    public function isAdmin($userId) {
        $query = "SELECT Role FROM user WHERE UserID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();
        return $user && $user['Role'] === 'admin';
    }
}
?>
