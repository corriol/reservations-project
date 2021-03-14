<?php
$errors = [];
try {

    $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

    $pdo = new PDO("mysql:host=127.0.0.1; dbname=reservations","user_db","abcd");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM reservation WHERE id=:id");
    $stmt->bindValue('id',$id,PDO::PARAM_INT);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $reserva = $stmt->fetch();


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $answer = filter_input(INPUT_POST, 'user_answer');
        if ($answer==="Sí") {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);


            if (empty($errors)) {
                $stmt = $pdo->prepare("DELETE FROM reservation WHERE id=:id");
                $stmt->bindValue('id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        else {
            header('Location: /reservations.php');
            exit();
        }

    }

}catch (PDOException $PDOException){
    echo $PDOException->getMessage();
}catch (Exception $exception){
    echo $exception->getMessage();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrar</title>
</head>
<body>
<?php if (!empty($errors) || $_SERVER["REQUEST_METHOD"]!=='POST'): ?>
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
    <p>name:<?=$reserva["name"]?></p>
    <p>data:<?=$reserva["date"]?></p>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" value="<?=$reserva["id"]?>" id="id" name="id">
            <input name="user_answer" type="submit" value="Sí">
            <input name="user_answer" type="submit" value="No">
        </div>
    </form>

<?php else: ?>
    <p>Se ha borrado correctamente</p>
    <a href="../index.php">Volver</a>
<?php endif; ?>
</body>
</html>

