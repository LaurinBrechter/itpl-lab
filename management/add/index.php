<!DOCTYPE html>
<html lang="en">

<?php
$title = "Hinzufügen";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
?>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/server/decode_jwt.php';
    $payload = getJwtPayload($_COOKIE["jwt"], ['MANAGEMENT']);
    ?>
    <div class="forms-container">
        <div class="form-container">
            <h2>Neuen Servicepartner hinzufügen</h2>
            <form action="/management/add_servicepartner.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>
                <label for="tax_number">Steuernummer:</label>
                <input type="text" id="tax_number" name="tax_number"><br><br>
                <label for="street">Straße:</label>
                <input type="text" id="street" name="street" required><br><br>
                <label for="house_number">Hausnummer:</label>
                <input type="text" id="house_number" name="house_number"><br><br>
                <label for="city">Stadt:</label>
                <input type="text" id="city" name="city" required><br><br>
                <label for="state">Bundesland:</label>
                <input type="text" id="state" name="state"><br><br>
                <label for="zip">PLZ:</label>
                <input type="number" id="zip" name="zip" required><br><br>
                <label for="country">Land:</label>
                <input type="text" id="country" name="country" required><br><br>
                <label for="isInternal">Zugehörigkeit:</label>
                <select id="isInternal" name="isInternal" required>
                    <option value="1">Intern</option>
                    <option value="0" selected>Extern</option>
                </select><br><br>
                <input type="submit" value="Servicepartner hinzufügen">
            </form>
        </div>

        <div class="form-container">
            <h2>Neuen Kunden hinzufügen</h2>
            <form action="/management/add_customer.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>
                <label for="street">Straße:</label>
                <input type="text" id="street" name="street" required><br><br>
                <label for="house_number">Hausnummer:</label>
                <input type="text" id="house_number" name="house_number"><br><br>
                <label for="city">Stadt:</label>
                <input type="text" id="city" name="city" required><br><br>
                <label for="state">Bundesland:</label>
                <input type="text" id="state" name="state"><br><br>
                <label for="zip">PLZ:</label>
                <input type="text" id="zip" name="zip" required><br><br>
                <label for="country">Land:</label>
                <input type="text" id="country" name="country" required><br><br>
                <label for="telephone_number">Telefonnummer:</label>
                <input type="text" id="telephone_number" name="telephone_number"><br><br>
                <label for="isVip">VIP Status:</label>
                <select id="isVip" name="isVip" required>
                    <option value="1">Ja</option>
                    <option value="0" selected>Nein</option>
                </select><br><br>
                <input type="submit" value="Kunden hinzufügen">
            </form>
        </div>
    </div>
</body>

</html>
