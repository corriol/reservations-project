<html>

<head>

<style>
    .table {
        display: table;
    }

    .table label {        
        display: table-row;        
    }

    .table input {
        display: table-cell;
    }


</style>
</head>

<body>
<h1>Cancel reservation</h1>
    <form class="table" action="reservations-cancel-confirm.php" method="post">
        
            <label>Reservation number</label>
            <input type="text" name="id" value="" />
            <label>Reservation name</label>
            <input type="text" name="name" value="" />

            <input type="submit" value="cancel">
        
    </form>


</body>

</html>