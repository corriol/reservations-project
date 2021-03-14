<?php
$errors = [];

try {
    $pdo = new PDO("mysql:host=127.0.0.1; dbname=reservations", "user_db", "abcd");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT R.*, C.name as court, T.name as time FROM reservation R 
                                    INNER JOIN court C
                                    ON C.id = R.court_id INNER JOIN timeslot T ON
                                    T.id = R.timeslot_id ORDER BY R.date DESC");

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $reserves = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($name)) {
            $errors[] = "Please, insert a text search";
        } else {
            $stmt = $pdo->prepare("SELECT R.*, C.name as court,
 T.name as time 
 FROM reservation R 
    INNER JOIN court C
    ON C.id = R.court_id INNER JOIN timeslot T ON
        T.id = R.timeslot_id WHERE
         R.name LIKE :name");
            $stmt->bindValue('name', "%$name%", PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $reserves = $stmt->fetchAll();

        }
    }

} catch (PDOException $PDOException) {
    echo $PDOException->getMessage();
} catch (Exception $exception) {
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
    <title>Panell de control</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li>Login</li>
        <li>Logout</li>
    </ul>
</nav>
<h1>Reservations</h1>

<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <input type="text" id="name" name="name">
    <input type="submit" value="Buscar">
</form>

<table>
    <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Court</th>
        <th>Hour</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($reserves as $reserva): ?>
        <tr>
            <td><?= $reserva["name"] ?></td>
            <td><?= $reserva["date"] ?></td>
            <td><?= $reserva["court"] ?></td>
            <td><?= $reserva["time"] ?></td>
            <td><a href="../reservations-delete.php?id=<?= $reserva["id"] ?>">Cancel</a></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
