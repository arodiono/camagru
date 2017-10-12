<?php
require_once 'config.php';
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
}
catch (Exception $e) {
	echo "Error! Can`t connect to database";
}
try {
    $insert = $db->prepare("CREATE TABLE `users` (
                                      `user_id` int(11) NOT NULL AUTO_INCREMENT,
                                      `active` int(1) unsigned NOT NULL DEFAULT '0',
                                      `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `fullname` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `profile_picture` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `biography` text COLLATE utf8mb4_unicode_ci,
                                      PRIMARY KEY (`user_id`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    $insert->execute();
}
catch (Exception $e) {
    echo "Error! Can`t add table to database";
}
try {
    $insert = $db->prepare("CREATE TABLE `posts` (
                                      `post_id` int(11) NOT NULL AUTO_INCREMENT,
                                      `user_id` int(11) DEFAULT NULL,
                                      `thumbnail` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                      `caption` text COLLATE utf8mb4_unicode_ci,
                                      `created_time` int(11) DEFAULT NULL,
                                      `count` int(11) NOT NULL DEFAULT '0',
                                      PRIMARY KEY (`post_id`),
                                      KEY `user` (`user_id`),
                                      CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    $insert->execute();
}
catch (Exception $e) {
    echo "Error! Can`t add table to database";
}
try {
	$insert = $db->prepare("CREATE TABLE `comments` (
                                      `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `user_id` int(11) DEFAULT NULL,
                                      `post_id` int(11) DEFAULT NULL,
                                      `text` text COLLATE utf8mb4_unicode_ci,
                                      `created_time` int(11) DEFAULT NULL,
                                      PRIMARY KEY (`comment_id`),
                                      KEY `user_id` (`user_id`),
                                      KEY `post_id` (`post_id`),
                                      CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
                                      CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
	$insert->execute();
}
catch (Exception $e) {
	echo "Error! Can`t add table to database";
}
try {
    $insert = $db->prepare("CREATE TABLE `likes` (
                                      `like_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `user_id` int(11) DEFAULT NULL,
                                      `post_id` int(11) DEFAULT NULL,
                                      PRIMARY KEY (`like_id`),
                                      KEY `user_id` (`user_id`),
                                      KEY `post_id` (`post_id`),
                                      CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
                                      CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    $insert->execute();
}
catch (Exception $e) {
    echo "Error! Can`t add table to database";
}
header('Location: /');