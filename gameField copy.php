<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/gameField.css">
    <title>Игровое поле</title>
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

        <!-- <header></header> -->

        <main id="main">
            <!-- левое поле -->
            <div id="field_left">
                <!-- верхняя часть левого поля -->
                <div class="field_left_divs">
                    <!-- колода карт -->
                    <div class="field_left_divs_card">
                        <p style="margin-right: 24px">35x</p>
                        <div class="cards"></div>
                    </div>
                    <!-- полоска здоровья -->
                    <div class="line_hp"></div>
                    <p id="text_Mana_Enemy">10</p>
                    <p id="text_Hp_Enemy">100</p>
                    <p id="text_nik_Enemy">враг</p>
                </div>
                <!-- центральная часть левого поля -->
                <div id="step_users">
                    <p style="margin: 0">ВАШ ХОД</p>
                </div>

                <!-- нижняя часть левого поля -->
                <div class="field_left_divs">
                    <!-- полоска здоровья -->
                    <div class="line_hp"></div>
                    <p id="text_Mana_My">10</p>
                    <p id="text_Hp_My">100</p>
                    <p id="text_nik_My">я</p>
                    <!-- колода карт -->
                    <div class="field_left_divs_card">
                        <p style="margin-right: 24px">35x</p>
                        <div class="cards"></div>
                    </div>
                </div>
            </div>
            <!-- правое поле -->
            <div id="field_right">
                <!-- карты противника -->
                <div class="users_cards_div">
                    <div class="users_cards">
                        <div class="cards"></div>
                        <div class="cards"></div>
                        <div class="cards"></div>
                        <div class="cards"></div>
                        <div class="cards"></div>
                    </div>
                </div>
                <!-- игровое поле -->
                <div style="display: flex; align-items: center">
                    <!-- само игровое поле -->
                    <div id="field_right_div">
                        <!-- игровое поля противника -->
                        <div class="field_right_cards">
                            <div class="cards" id="EnemyFieldDiv"
                                style="display: flex; justify-content: space-around;  width: 0%">
                                <!-- хранит все карты его размеры зависят от количества карт(90%, 72%, 54%,36%,18%) -->
                            </div>


                            <!-- <div class="cards"></div>
                            <div class="cards"></div>
                            <div class="cards"></div>
                            <div class="cards"></div>
                            <div class="cards"></div> -->
                        </div>
                        <!-- ваше игровое поле -->
                        <div style="border: 0" class="field_right_cards" id="myField">
                            <!-- position: relative; -->
                            <div class="cards" id="myFieldDiv"
                                style="display: flex; justify-content: space-around;  width: 0%">
                                <!-- хранит все карты его размеры зависят от количества карт(90%, 72%, 54%,36%,18%) -->
                            </div>

                            <!-- <div class="cards" id="10"></div>
                            <div class="cards" id="20"></div>
                            <div class="cards" id="30">
                            </div>
                            <div class="cards" id="40"></div>
                            <div class="cards" id="50"></div> -->
                        </div>
                    </div>
                    <!-- кнопка остановки -->
                    <div id="button_stop" style="">
                        <p>кнопка</p>
                    </div>
                </div>
                <!-- ваши карты -->
                <div class="users_cards_div">
                    <div class="users_cards">
                        <div class="cards" id="ttt"></div>
                        <div class="cards" id="0"></div>
                        <div class="cards" id="1"></div>
                        <div class="cards" id="2"></div>
                        <div class="cards" id="3"></div>
                    </div>
                </div>
            </div>
        </main>
        <script src="js/gameField.js"></script>
</body>

</html>