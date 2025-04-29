<?php
    require_once 'post.php';
    require_once 'data_load.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        exit;
    }

    $json = $_POST['data'];
    $data = json_decode($json, true);


    $imagePath = "null";
    if (!empty($_FILES['image'])) {
        $uploadDir = 'images/img_post/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $imagePath = $imagePath;
        }
    }
    

    if (json_last_error() == JSON_ERROR_NONE) {
        $postData = [
            'user_id' => $data['user_id'],
            'text' => $data['text'],
            'image' => $imagePath,
            'time' => $data['time'],
            'likes' => $data['likes']
        ];
    }
    
    $connection = connectDatabase();
    $postId = savePostToDatabase($connection, [
        'user_id' => $postData['user_id'],
        'text' => $postData['text'],
        'image' => $postData['image'],
        'time' => $postData['time'],
        'likes' => $postData['likes']
    ]);
?>