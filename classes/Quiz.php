<?php
require_once __DIR__ . '/Database.php';

class Quiz {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Ajouter un quiz
    public function addQuiz($userId, $title, $description) {
        $query = "INSERT INTO quiz (UserID, Title, Description, CreatedAt) VALUES (:userId, :title, :description, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'userId' => $userId,
            'title' => $title,
            'description' => $description
        ]);
    }

    // Modifier un quiz
    public function updateQuiz($quizId, $title, $description) {
        $query = "UPDATE quiz SET Title = :title, Description = :description WHERE QuizID = :quizId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'quizId' => $quizId
        ]);
    }

    // Supprimer un quiz
    public function deleteQuiz($quizId) {
        $query = "DELETE FROM quiz WHERE QuizID = :quizId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['quizId' => $quizId]);
    }

    // Récupérer tous les quiz
    public function getAllQuizzes() {
        $query = "SELECT q.*, u.Username FROM quiz q 
                  JOIN user u ON q.UserID = u.UserID 
                  ORDER BY q.CreatedAt DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    // Récupérer un quiz par son ID
    public function getQuizById($quizId) {
        $query = "SELECT q.*, u.Username FROM quiz q 
                  JOIN user u ON q.UserID = u.UserID 
                  WHERE q.QuizID = :quizId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['quizId' => $quizId]);
        return $stmt->fetch();
    }
}
?>
