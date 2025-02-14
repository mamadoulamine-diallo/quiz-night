<?php
require_once __DIR__ . '/Database.php';

class Player {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addPlayer($name, $email) {
        $query = "INSERT INTO player (Name, Email, CreatedAt) VALUES (:name, :email, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'name' => $name,
            'email' => $email
        ]);
    }

    public function getPlayerById($playerId) {
        $query = "SELECT * FROM player WHERE PlayerID = :playerId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['playerId' => $playerId]);
        return $stmt->fetch();
    }

    public function getPlayerByEmail($email) {
    $query = "SELECT * FROM player WHERE Email = :email";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}

}
?>
