<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Management Dashboard</title>
	<style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>
<body>
    <h1>Neuen Servicepartner hinzufügen</h1>
    <form action="add_servicepartner.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="tax_number">Steuernummer:</label>
        <input type="text" id="tax_number" name="tax_number"><br><br>
        <label for="address_id">Address ID:</label>
        <input type="number" id="address_id" name="address_id" required><br><br>
        <label for="isInternal">Intern (1=Ja, 0=Nein):</label>
        <input type="number" id="isInternal" name="isInternal" required><br><br>
        <input type="submit" value="Servicepartner hinzufügen">
    </form>

    <h1>Neuen Kunden hinzufügen</h1>
    <form action="add_customer.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="address_id">Address ID:</label>
        <input type="number" id="address_id" name="address_id" required><br><br>
        <label for="telephone_number">Telefonnummer:</label>
        <input type="text" id="telephone_number" name="telephone_number"><br><br>
        <label for="isVip">VIP Status (1=Ja, 0=Nein):</label>
        <input type="number" id="isVip" name="isVip" required><br><br>
        <input type="submit" value="Kunden hinzufügen">
    </form>
</body>
</html>
