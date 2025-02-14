<?php
require_once __DIR__ . '/Database.php';

class Question {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addQuestion($quizId, $questionText) {
        $query = "INSERT INTO question (QuizID, QuestionText, CreatedAt) VALUES (:quizId, :questionText, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'quizId' => $quizId,
            'questionText' => $questionText
        ]);
    }

    public function updateQuestion($questionId, $questionText) {
        $query = "UPDATE question SET QuestionText = :questionText WHERE QuestionID = :questionId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'questionText' => $questionText,
            'questionId' => $questionId
        ]);
    }

    public function deleteQuestion($questionId) {
        $query = "DELETE FROM question WHERE QuestionID = :questionId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['questionId' => $questionId]);
    }

    public function getQuestionsByQuizId($quizId) {
        $query = "SELECT * FROM question WHERE QuizID = :quizId ORDER BY CreatedAt ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['quizId' => $quizId]);
        return $stmt->fetchAll();
    }

    public function getQuestionById($questionId) {
        $query = "SELECT * FROM question WHERE QuestionID = :questionId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['questionId' => $questionId]);
        return $stmt->fetch();
    }
}
?>
