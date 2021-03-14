<?php
define("CONFIRMATION_BTN", "Yes");
$errors = [];
try {
    $pdo = new PDO("mysql:host=mysql-server; dbname=reservations", "user_db", "abcd");
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (empty($id)) {
            $errors[] = "Invalid reservation";
        } else {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM reservation WHERE id=:id");
            $stmt->bindValue('id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $reserva = $stmt->fetch();
        }
    }
    else {
        $answer = filter_input(INPUT_POST, 'user_answer');
        if ($answer===CONFIRMATION_BTN) {
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
    die($PDOException->getMessage());
}catch (Exception $exception){
    die($exception->getMessage());
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
        <p>Go to <a href="reservations.php">reservations</a></p>
    <?php else: ?>
        <h2>Confirm delete</h2>
        <p>This reservation will be delete. Are you sure?</p>
        <p>name:<?=$reserva["name"]?></p>
        <p>data:<?=$reserva["date"]?></p>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" value="<?=$reserva["id"]?>" id="id" name="id">
            <input name="user_answer" type="submit" value="<?=CONFIRMATION_BTN?>">
            <input name="user_answer" type="submit" value="No">
            </div>
        </form>

    <?php endif; ?>
<?php else: ?>
    <p>Se ha borrado correctamente</p>
    <a href="../index.php">Volver</a>
<?php endif; ?>
</body>
</html>

