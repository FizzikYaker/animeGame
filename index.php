<!-- index.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic-Tac-Toe</title>
    <style>
    /* Add your styles here */
    #game {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .row {
        display: flex;
    }

    .cell {
        border: 1px solid black;
        width: 50px;
        height: 50px;
        text-align: center;
        line-height: 50px;
        cursor: pointer;
    }
    </style>
</head>

<body><?php
        require_once 'php/pRedis_connection.php';
        require_once 'php/mySQLi_connection.php';


        // Установка значения ключа 'test_key' равным 'Hello, Predis!'
        $redis->set('test_key', 'Hello, Predisas!');

        // Получение значения ключа 'test_key'
        $value = $redis->get('test_key');

        // Вывод значения на экран
        echo $value; // Вывод: 'Hello, Predis!'

        // Удаление ключа 'test_key'
        $redis->del('test_key');
        ?>
    <div id="game">
        <hp1 id="status">Ожидание игрока...</hp1>
        <button id="restart" style="display:none;">Перезапустить игру</button>

        <div class="board">
            <div class="row">
                <div class="cell" data-cell></div>
                <div class="cell" data-cell></div>
                <div class="cell" data-cell></div>
            </div>
            <div class="row">
                <div class="cell" data-cell></div>
                <div class="cell" data-cell></div>
                <div class="cell" data-cell></div>
            </div>
            <div class="row">
                <div class="cell" data-cell></div>
                <div class="cell" data-cell></div>
                <div class="cell" data-cell></div>
            </div>
        </div>
    </div>
    <script src="js/game.js"></script>
</body>

</html>