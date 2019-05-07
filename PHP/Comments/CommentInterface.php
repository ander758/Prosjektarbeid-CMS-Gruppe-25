<?php
interface CommentInterface {
    public function showAllComments(): array;                           // Return array with all comments
    public function showAllCommentsFromFile(int $fileID): Comment;      // Return array with all comments in specific File
    public function showComment(int $commentID): Comment;               // Return specific comment
    public function addComment(Comment $comments) : int;                // Return id for new comment
    public function deleteComment(int $commentID): bool;    // Return bool for status of comment deletion
    //public function updateComment(comment $comment, int $id): bool;   // Return bool for status of comment update
}