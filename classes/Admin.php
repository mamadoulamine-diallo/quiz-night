<?php
require_once __DIR__ . '/../config.php';

class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($username, $email, $password) {
        if ($this->getAdminByEmail($email)) {
            return "Cet email est déjà utilisé.";
        }

        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        
        $sql = "INSERT INTO user (username, email, password, role) VALUES (:username, :email, :password, 'admin')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function login($email, $password) {
        $admin = $this->getAdminByEmail($email);

        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            return true;
        }

        return false;
    }

    public function getAdminByEmail($email) {
      $query = "SELECT * FROM admins WHERE email = :email";
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
?>
