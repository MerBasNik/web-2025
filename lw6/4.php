<?php
    $date_string = $_POST["date"];
    $parsed_date = parseDateString($date_string);
    if ($parsed_date) {
        $day = $parsed_date['day'];
        $month = $parsed_date['month'];
        if (validateDate($day, $month)) {
            $zodiac_sign = getZodiacSign($day, $month);
            echo "<p>Дата рождения: " . $date_string . "<br>Знак зодиака: <strong>" . $zodiac_sign . "</strong></p>";
        } else {
            echo "<p style='color: red;'>Ошибка: Введите корректную дату.</p>";
        }
    } else {
        echo "<p style='color: red;'>Ошибка: Не удалось распознать формат даты.</p>";
    }
    function parseDateString($date_string) {
        $date_string = preg_replace("/[^0-9]/", "", $date_string);
        $date_parts = str_split($date_string, 2);
        if (count($date_parts) >= 3) {
            return array(
                'day' => intval($date_parts[0]),
                'month' => intval($date_parts[1])
            );
        } else {
            return false;
        }
    }
    function validateDate($day, $month) {
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
            return false;
        }
        $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if ($day > $days_in_month[$month - 1]) {
            return false;
        }
        return true;
    }
    function getZodiacSign($day, $month) {
        $zodiacSigns = array(
            1  => array("Козерог", "Водолей"),
            2  => array("Водолей", "Рыбы"),
            3  => array("Рыбы", "Овен"),
            4  => array("Овен", "Телец"),
            5  => array("Телец", "Близнецы"),
            6  => array("Близнецы", "Рак"),
            7  => array("Рак", "Лев"),
            8  => array("Лев", "Дева"),
            9  => array("Дева", "Весы"),
            10 => array("Весы", "Скорпион"),
            11 => array("Скорпион", "Стрелец"),
            12 => array("Стрелец", "Козерог")
        );
        $day_in_month = array(20, 19, 20, 20, 21, 21, 23, 23, 23, 23, 22, 22);
        $monthIndex = $month - 1;
        $signIndex = ($day <= $day_in_month[$monthIndex]) ? 0 : 1;
        return $zodiacSigns[$month][$signIndex];
    }
?>