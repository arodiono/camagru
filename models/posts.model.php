<?php

class PostsModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function     addPost($filename, $caption = null)
    {
        $user_id    = $_SESSION['user_id'];
        $request    = "INSERT INTO `posts` (`user_id`, `thumbnail`, `caption`)
                       VALUES (\"$user_id\", \"$filename\", \"$caption\")";
        $insert = $this->database->prepare($request);
        $insert->execute();
    }

    public function     deletePost($post_id)
    {
        $user_id    = $_SESSION['username'];
        $post = $this->getPost($post_id);

        if ($post[0]['username'] === $user_id) {

            $request = "DELETE
                        FROM `comments`
                        WHERE post_id=\"$post_id\"";
            $delete = $this->database->prepare($request);
            $delete->execute();

            $request = "DELETE
                        FROM `likes`
                        WHERE post_id=\"$post_id\"";
            $delete = $this->database->prepare($request);
            $delete->execute();

            $request = "DELETE
                        FROM `posts`
                        WHERE post_id=\"$post_id\"";
            $delete = $this->database->prepare($request);
            $delete->execute();

            ImgModel::delete($post[0]['username'], $post[0]['thumbnail']);

            return true;
        }
        else {
            return false;
        }
    }

    public function     getPost($post_id)
    {
        $request = "SELECT `posts`.`post_id`, `posts`.`thumbnail`, `posts`.`caption`, `posts`.`created_time`, `posts`.`count`, `users`.`username`, `users`.`profile_picture` 
                    FROM `users`
                    INNER JOIN `posts` ON `posts`.`user_id` = `users`.`user_id`
                    WHERE (`posts`.`post_id`=\"$post_id\")";
        $select = $this->database->prepare($request);
        $select->execute();

        if($select->rowCount() === 0)
            return false;

        $post = $select->fetchAll(2);
        $post[0]['comments'] = $this->getComments($post_id);
        return $post;
    }

    public function     getComments($post)
    {
        $request = "SELECT `comments`.`text`, `comments`.`created_time`, `users`.`username`
                    FROM `users`
                    LEFT JOIN `comments` ON `comments`.`user_id` = `users`.`user_id`
                    WHERE (`comments`.`post_id`=\"$post\")
                    ORDER BY `comments`.`comment_id`
                    ASC";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetchAll(2);
    }

    public function     getLastPosts($offset)
    {
        $request = "SELECT `posts`.`post_id`, `posts`.`thumbnail`, `posts`.`caption`, `posts`.`created_time`, `posts`.`count`, `users`.`username`, `users`.`profile_picture` 
                    FROM `users`
                    INNER JOIN `posts` ON `posts`.`user_id` = `users`.`user_id`
                    ORDER BY `post_id`
                    DESC LIMIT 10 OFFSET $offset";
        $select = $this->database->prepare($request);
        $select->execute();
        $comments = $select->fetchAll(2);

        for ($i=0; $i < count($comments); $i++)
            $comments[$i]['comments'] = $this->getComments($comments[$i]['post_id']);

        return $comments;
    }

    private function    issetLike($post, $user)
    {
        $request = "SELECT *
                    FROM `likes`
                    WHERE `post_id`=$post
                    AND `user_id`=$user";
        $select = $this->database->prepare($request);
        $select->execute();
        if ($select->rowCount() > 0)
            return true;
        else
            return false;
    }

    private function    countLikes($post)
    {
        $request = "SELECT *
                    FROM `likes`
                    WHERE `post_id`=$post";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->rowCount();
    }

    private function    updateLikesCounter($post)
    {
        $likes = $this->countLikes($post);
        $request = "UPDATE `posts`
                    SET `count`=$likes
                    WHERE `post_id`=$post";
        $insert = $this->database->prepare($request);
        $insert->execute();
    }

    private function    setLike($post, $user)
    {
        $request = "INSERT INTO `likes` (`user_id`, `post_id`)
                    VALUES ($user, $post)";
        $insert = $this->database->prepare($request);
        $insert->execute();
    }

    private function    deleteLike($post, $user)
    {
        $request = "DELETE
                    FROM `likes`
                    WHERE `post_id`=$post
                    AND `user_id`=$user";
        $select = $this->database->prepare($request);
        $select->execute();
    }

    public function     prepareLike()
    {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];

        if (empty($post_id))
            return false;

        if ($this->issetLike($post_id, $user_id))
        {
            $this->deleteLike($post_id, $user_id);
            $this->updateLikesCounter($post_id);
        }
        else
        {
            $this->setLike($post_id, $user_id);
            $this->updateLikesCounter($post_id);
        }
        return $this->countLikes($post_id);
    }

    public function     addComment()
    {
        $post_id = $_POST['post_id'];
        $text = $_POST['text'];
        $author = $_SESSION['user_id'];
        $created_time = time();

        if (!empty($text) && !empty($post_id) && !empty($author)) {
            $data = array($author, $post_id, $text, $created_time);
            $request = "INSERT INTO `comments` (`user_id`, `post_id`, `text`, `created_time`)
                        VALUES (?, ?, ?, ?)";
            $insert = $this->database->prepare($request);
            $insert->execute($data);
            $count = $insert->rowCount();
            if ($count == 1)
                return array('post_id' => $post_id, 'text' => $text, 'username' => $_SESSION['username'], 'created_time' => $created_time);
            else
                return false;
        }
        else
            return false;
    }

    public function     sendCommentEmail($data)
    {
        $post = $this->getPost($data['post_id']);
        $user = new UserModel();
        $userdata = $user->getUserDataFromName($post[0]['username']);
        $email = $userdata['email'];
        $subject = 'You have new comment';
        $link = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $userdata['username'] . '/' . $data['post_id'];
        $message = file_get_contents(APP . 'views/mail/header.php');
        $message .= '<p>You have new comment from <b>' . $data['username'] . '</b></p></br>';
        $message .= '<p>' . $data['text'] . '</p></br>';
        $message .= '<p>' . $link . '</p></br>';
        $message .= file_get_contents(APP . 'views/mail/footer.php');
        $encoding = "utf-8";
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: Camagram <noreply@camagram.com> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

        mail($email, $subject, $message, $header);
    }
}