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
    $arrImagePaths = [];
    if (!empty($_FILES['images'])) {
        $uploadDir = 'images/img_post/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $images = $_FILES['images'];
        foreach ($images['name'] as $index => $image) {
            $filename = uniqid() . '_' . basename($image);
            $imagePath = $uploadDir . $filename;  
            if (move_uploaded_file($images['tmp_name'][$index], $imagePath)) {
                $arrImagePaths[] = $imagePath;
            }
        }
    };
    
    if (!empty($data['images'])) {
        foreach($data['images'] as $img) {
            $arrImagePaths[] = $img;
        };
    }
    
    $connection = connectDatabase();
    if (json_last_error() == JSON_ERROR_NONE) {
        $postData = [
            'post_id' => $data['post_id'] ?? null,
            'user_id' => $data['user_id'] ?? 1,
            'text' => $data['text'] ?? '',
            'images' => $arrImagePaths,
            'time' => $data['time'] ?? time(),
            'likes' => $data['likes'] ?? 0
        ];
        if (!updatePostinDatabase($connection, $postData)) {
            throw new Exception("error during update");
        };
    } else {
        throw new Exception("json_last_error");
    }

    echo json_encode([
        'success' => true
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