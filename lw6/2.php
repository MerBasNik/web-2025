<?php
    $digit = intval($_POST["digit"]);
    if ($digit >= 0 && $digit <= 9) {
        $digits = array(
            "Ноль", "Один", "Два", "Три", "Четыре",
            "Пять", "Шесть", "Семь", "Восемь", "Девять"
        );
        $result = $digits[$digit];
        echo "<p>Цифра " . $digit . " соответствует слову: <strong>" . $result . "</strong></p>";
    } else {
        echo "<p style='color: red;'>Ошибка: Введите цифру от 0 до 9.</p>";
    }
?>