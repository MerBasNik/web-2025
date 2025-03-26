<?php
    $start_ticket = intval($_POST["start_ticket"]);
    $end_ticket = intval($_POST["end_ticket"]);
    if ($start_ticket <= $end_ticket) {
        if ($start_ticket >= 100000 && $start_ticket <= 999999 && $end_ticket >= 100000 && $end_ticket <= 999999) {
            echo "<h2>Счастливые билеты в диапазоне от " . $start_ticket . " до " . $end_ticket . ":</h2>";
            echo "<ul>";
            for ($ticket = $start_ticket; $ticket <= $end_ticket; $ticket++) {
                if (isHappyTicket($ticket)) {
                    echo "<li>" . $ticket . "</li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>Ошибка: Введите шестизначные номера билетов.</p>";
        }
    } else {
        echo "<p style='color: red;'>Ошибка: Конечный номер билета должен быть больше начального номера билета.</p>";
    }

    function isHappyTicket($ticket) {
        $ticket_str = strval($ticket);
        $sum1 = intval($ticket_str[0]) + intval($ticket_str[1]) + intval($ticket_str[2]); 
        $sum2 = intval($ticket_str[3]) + intval($ticket_str[4]) + intval($ticket_str[5]);
        return $sum1 === $sum2;
    }
?>