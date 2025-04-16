<?php
    $expression = $_POST["expression"];
    $result = evaluateExpression($expression);
    echo "<h2>Результат:</h2>";
    echo "<p>$result</p>";
    function evaluateExpression($expression) {
        $stack = [];
        $tokens = explode(" ", trim($expression)); 
        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                array_push($stack, $token);
            } else {
                $operand2 = array_pop($stack);
                $operand1 = array_pop($stack);

                $result = match ($token) {
                    '+' => $operand1 + $operand2,
                    '-' => $operand1 - $operand2,
                    '*' => $operand1 * $operand2,
                    default => "Ошибка: Недопустимый оператор!",
                };
                array_push($stack, $result);
            }
        }
        if (count($stack) == 1) {
            return array_pop($stack);
        } else {
            return "Ошибка: Некорректное выражение!";
        }
    }
?>