<?php
    $startTicket = intval($_POST["start_ticket"]);
    $endTicket = intval($_POST["end_ticket"]);
    if ($startTicket <= $endTicket) {
        if ($startTicket >= 100000 && $startTicket <= 999999 && $endTicket >= 100000 && $endTicket <= 999999) {
            echo "<h2>Счастливые билеты в диапазоне от " . $startTicket . " до " . $endTicket . ":</h2>";
            echo "<ul>";
            for ($ticket = $startTicket; $ticket <= $endTicket; $ticket++) {
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
        $ticketStr = strval($ticket);
        $sum1 = intval($ticketStr[0]) + intval($ticketStr[1]) + intval($ticketStr[2]); 
        $sum2 = intval($ticketStr[3]) + intval($ticketStr[4]) + intval($ticketStr[5]);
        return $sum1 === $sum2;
    }
?>