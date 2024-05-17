<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Übersicht der Daten</title>
    <style>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/style.css';
        ?>
        /* table {
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
        } */
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php'; 
	include $_SERVER['DOCUMENT_ROOT'] . '/database.php';?>
    <h1>Übersicht der Kunden und Servicepartner</h1>

    <h2>Kunden</h2>
    <div class="table-container">
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Adresse</th>
            <th>Telefonnummer</th>
            <th>VIP Status</th>
            <th>Aktionen</th>
        </tr>
        </thead>
        <tbody>
        <?php
// Kunden abfragen
        $sql = "SELECT customers.id AS customer_id, customers.name, addresses.street, addresses.house_number, addresses.city, customers.telephone_number, customers.isVip 
                FROM customers 
                LEFT JOIN addresses ON customers.address_id = addresses.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Daten der einzelnen Reihen ausgeben
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["street"] . " " . $row["house_number"] . ", " . $row["city"] . "</td>
                        <td>" . $row["telephone_number"] . "</td>
                        <td>" . ($row["isVip"] ? 'Ja' : 'Nein') . "</td>
                        <td><a href='edit_customer.php?id=" . $row["customer_id"] . "'>Bearbeiten</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Keine Daten gefunden</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>

    <h2>Servicepartner</h2>
    <div class="table-container">
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Steuernummer</th>
            <th>Adresse</th>
            <th>Intern</th>
            <th>Aktionen</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Servicepartner abfragen
        $sql = "SELECT service_partners.id AS sp_id, service_partners.name, service_partners.tax_number, addresses.street, addresses.house_number, addresses.city, service_partners.isInternal 
                FROM service_partners 
                LEFT JOIN addresses ON service_partners.address_id = addresses.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Daten der einzelnen Reihen ausgeben
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["tax_number"] . "</td>
                        <td>" . $row["street"] . " " . $row["house_number"] . ", " . $row["city"] . "</td>
                        <td>" . ($row["isInternal"] ? 'Ja' : 'Nein') . "</td>
                        <td><a href='edit_servicepartner.php?id=" . $row["sp_id"] . "'>Bearbeiten</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Keine Daten gefunden</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
    </div>
</body>
</html>
