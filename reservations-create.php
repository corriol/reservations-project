<?php
declare(strict_types=1);
// it's a good practise to save the cookie name in a variable to avoid misspelling errors.
$cookieName = "last_used_name";

// we get the current cookie value
$lastUsedName = filter_input(INPUT_COOKIE, $cookieName);

// if empty (null or false, see filter_input for more details) we assign empty string to ensure
// $lastUsedName is a string.
if (empty($lastUsedName))
    $lastUsedName = "";

// start the session management
session_start();

// get the current values
$errors = $_SESSION["errors"] ?? [];

// unset values
unset($_SESSION["errors"]);

try {
    $pdo = new PDO("mysql:host=mysql-server; dbname=reservations", "user_db", "abcd");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM court");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $courts = $stmt->fetchAll();


    $stmt = $pdo->query("SELECT * FROM timeslot");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $timeslots = $stmt->fetchAll();

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
    <title>Crear</title>
    <style>
        form {
            display: table;
        }

        form > div {
            display: table-row;

        }

        form > div > label:first-child {
            display: table-cell;
            padding: 1em;
        }

        form > div input {
            display: table-cell;
        }

        form > div input[type="submit"] {

            display: block;
        }

    </style>
</head>
<body>

<h1>Reserve a court</h1>

<?php if (!empty($errors)): ?>
    <h2>Error!</h2>
    <p>There are some errors:</p>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="reservations-store.php" method="post">
    <div>
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $lastUsedName ?>">
    </div>
    <div>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">
    </div>
    <div>
        <label>Hora:</label>

        <?php foreach ($timeslots as $time): ?>
            <label for="ts-<?= $time["id"] ?>"><input type="radio" value="<?= $time["id"] ?>"
                                                      id="ts-<?= $time["id"] ?>"
                                                      name="timeslot_id"><?= $time["name"] ?>
            </label>
        <?php endforeach; ?>

    </div>
    <div>
        <label for id="court">Court</label>
        <select id="court" name="court_id">
            <option selected value="0">(Choose a court)</option>
            <?php foreach ($courts as $court): ?>
                <option value="<?= $court["id"] ?>"><?= $court["name"] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Reserve">
    </div>
</form>
</body>
</html>