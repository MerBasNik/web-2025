<?php
    $year = intval($_POST["year"]);
    if ($year > 0 && $year <= 30000) {
        if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
            $result = "YES";
        } else {
            $result = "NO";
        }
        echo "<p>Год " . $year . " является високосным: <strong>" . $result . "</strong></p>";
    } else {
        echo "<p style='color: red;'>Ошибка: Введите год в диапазоне от 1 до 30000.</p>";
    }
?>