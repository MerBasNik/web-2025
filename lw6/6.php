<?php
    $number = intval($_POST["number"]);
    if ($number >= 0) {
        $factorial = factorialRecursive($number);
        echo "<p>Факториал числа " . $number . " равен: <strong>" . $factorial . "</strong></p>";
    } else {
        echo "<p style='color: red;'>Ошибка: Введите положительное число.</p>";
    }
    function factorialRecursive($n) {
        if ($n == 0) {
            return 1;
        } else {
            return $n * factorialRecursive($n - 1);
        }
    }
?>