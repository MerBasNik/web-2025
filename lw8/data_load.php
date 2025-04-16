<?php
    function loadJsonData($filename) {
        if (!file_exists($filename)) {
            throw new Exception("Файл данных не найден: $filename");
        }

        $json = file_get_contents($filename);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Ошибка парсинга JSON: " . json_last_error_msg());
        }

        if (!validateDataStructure($data)) {
            throw new Exception("Неверная структура данных");
        }

        return $data;
    }

    //tryloadjsondata поменять с loadjsondata
    function tryLoadJsonData($filename) {
        try {
            return loadJsonData($filename);
        } catch (Exception $e) {
            error_log("Data loading error: " . $e->getMessage());
            return [
                'error' => $e->getMessage(),
                'users' => []
            ];
        }
    }

    function findUserById($users, $id) {
        foreach ($users['users'] as $user) {
            if ($user['user_id'] == $id) {
                return $user;
            }
        }
        return null;
    }
    
    function formatPostTime($timestamp) {
        $temp = time() - strtotime($timestamp);
        if ($temp < 60) return 'только что';
        if ($temp < 3600) return floor($temp / 60) . ' мин назад';
        if ($temp < 86400) return floor($temp / 3600) . ' час назад';
        return date('d.m.Y H:i', strtotime($timestamp));
    }

    function handleFileUpload(array $file): string {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $file['error']);
        }

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed.');
        }

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            throw new Exception('File is too large. Maximum size is 2MB.');
        }

        $uploadDir = __DIR__ . './images';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Failed to move uploaded file.');
        }

        return './images' . $filename;
    }
?>