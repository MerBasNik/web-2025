<?php
    function connectDatabase(): PDO {
        $dsn = 'mysql:host=localhost;dbname=blog';
        $user = 'vadimpatrusev';
        $password = 'qwerty'; 

        return new PDO($dsn, $user, $password);
    }

    function savePostToDatabase(PDO $connection, array $postParams): int {
        $postId = (int)$postParams['post_id'];
        $userId = (int)$postParams['user_id'];
        $text = $postParams['text'];
        $images = $postParams['images'];
        $likes = (int)$postParams['likes'];
        
        $query = <<<SQL
            INSERT INTO post (user_id, text, time, likes)
            VALUES (:user_id, :text, :time, :likes)
            SQL;

        $statement = $connection->prepare($query);
        $datetime = date('Y-m-d H:i:s', (int)$postParams['time']);
        $statement->execute([
            ':user_id' => $userId,
            ':text' => $text,
            ':time' => $datetime,
            ':likes' => $likes,
        ]);

        $query = <<<SQL
            INSERT INTO post_images (post_id, image_url)
            VALUES (:post_id, :image_url)
            SQL;

        $statement = $connection->prepare($query);
        foreach ($images as $imageUrl) {
            $statement->execute([
                ':post_id' => $postId,
                ':image_url' => $imageUrl,
            ]);
        }
        return (int)$connection->lastInsertId();
    }

    function findPostInDatabase(PDO $connection, int $postId): ?array {
        $query = <<<SQL
            SELECT
                *
            FROM post 
            WHERE post_id = $postId
            SQL;

        $statement = $connection->query($query);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    function findPostImagesByPostId(PDO $connection, int $postId): ?array {
        $query = <<<SQL
            SELECT
                image_url
            FROM post_images 
            WHERE post_id = $postId
            SQL;

        $statement = $connection->query($query);
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    function findUserInDatabase(PDO $connection, int $userId): ?array {
        $query = <<<SQL
            SELECT
                *
            FROM user 
            WHERE user_id = $userId
            SQL;

        $statement = $connection->query($query);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    function findPostsByUserId(PDO $connection, int $userId): ?array {
        $query = <<<SQL
            SELECT
                post_id
            FROM post 
            WHERE user_id = $userId
            SQL;

        $statement = $connection->query($query);
        $row = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
        return $row ?: null;
    }

    function findUsersInDatabase(PDO $connection): ?array {
        $query = <<<SQL
            SELECT
                user_id
            FROM user
            SQL;

        $statement = $connection->query($query);
        $row = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
        return $row ?: null;
    }
?>