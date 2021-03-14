<?php


if ($_SERVER["REQUEST_METHOD"] !== "POST")
    die("Something wrong ocurred!");



$userAnswer = filter_input(INPUT_POST, "userAnswer");
if ($userAnswer === "yes") {

    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    /* TODO: VALIDAR */

    $pdo = new PDO("mysql:host=localhost;dbname=reservations;charset=utf8", "user_db", "abcd");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM
     reservation  
     WHERE
        id=:id");

    $stmt->bindValue("id", $id, PDO::PARAM_INT);

    $result = $stmt->execute();

    if ($result === false) {
        $errors[] = "There are errors processing your request";
    }
} 
    else
        $errors[] = "Cancel request has been cancelled by user"
?>


<html>

<head></head>

<body>
<h1>Cancel reservation</h1>


    <?php if (empty($errors)) : ?>
        <p>Your reservation has been cancelled.</p>


    <?php else : ?>
        <p>There were errors</p>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>

</body>

</html>