<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Carpooling</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
        $user = 'rootRemote';
        $pass = '5bi';
        try{
            $conn = new PDO('mysql:host=192.168.46.31;dbname=carpooling', $user, $pass);
            echo 'connessione riuscita';
            //$stmt = $conn->prepare("SELECT * from Passeggeri");
            //$stmt->execute();
            //$stmt->
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    ?>
</body>
</html>