<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$dsn = 'mysql:dbname=;host=localhost';
$user = '';
$password = '';

try{
    $dbh = new pdo($dsn,$user,$password);

    if($dbh == null){
        print('接続に失敗しました。');
    }else{
        print('接続に成功しました。');
    }
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;

?>

</body>
</html>
