<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Übersicht der Daten</title>
    <style>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; 
	include $_SERVER['DOCUMENT_ROOT'] . '/database.php';?>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php'; ?>
    <h1>Übersicht der Kunden und Servicepartner</h1>

    <h2>Kunden</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Adresse</th>
            <th>Telefonnummer</th>
            <th>VIP Status</th>
            <th>Aktionen</th>
        </tr>
        <?php
        // Verbindung zur Datenbank herstellen
        $conn = new mysqli("localhost", "your_username", "your_password", "your_database_name");
        if ($conn->connect_error) {
            die("Verbindung fehlgeschlagen: " . $conn->connect_error);
        }

        // Kunden abfragen
        $sql = "SELECT customers.customer_id, customers.name, addresses.street, customers.telephone_number, customers.isVip FROM customers JOIN addresses ON customers.address_id = addresses.address_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Daten der einzelnen Reihen ausgeben
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["street"] . "</td>
                        <td>" . $row["telephone_number"] . "</td>
                        <td>" . ($row["isVip"] ? 'Ja' : 'Nein') . "</td>
                        <td><a href='edit_customer.php?id=" . $row["customer_id"] . "'>Bearbeiten</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Keine Daten gefunden</td></tr>";
        }
        ?>
    </table>

    <h2>Servicepartner</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Steuernummer</th>
            <th>Adresse</th>
            <th>Intern</th>
            <th>Aktionen</th>
        </tr>
        <?php
        // Servicepartner abfragen
        $sql = "SELECT servicepartners.sp_id, servicepartners.name, servicepartners.tax_number, addresses.street, servicepartners.isInternal FROM servicepartners JOIN addresses ON servicepartners.address_id = addresses.address_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Daten der einzelnen Reihen ausgeben
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["tax_number"] . "</td>
                        <td>" . $row["street"] . "</td>
                        <td>" . ($row["isInternal"] ? 'Ja' : 'Nein') . "</td>
                        <td><a href='edit_servicepartner.php?id=" . $row["sp_id"] . "'>Bearbeiten</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Keine Daten gefunden</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
