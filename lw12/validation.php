<?php
    function validateString($value, $minLength, $maxLength) {
        if (!is_string($value)) {
            return false;
        }
        $length = mb_strlen($value);
        return $length >= $minLength && $length <= $maxLength;
    }

    function validateDate($dateString) {
        if (!is_string($dateString)) {
            return false;
        }
        $day = date('d', $timestamp);
        $month = date('m', $timestamp);
        $year = date('Y', $timestamp);
        return checkdate($month, $day, $year);
    }

    function validateId($id) {
        return is_int($id) && $id > 0;
    }

    function validatePosts($posts) {
        if (!is_array($posts)) {
            return false;
        }

        foreach ($posts as $post) {
            if (!isset($post['post_id']) || !validateId($post['post_id'])) {
                return false;
            }
            if (!isset($post['text']) || !validateString($post['text'], 1, 100000)) {
                return false;
            }
            if (isset($post['image'])) {
                return true;
            }
            if (!isset($post['time']) || !validateDate($post['time'])) {
                return false;
            }
        }
        return true;
    }

    function validateUser($user) {
        return isset($user['user_id']) && validateId($user['user_id'])
            && isset($user['name']) && validateString($user['name'], 2, 50)
            && isset($user['avatar'])
            && (!isset($user['about']) || validateString($user['about'], 0, 50000))
            && isset($user['posts']) && validatePosts($user['posts']);
    }

    function validateDataStructure($data) {
        if (!isset($data['users']) || !is_array($data['users'])) {
            return false;
        }
        
        foreach ($data['users'] as $user) {
            if (!validateUser($user)) {
                return false;
            }
        }
        return true;
    }
?>