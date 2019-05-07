<?php
class CommentRegister implements CommentInterface {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function showAllComments(): array
    {
        // Return all comments from table `Comments`
        $comments = array();
        try {
            $stmt = $this->db->query("SELECT * FROM Comments ORDER BY `Date` DESC");
            $stmt->execute();
            while ($comment = $stmt->fetchObject("Comment")) {
                $comments = $comment;
            }
            return $comments;
        } catch (Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
        return $comments;
    }

    public function showAllCommentsFromFile(File $fileID): File
    {
        // TODO: Implement showAllCommentsFromFile() method.
    }

    public function showComment(int $commentID): Comment
    {
        // Return specific comment from table `Comments`
        try {
            $stmt = $this->db->prepare("SELECT * FROM Comments WHERE CommentID = :commentID");
            $stmt->bindParam(':commentID', $commentID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchObject("Comment");
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function addComment(Comment $comment): int
    {
        // Add comment to table `Comments`
        try {
            $stmt = $this->db->prepare("INSERT INTO `Comments`(`FileID`, `UserID`, `Date`, `Comment`) VALUES (:fileID, :userID, `:date`, :comment)");
            $stmt->bindValue(':fileID', $comment->hentFileID(), PDO::PARAM_INT);
            $stmt->bindValue(':userID', $comment->hentUserID(), PDO::PARAM_INT);
            $stmt->bindValue(':date', $comment->hentDate(), PDO::PARAM_INT); // INT??????
            $stmt->bindValue(':comment', $comment->hentComment(), PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Feil ved innlegging av ny comment!";
                return false;
            }
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }

    public function deleteComment(Comment $comment, int $commentID): bool
    {
        // TODO: Implement deleteComment() method.
        // Delete specific comment by it's ID in table `Comments` and send it to table 'DeletedComments' along with origin Date
        try {
            // Delete specific comment
            $stmtDel = $this->db->prepare("DELETE FROM Comments WHERE CommentID = ::commentID");
            $stmtDel->bindParam(':commentID', $commentID, PDO::PARAM_INT);
            $resultAdd = $stmtDel->execute();

            // Send $comment to table `DeletedComments`
            $stmtAdd = $this->db->prepare("INSERT INTO DeletedComments(CommentID, UserID, DeletedComment, DateDeleted) VALUES (:commentID, :userID, :deletedComment, :dateDeleted)");
            $stmtDel->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $stmtDel->bindValue(':userID', $comment->hentUserID(), PDO::PARAM_INT);
            $stmtDel->bindValue(':deletedComment', $comment->hentComment(), PDO::PARAM_STR);
            $stmtDel->bindValue(':dateDeleted', date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $resultDel = $stmtAdd->execute();

            if ($resultAdd && $resultDel) {
                return true;
            } else {
                echo "Feil ved sletting av comment!";
                return false;
            }
        } catch (InvalidArgumentException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }
}