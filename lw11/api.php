<?php
    header('Content-Type: application/json');
    require_once 'post.php';
    require_once 'data_load.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        exit;
    }

    $json = $_POST['data'];
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data', 400);
    }

    $imagePath = "null";
    if (!empty($_FILES['images'])) {
        $uploadDir = 'images/img_post/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $images = $_FILES['images'];
        $arrImagePath = [];
        foreach ($images as $image) {
            $filename = uniqid() . '_' . basename($image['name']);
            $imagePath = $uploadDir . $filename;
    
            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                $arrImagePath[] = $imagePath;
            }
        }
    }
    

    if (json_last_error() == JSON_ERROR_NONE) {
        $postData = [
            'post_id' => $data['post_id'] ?? 10,
            'user_id' => $data['user_id'] ?? 2,
            'text' => $data['text'],
            'images' => $arrImagesPath,
            'time' => $data['time'],
            'likes' => $data['likes'] ?? 0,
        ];
    }
    
    $connection = connectDatabase();
    $postId = savePostToDatabase($connection, [
        'post_id' => $postData['post_id'],
        'user_id' => $postData['user_id'],
        'text' => $postData['text'],
        'images' => $postData['images'],
        'time' => $postData['time'],
        'likes' => $postData['likes']
    ]);
?>