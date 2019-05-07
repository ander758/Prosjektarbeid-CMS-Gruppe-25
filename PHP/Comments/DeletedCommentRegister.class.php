<?php
class DeletedCommentRegister implements DeletedCommentInterface {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function showAllDeletedComments(): array
    {
        // TODO: Implement showAllDeletedComments() method.
        // Return all deleted comments from table `DeletedComments`
        $deletedComments = array();
        try {
            $stmt = $this->db->prepare("SELECT * FROM DeletedComments ORDER BY DateDeleted DESC");
            $stmt->execute();
            while ($deletedComment = $stmt->fetchObject("DeletedComment")) {
                $deletedComments = $deletedComment;
            }
            return $deletedComments;
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
        return $deletedComments;
    }

    public function showAllDeletedCommentsFromUser(int $userID): array
    {
        // TODO: Implement showAllDeletedCommentFromUser() method.
        // Return all deleted comments from a user
        // $deletedComments
        try {
            $stmt = $this->db->prepare("SELECT * FROM DeletedComments where UserID = :userID");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function showDeletedComment(int $deletedCommentID): DeletedComment
    {
        // TODO: Implement showDeletedComment() method.
    }

    public function addDeletedComment(Comment $comment): int
    {
        // TODO: Implement addDeletedComment() method.
    }
}