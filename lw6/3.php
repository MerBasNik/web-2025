<?php
    $date = $_POST["date"];
    $dateParts = explode(".", $date);
    $day = intval($dateParts[0]);
    $month = intval($dateParts[1]);
    $year = intval($dateParts[2]);
    if (checkdate($month, $day, $year)) {
        $zodiacSign = getZodiacSign($day, $month);
        echo "<p>Дата рождения: " . $date . "<br>Знак зодиака: <strong>" . $zodiacSign . "</strong></p>";
    } else {
        echo "<p style='color: red;'>Ошибка: Введите корректную дату в формате ДД.ММ.ГГГГ.</p>";
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