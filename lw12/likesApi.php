<?php
    header('Content-Type: application/json');
    require_once 'post.php';
    require_once 'data_load.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        exit;
    }

    $json = $_POST['data'];
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid json data', 400);
    }

    $connection = connectDatabase();
    if (json_last_error() == JSON_ERROR_NONE) {
        $postData = [
            'post_id' => (int)$data['post_id'] ?? 1,
            'user_id' => (int)$data['user_id'] ?? 1
        ];

        $likesCount = countLikesInDatabase($connection, $postData);

        if ($likesCount > 0) {
            unsetPostLikes($connection, $postData);
            $action = 'unliked';
        } else {
            setPostLikes($connection, $postData);
            $action = 'liked';
        }
        $post = findPostInDatabase($connection, $postData['post_id']);
    } else {
        throw new Exception("json_last_error");
    }

    echo json_encode([
        'success' => true,
        'action' => $action,
        'likesCount' => $post['likes']
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}
?>