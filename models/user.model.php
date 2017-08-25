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
					WHERE `email` = \"$email\"
					AND `hash` = \"$hash\"";
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

	public function getUserData($username)
    {
        $request = "SELECT `login`, `fullname`, `email`, `hash`, `avatar`, `description`
                    FROM `users`
                    WHERE `login`= \"$username\"";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetch(2);
    }

    public function getUserPosts($username)
    {
        $request = "SELECT `posts`.`post_id`, `posts`.`img_id`, `posts`.`description`, `users`.`login`
                    FROM `users`
                    LEFT JOIN `posts` ON `posts`.`user_id` = `users`.`user_id`
                    WHERE (`users`.`login`=\"$username\")
                    ORDER BY `post_id`
                    DESC";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetchAll(2);
    }
}
