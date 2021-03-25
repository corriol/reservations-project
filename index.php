<?declare(strict_types=1);

// it's a good practise to save the cookie name in a variable to avoid misspelling errors.
$cookieName = "last_visit_date";

// we get the current cookie value
$lastVisit = filter_input(INPUT_COOKIE, $cookieName, FILTER_VALIDATE_INT);

// we can also use the coalsece operator
/* $lastVisit =(int)($_COOKIE[$cookieName] ?? null); //
// or the traditional isset
/* if (isset($_COOKIE[$cookieName])) {
$lastVisit = (int)$_COOKIE[$cookieName];
} else
$lastVisit = null;
*/

// if null we show a welcome message
if (empty($lastVisit))
    $message = "Welcome to our reservation system!";
else
    $message = "Welcome back, your last visit was on " . date("d/m/Y h:i:s", $lastVisit);

// we register the current time and set the expiration date to the next week.
setcookie($cookieName, (string)time(), time() + 7 * 24 * 60 * 60);


// We turn on the session support
session_start();
$confirmationMessage = $_SESSION["message"] ?? "";
unset($_SESSION["message"]);

$sessionKey = "visits";

// check if is the first visit
$visits = $_SESSION[$sessionKey]??[];

// if not empty generate a HTML Unordered List
/*
if (!empty($visits))
$messageSession =  "<ul><li>" . implode("</li><li>", array_map(function($v) {
        return date("d/m/Y h:i:s", $v);
        }, $visits)) . "</li></ul>";
else
$messageSession = "Welcome to our reservation system (session version)!";
*/
$_SESSION[$sessionKey][] = time();



?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="reservations.php">Dashboard</a></li>
        <li>Login</li>
        <li>Logout</li>
    </ul>
</nav>
<h1>Reservation service</h1>
<p><?= $message ?></p>


<?php if (!empty($confirmationMessage)) :?>
    <h2>Success!</h2>
    <p><?= $confirmationMessage ?></p>
<?php endif ?>
<p>What do you want to do?</p>
<ul>
    <li><a href="reservations-create.php">Make a reservation</a></li>
    <li><a href="reservations-cancel.php">Cancel a reservation</a></li>
</ul>

</body>
</html>