<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic-Tac-Toe</title>

</head>

<body><?php require_once 'php/pRedis_connection.php';
        global $redisConnection;

        $redisConnection->set('test_key', 'hfsadfasi');
        ?>

</body>

</html>