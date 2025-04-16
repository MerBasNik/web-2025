<?php
    $dateString = $_POST["date"];
    $parsedDate = parseDateString($dateString);
    if ($parsedDate) {
        $day = $parsedDate['day'];
        $month = $parsedDate['month'];
        if (validateDate($day, $month)) {
            $zodiacSign = getZodiacSign($day, $month);
            echo "<p>Дата рождения: " . $dateString . "<br>Знак зодиака: <strong>" . $zodiacSign . "</strong></p>";
        } else {
            echo "<p style='color: red;'>Ошибка: Введите корректную дату.</p>";
        }
    } else {
        echo "<p style='color: red;'>Ошибка: Не удалось распознать формат даты.</p>";
    }
    function parseDateString($dateString) {
        $dateString = preg_replace("/[^0-9]/", "", $dateString);
        $dateParts = str_split($dateString, 2);
        if (count($dateParts) >= 3) {
            return array(
                'day' => intval($dateParts[0]),
                'month' => intval($dateParts[1])
            );
        } else {
            return false;
        }
    }
    function validateDate($day, $month) {
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
            return false;
        }
        $dayInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if ($day > $dayInMonth[$month - 1]) {
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
        $dayInMonth = array(20, 19, 20, 20, 21, 21, 23, 23, 23, 23, 22, 22);
        $monthIndex = $month - 1;
        $signIndex = ($day <= $dayInMonth[$monthIndex]) ? 0 : 1;
        return $zodiacSigns[$month][$signIndex];
    }
?>