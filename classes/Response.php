<?php
require_once __DIR__ . '/Database.php';

class Answer {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Ajouter une réponse à une question
    public function addAnswer($questionId, $responseText, $isCorrect) {
        $query = "INSERT INTO response (QuestionID, ResponseText, IsCorrect, CreatedAt) 
                  VALUES (:questionId, :responseText, :isCorrect, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'questionId' => $questionId,
            'responseText' => $responseText,
            'isCorrect' => $isCorrect
        ]);
    }

    // Modifier une réponse
    public function updateAnswer($responseId, $responseText, $isCorrect) {
        $query = "UPDATE response SET ResponseText = :responseText, IsCorrect = :isCorrect 
                  WHERE ResponseID = :responseId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'responseText' => $responseText,
            'isCorrect' => $isCorrect,
            'responseId' => $responseId
        ]);
    }

    // Supprimer une réponse
    public function deleteAnswer($responseId) {
        $query = "DELETE FROM response WHERE ResponseID = :responseId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['responseId' => $responseId]);
    }

    // Récupérer toutes les réponses d’une question
    public function getAnswersByQuestionId($questionId) {
        $query = "SELECT * FROM response WHERE QuestionID = :questionId ORDER BY CreatedAt ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['questionId' => $questionId]);
        return $stmt->fetchAll();
    }

    // Récupérer une réponse par son ID
    public function getAnswerById($responseId) {
        $query = "SELECT * FROM response WHERE ResponseID = :responseId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['responseId' => $responseId]);
        return $stmt->fetch();
    }
}
?>
