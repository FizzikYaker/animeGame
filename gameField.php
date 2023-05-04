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

        global $redisConnection;
        session_start();
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
        if ($redisConnection->get('test_key')) { //выводит тот ключ который я ему задал в другом файле
            $value = $redisConnection->get('test_key');
            echo $value;
        }


        ?>
    <div style="display: none;" id="id">
        <?php echo $_SESSION['user_id'] ?>
    </div>
    <div style="display: none;" id="login">
        <?php echo $_SESSION['user_login'] ?>
    </div>
    <a href="tryq.php">a</a>
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