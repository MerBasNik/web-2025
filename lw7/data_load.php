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
        $temp = time() - $timestamp;
        if ($temp < 60) return 'только что';
        if ($temp < 3600) return floor($temp / 60) . ' мин назад';
        if ($temp < 86400) return floor($temp / 3600) . ' час назад';
        return date('d.m.Y H:i', $timestamp);
    }
?>