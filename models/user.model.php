<?php

class UserModel extends Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function activateUser($data = array())
	{
		$email = $data[0];
		$hash = $data[1];
		$request = "UPDATE `users`
					SET `active` = 1
					WHERE `email` = $email
					AND `hash` = $hash";
		$update = $this->database->prepare($request);
		$update->execute();
		$count = $update->rowCount();
		if ($count == 1)
		{
			Session::add('infoMessage', 'User successfully activated');
			return true;
		}
		else
		{
			Session::add('errorMessage', 'User is not activated');
			return false;
		}
	}

	public function editUser($user_id, $fullname, $biography)
    {
        $request = "UPDATE `users`
                    SET `fullname` = '$fullname', `biography` = '$biography'
                    WHERE `user_id` = '$user_id'";
        $update = $this->database->prepare($request);
        $update->execute();
        $count = $update->rowCount();
        if ($count == 1)
            return true;
        else
            return false;
    }

    public function editProfilePicture($user_id, $filename)
    {
        $request = "UPDATE `users`
                    SET `profile_picture` = '$filename'
                    WHERE `user_id` = '$user_id'";
        $update = $this->database->prepare($request);
        $update->execute();
        $count = $update->rowCount();
        if ($count == 1)
            return true;
        else
            return false;
    }

	public function getUserDataFromName($username)
    {
        $request = "SELECT `username`, `fullname`, `email`, `hash`, `profile_picture`, `biography`
                    FROM `users`
                    WHERE `username` = '$username'";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetch(2);
    }

    public function getUserDataFromId($user_id)
    {
        $request = "SELECT `users`.*, COUNT(`posts`.`user_id`) AS posts_count FROM `users`
                    LEFT JOIN `posts` ON `users`.`user_id` = `posts`.`user_id`
                    WHERE `users`.`user_id`= \"$user_id\" GROUP BY `users`.`user_id`";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetch(2);
    }

    public function getUserPosts($username)
    {
        $request = "SELECT `posts`.`post_id`, `posts`.`thumbnail`, `posts`.`caption`, `users`.`username`
                    FROM `users`
                    INNER JOIN `posts` ON `posts`.`user_id` = `users`.`user_id`
                    WHERE (`users`.`username` = '$username')
                    ORDER BY `post_id`
                    DESC";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetchAll(2);
    }
}
