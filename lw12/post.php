<?php
    function connectDatabase(): PDO {
        $dsn = 'mysql:host=localhost;dbname=blog';
        $user = 'vadimpatrusev';
        $password = 'qwerty'; 

        return new PDO($dsn, $user, $password);
    }

    function savePostToDatabase(PDO $connection, array $postParams): int {
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

        $postId = (int)$connection->lastInsertId();

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
        return $postId;
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

    function updatePostInDatabase(PDO $connection, array $postParams): bool {
        $userId = (int)$postParams['user_id'];
        $postId = (int)$postParams['post_id'] ?? 1;
        $text = $postParams['text'];
        $images = $postParams['images'];
        
        $query = <<<SQL
            UPDATE post 
            SET user_id = :user_id, 
                text = :text, 
                time = :time
            WHERE post_id = :post_id
        SQL;

        $statement = $connection->prepare($query);
        $datetime = date('Y-m-d H:i:s', (int)$postParams['time']);
        $statement->execute([
            ':user_id' => $userId,
            ':text' => $text,
            ':time' => $datetime,
            ':post_id' => $postId
        ]);

        $query = <<<SQL
            DELETE FROM post_images 
            WHERE post_id = :post_id
            SQL;
        $statement = $connection->prepare($query);
        $statement->execute([':post_id' => $postId]);

        $query = <<<SQL
            INSERT INTO post_images (post_id, image_url)
            VALUES (:post_id, :image_url)
            SQL;

        $statement = $connection->prepare($query);
        foreach ($images as $imageUrl) {
            $statement->execute([               
                ':image_url' => $imageUrl,
                ':post_id' => $postId,
            ]);
        }
        return true;
    }

    function setPostLikes(PDO $connection, array $postParams): bool {
        $userId = (int)$postParams['user_id'];
        $postId = (int)$postParams['post_id'];
        
        $query = <<<SQL
            UPDATE post 
            SET likes = likes + 1
            WHERE post_id = :post_id AND user_id = :user_id
        SQL;

        $statement = $connection->prepare($query);
        $statement->execute([
            ':user_id' => $userId,
            ':post_id' => $postId
        ]);

        $query = <<<SQL
            INSERT INTO post_likes (post_id, user_id)
            VALUES (:post_id, :user_id)
            SQL;

        $statement = $connection->prepare($query);
        $statement->execute([
            ':user_id' => $userId,
            ':post_id' => $postId
        ]);
        return true;
    }

    function unsetPostLikes(PDO $connection, array $postParams): bool {
        $userId = (int)$postParams['user_id'];
        $postId = (int)$postParams['post_id'];
        
        $query = <<<SQL
            UPDATE post 
            SET likes = likes - 1
            WHERE post_id = :post_id AND user_id = :user_id
        SQL;

        $statement = $connection->prepare($query);
        $statement->execute([
            ':user_id' => $userId,
            ':post_id' => $postId
        ]);

        $query = <<<SQL
            DELETE FROM post_likes
            WHERE post_id = :post_id AND user_id = :user_id
            SQL;

        $statement = $connection->prepare($query);
        $statement->execute([
            ':user_id' => $userId,
            ':post_id' => $postId
        ]);
        
        return true;
    }

    function countLikesInDatabase(PDO $connection, array $postParams): int {
        $userId = (int)$postParams['user_id'];
        $postId = (int)$postParams['post_id'];

        $query = <<<SQL
            SELECT COUNT(*) as count
            FROM post_likes
            WHERE post_id = :post_id AND user_id = :user_id
        SQL;

        $statement = $connection->prepare($query);
        $statement->execute([
            ':post_id' => $postParams['post_id'],
            ':user_id' => $postParams['user_id']
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }
?>