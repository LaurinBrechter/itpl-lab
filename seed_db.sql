INSERT INTO `addresses` (`id`, `street`, `house_number`, `city`, `state`, `zip`, `country`) VALUES
	(1, 'Harold Green Road', '1', 'Austin', 'Texas', '13101 ', 'USA'),
	(2, 'Emil-Erpel-Straße', '15', 'Entenhausen', NULL, '82837', 'Deutschland'),
	(3, 'August-Schmidt-Straße', '1', 'Dortmund', 'Nordrhein-Westfalen', '44227', 'Deutschland'),
	(4, 'Musterstraße', '123', 'Musterstadt', 'NRW', '12345', 'Deutschland'),
	(5, 'Beispielweg', '456', 'Beispielburg', 'Bayern', '23456', 'Deutschland'),
	(6, 'Demoallee', '789', 'Demostadt', 'Hessen', '34567', 'Deutschland'),
	(7, 'Lagerstraße ', '101', 'Testort', 'Sachsen', '45678', 'Deutschland'),
	(8, 'Lagerstraße', '202', 'Ortsstadt', 'Baden-Württemberg', '56789', 'Deutschland'),
	(9, 'Pine Street', '10', 'Munich', 'Bayern', '80331', 'Deutschland'),
	(10, 'Maple Street', '15', 'Berlin', 'Berlin', '10115', 'Deutschland'),
	(11, 'Oak Street', '20', 'Frankfurt', 'Hessen', '60311', 'Deutschland'),
	(12, 'Elm Street', '25', 'Stuttgart', 'Baden-Württemberg', '70173', 'Deutschland'),
	(13, 'Cedar Street', '30', 'Hamburg', 'Hamburg', '20095', 'Deutschland'),
	(14, 'Birch Street', '35', 'Leipzig', 'Sachsen', '04109', 'Deutschland'),
	(15, 'Walnut Street', '40', 'Dresden', 'Sachsen', '01067', 'Deutschland'),
	(16, 'Cherry Street', '45', 'Hannover', 'Niedersachsen', '30159', 'Deutschland'),
	(17, 'Ash Street', '50', 'Nürnberg', 'Bayern', '90402', 'Deutschland'),
	(18, 'Alder Street', '55', 'Düsseldorf', 'NRW', '40210', 'Deutschland'),
	(19, 'Spruce Street', '60', 'Bremen', 'Bremen', '28195', 'Deutschland'),
	(20, 'Beech Street', '65', 'Bonn', 'NRW', '53111', 'Deutschland'),
	(21, 'Sycamore Street', '70', 'Mainz', 'Rheinland-Pfalz', '55116', 'Deutschland'),
	(22, 'Magnolia Street', '75', 'Wiesbaden', 'Hessen', '65183', 'Deutschland'),
	(23, 'Willow Street', '80', 'Kiel', 'Schleswig-Holstein', '24103', 'Deutschland'),
	(24, 'Poplar Street', '85', 'Freiburg', 'Baden-Württemberg', '79098', 'Deutschland'),
	(25, 'Hickory Street', '90', 'Rostock', 'Mecklenburg-Vorpommern', '18055', 'Deutschland'),
	(26, 'Dogwood Street', '95', 'Lübeck', 'Schleswig-Holstein', '23552', 'Deutschland'),
	(27, 'Maple Avenue', '100', 'Koblenz', 'Rheinland-Pfalz', '56068', 'Deutschland'),
	(28, 'Pine Avenue', '105', 'Erfurt', 'Thüringen', '99084', 'Deutschland'),
	(29, 'Produktionsstraße', '1', 'Dortmund', NULL, '44221', 'Deutschland'),
	(30, 'Produktionsstraße', '68', 'Dortmund', NULL, '44221', 'Deutschland'),
	(31, 'Firmensitzstraße', '1', 'Essen', NULL, '45138', 'Deutschland');

INSERT INTO `customers` (`id`, `name`, `address_id`, `telephone_number`, `isVip`) VALUES
	(1, 'Max Mustermann', 1, '+1234567890', 1),
	(2, 'Erika Musterfrau', 2, '+2147483647', 0),
	(3, 'John Doe', 8, '+3456789012', 0),
	(4, 'TU Dortmund', 3, '+492317551', 1),
	(5, 'Julia Schneider', 9, '+491234567890', 0),
	(6, 'Hans Müller', 10, '+491239876543', 1),
	(7, 'Sara Smith', 11, '+491235555555', 0),
	(8, 'Michael Johnson', 12, '+491234444444', 0),
	(9, 'Claire Dubois', 13, '+491233333333', 1),
	(10, 'Alicia Sanchez', 14, '+491232222222', 0),
	(11, 'Yuki Tanaka', 15, '+491231111111', 0),
	(12, 'Luca Rossi', 16, '+491239999999', 1),
	(13, 'Emma Williams', 17, '+491238888888', 0),
	(14, 'Oliver Jones', 18, '+491237777777', 0),
	(15, 'Mia Taylor', 19, '+491236666666', 1),
	(16, 'Noah Wilson', 20, '+491235555555', 0),
	(17, 'Sophia Brown', 21, '+491234444444', 0),
	(18, 'Liam Davis', 22, '+491233333333', 1),
	(19, 'Isabella Martinez', 23, '+491232222222', 0),
	(20, 'Ethan Lopez', 24, '+491231111111', 0),
	(21, 'Amelia Gonzalez', 25, '+491239999999', 1),
	(22, 'Jacob White', 26, '+491238888888', 0),
	(23, 'Charlotte Harris', 27, '+491237777777', 0),
	(24, 'William Clark', 28, '+491236666666', 1);

INSERT INTO `service_partners` (`id`, `name`, `tax_number`, `address_id`, `isInternal`, user_id) VALUES
    (1, 'TechnikService24', '987654321', 7, 0, 1),
    (2, 'ReparaturProfi', '876543219', 8, 0, 2),
    (3, 'Borat Sagdiyev', '', 31, 1, 3),
    (4, 'Adam Sandler', '', 31, 1, 4),
    (5, 'Johnny Smart', '', 31, 1, 5),
    (6, 'GadgetSOS GmbH', 'DE374638306', 20, 0, 6),
    (7, 'Innovative Reparaturen GmbH', 'DE274638305', 19, 0, 7),
    (8, 'ElektronikFix GmbH', 'DE123456789', 1, 0, 8),
    (9, 'TechSupport Plus', 'DE987654321', 2, 0, 9),
    (10, 'ReparaturMeister GmbH', 'DE192837465', 3, 0, 10),
    (11, 'HausTechnik Solutions', 'DE564738291', 4, 0, 11),
    (12, 'ComputerHilfe Schnell', 'DE665738291', 5, 0, 12),
    (13, 'HandyReparatur Blitz', 'DE764738292', 6, 0, 13),
    (14, 'GadgetRepair KG', 'DE864738293', 7, 0, 14),
    (15, 'ServicePlus AG', 'DE964738294', 8, 0, 15),
    (16, 'TechnologieHilfe GmbH', 'DE174738295', 9, 0, 16),
    (17, 'MobileAssist GmbH', 'DE274738296', 10, 0, 17),
    (18, 'ElektroProfi24', 'DE374738297', 11, 0, 18),
    (19, 'SmartHome Reparaturen', 'DE474738298', 12, 0, 19),
    (20, 'ITSupport 360', 'DE574738299', 13, 0, 20),
    (21, 'GeräteService 24/7', 'DE674738300', 14, 0, 21),
    (22, 'NetzwerkProfis GmbH', 'DE774738301', 15, 0, 22),
    (23, 'PCReparatur Zentrum', 'DE874738302', 16, 0, 23),
    (24, 'TechnikSupport Team', 'DE974738303', 17, 0, 24),
    (25, 'Elektro Notdienst', 'DE174638304', 18, 0, 25);


INSERT INTO users (id, username, password, role) VALUES
    (1, 'TechnikService24', null, 'SERVICE_PARTNER'),
    (2, 'ReparaturProfi', null, 'SERVICE_PARTNER'),
    (3, 'borat', null, 'SERVICE_PARTNER'),
    (4, 'adam', null, 'SERVICE_PARTNER'),
    (5, 'johnny', null, 'SERVICE_PARTNER'),
    (6, 'gadgetsos', null, 'SERVICE_PARTNER'),
    (7, 'innovative', null, 'SERVICE_PARTNER'),
    (8, 'elektronikfix', null, 'SERVICE_PARTNER'),
    (9, 'techsupport', null, 'SERVICE_PARTNER'),
    (10, 'reparaturmeister', null, 'SERVICE_PARTNER'),
    (11, 'haustechnik', null, 'SERVICE_PARTNER'),
    (12, 'computerhilfe', null, 'SERVICE_PARTNER'),
    (13, 'handyreparatur', null, 'SERVICE_PARTNER'),
    (14, 'gadgetrepair', null, 'SERVICE_PARTNER'),
    (15, 'serviceplus', null, 'SERVICE_PARTNER'),
    (16, 'technologiehilfe', null, 'SERVICE_PARTNER'),
    (17, 'mobileassist', null, 'SERVICE_PARTNER'),
    (18, 'elektroprofi', null, 'SERVICE_PARTNER'),
    (19, 'smarthome', null, 'SERVICE_PARTNER'),
    (20, 'itsupport', null, 'SERVICE_PARTNER'),
    (21, 'gerateservice', null, 'SERVICE_PARTNER'),
    (22, 'netzwerkprofis', null, 'SERVICE_PARTNER'),
    (23, 'pcreparatur', null, 'SERVICE_PARTNER'),
    (24, 'techniksupport', null, 'SERVICE_PARTNER'),
    (25, 'elektronotdienst', null, 'SERVICE_PARTNER'),
    (26, 'storage1', null, 'STORAGE'),
    (27, 'storage2', null, 'STORAGE'),
    (28, 'production1', null, 'PRODUCTION'),
    (29, 'production2', null, 'PRODUCTION');
	(30, 'Manager', NULL, 'MANAGEMENT');

	


INSERT INTO `orders` (`id`, `priority`, `sp_id`, `customer_id`, `status`, `created_at`) VALUES
	(1, 'High', 1, 1, 'PENDING', '2024-05-08 14:35:49'),
	(2, 'Medium', 2, 2, 'COMPLETED', '2024-05-08 14:35:49'),
	(3, 'low', 1, 3, 'CANCELLED', '2024-05-08 14:35:49'),
	(4, 'High', 1, 9, 'PENDING', '2024-05-09 10:00:00'),
	(5, 'Medium', 2, 10, 'COMPLETED', '2024-05-09 10:10:00'),
	(6, 'low', 1, 11, 'CANCELLED', '2024-05-09 10:20:00'),
	(7, 'High', 1, 12, 'PENDING', '2024-05-09 10:30:00'),
	(8, 'Medium', 2, 13, 'COMPLETED', '2024-05-09 10:40:00'),
	(9, 'low', 1, 14, 'CANCELLED', '2024-05-09 10:50:00'),
	(10, 'High', 1, 15, 'PENDING', '2024-05-09 11:00:00'),
	(11, 'Medium', 2, 16, 'COMPLETED', '2024-05-09 11:10:00'),
	(12, 'low', 1, 17, 'CANCELLED', '2024-05-09 11:20:00'),
	(13, 'High', 1, 18, 'PENDING', '2024-05-09 11:30:00'),
	(14, 'Medium', 2, 19, 'COMPLETED', '2024-05-09 11:40:00'),
	(15, 'low', 1, 20, 'CANCELLED', '2024-05-09 11:50:00'),
	(16, 'High', 1, 21, 'PENDING', '2024-05-09 12:00:00'),
	(17, 'Medium', 2, 22, 'COMPLETED', '2024-05-09 12:10:00'),
	(18, 'low', 1, 23, 'CANCELLED', '2024-05-09 12:20:00');

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `amount`, `created_at`) VALUES
	(1, 1, 60, 3, '2024-05-08 18:41:13'),
	(2, 1, 22, 2, '2024-05-08 18:41:29'),
	(3, 2, 67, 4, '2024-05-08 18:45:35'),
	(4, 3, 59, 3, '2024-05-08 18:47:12'),
	(5, 3, 14, 2, '2024-05-08 18:47:21'),
	(6, 3, 26, 6, '2024-05-08 18:47:28'),
	(7, 4, 1, 2, '2024-05-09 10:45:00'),
	(8, 4, 7, 1, '2024-05-09 10:45:05'),
	(9, 5, 8, 1, '2024-05-09 10:55:00'),
	(10, 5, 9, 1, '2024-05-09 10:55:05'),
	(11, 6, 10, 2, '2024-05-09 11:05:00'),
	(12, 6, 11, 1, '2024-05-09 11:05:05'),
	(13, 7, 12, 1, '2024-05-09 11:15:00'),
	(14, 7, 13, 2, '2024-05-09 11:15:05'),
	(15, 8, 14, 3, '2024-05-09 11:25:00'),
	(16, 8, 15, 1, '2024-05-09 11:25:05'),
	(17, 9, 16, 2, '2024-05-09 11:35:00'),
	(18, 9, 17, 1, '2024-05-09 11:35:05'),
	(19, 10, 18, 1, '2024-05-09 11:45:00'),
	(20, 10, 19, 2, '2024-05-09 11:45:05'),
	(21, 11, 20, 2, '2024-05-09 11:55:00'),
	(22, 11, 21, 3, '2024-05-09 11:55:05'),
	(23, 12, 22, 1, '2024-05-09 12:05:00'),
	(24, 12, 23, 2, '2024-05-09 12:05:05'),
	(25, 13, 24, 1, '2024-05-09 12:15:00'),
	(26, 13, 25, 1, '2024-05-09 12:15:05'),
	(27, 14, 26, 2, '2024-05-09 12:25:00'),
	(28, 14, 27, 3, '2024-05-09 12:25:05'),
	(29, 15, 28, 1, '2024-05-09 12:35:00'),
	(30, 15, 29, 2, '2024-05-09 12:35:05'),
	(31, 16, 30, 2, '2024-05-09 12:45:00'),
	(32, 16, 31, 1, '2024-05-09 12:45:05'),
	(33, 17, 32, 1, '2024-05-09 12:55:00'),
	(34, 17, 33, 3, '2024-05-09 12:55:05'),
	(35, 18, 34, 2, '2024-05-09 13:05:00'),
	(36, 18, 35, 2, '2024-05-09 13:05:05');

INSERT INTO `production_facilities` (`id`, `address_id`, user_id) VALUES
	(1, 29, 28),
	(2, 30, 29);

INSERT INTO products (name, category, price, production_duration, description, storage_amount) VALUES
('Luft-Wasser-Wärmepumpe LW-200', 'Wärmepumpen', 3500.00, 30, 'Hocheffiziente Luft-Wasser-Wärmepumpe mit 20 kW Heizleistung', 10),
('Luft-Wasser-Wärmepumpe LW-300', 'Wärmepumpen', 4800.00, 45, 'Luft-Wasser-Wärmepumpe mit 30 kW Heizleistung', 8),
('Wasser-Wasser-Wärmepumpe WW-150', 'Wärmepumpen', 4200.00, 40, 'Wasser-Wasser-Wärmepumpe mit 15 kW Heizleistung', 6),
('Wasser-Wasser-Wärmepumpe WW-250', 'Wärmepumpen', 5500.00, 50, 'Wasser-Wasser-Wärmepumpe mit 25 kW Heizleistung', 5),
('Gasheizung GH-100', 'Gasheizungen', 2000.00, 20, 'Gasheizung mit 10 kW Heizleistung', 15),
('Gasheizung GH-200', 'Gasheizungen', 3000.00, 30, 'Gasheizung mit 20 kW Heizleistung', 12),
('Elektroheizung EH-50', 'Elektroheizungen', 1500.00, 10, 'Elektroheizung mit 5 kW Heizleistung', 20),
('Elektroheizung EH-100', 'Elektroheizungen', 2500.00, 15, 'Elektroheizung mit 10 kW Heizleistung', 18),
('Luftleitsystem LS-200', 'Luftleitsysteme', 1200.00, 25, 'Modulares Luftleitsystem für Bürogebäude', 25),
('Luftleitsystem LS-300', 'Luftleitsysteme', 1800.00, 35, 'Luftleitsystem mit integriertem Filtersystem', 22),
('Wasserleitsystem WS-100', 'Wasserleitsysteme', 1600.00, 20, 'Wasserleitsystem für industrielle Anwendungen', 10),
('Wasserleitsystem WS-200', 'Wasserleitsysteme', 2200.00, 30, 'Erweitertes Wasserleitsystem mit hoher Kapazität', 8),
('Steuerungssystem SS-100', 'Steuerungen', 800.00, 10, 'Basissteuerungssystem für Heizungsanlagen', 30),
('Steuerungssystem SS-200', 'Steuerungen', 1400.00, 20, 'Erweitertes Steuerungssystem mit Fernzugriff', 25),
('Ersatzfilter EF-50', 'Zubehör', 100.00, 5, 'Ersatzfilter für Luftleitsysteme', 50),
('Ersatzfilter EF-100', 'Zubehör', 180.00, 5, 'Ersatzfilter für erweiterte Luftleitsysteme', 40),
('Thermostat TH-50', 'Zubehör', 60.00, 2, 'Basis-Thermostat für Heizungsanlagen', 70),
('Thermostat TH-100', 'Zubehör', 120.00, 5, 'Programmierbares Thermostat mit WiFi', 60),
('Luft-Wasser-Wärmepumpe LW-400', 'Wärmepumpen', 6500.00, 60, 'Luft-Wasser-Wärmepumpe mit 40 kW Heizleistung', 4),
('Wasser-Wasser-Wärmepumpe WW-350', 'Wärmepumpen', 7200.00, 65, 'Wasser-Wasser-Wärmepumpe mit 35 kW Heizleistung', 3),
('Gasheizung GH-300', 'Gasheizungen', 4000.00, 35, 'Gasheizung mit 30 kW Heizleistung', 10),
('Elektroheizung EH-150', 'Elektroheizungen', 3200.00, 20, 'Elektroheizung mit 15 kW Heizleistung', 15),
('Luftleitsystem LS-400', 'Luftleitsysteme', 2500.00, 45, 'Komplexes Luftleitsystem für große Gebäude', 15),
('Wasserleitsystem WS-300', 'Wasserleitsysteme', 2800.00, 40, 'Industrielles Wasserleitsystem mit hoher Effizienz', 7),
('Steuerungssystem SS-300', 'Steuerungen', 2000.00, 30, 'Fortschrittliches Steuerungssystem mit App-Unterstützung', 20),
('Luftfilter LF-50', 'Zubehör', 50.00, 3, 'Luftfilter für kleinere Anlagen', 80),
('Luftfilter LF-100', 'Zubehör', 90.00, 3, 'Luftfilter für mittlere Anlagen', 70),
('Wasserfilter WF-50', 'Zubehör', 70.00, 4, 'Wasserfilter für kleine bis mittlere Anlagen', 60),
('Wasserfilter WF-100', 'Zubehör', 130.00, 5, 'Wasserfilter für große Anlagen', 50),
('Luft-Wasser-Wärmepumpe LW-500', 'Wärmepumpen', 7800.00, 70, 'Hochleistungs-Luft-Wasser-Wärmepumpe mit 50 kW Heizleistung', 3),
('Wasser-Wasser-Wärmepumpe WW-400', 'Wärmepumpen', 8500.00, 75, 'Premium Wasser-Wasser-Wärmepumpe mit 40 kW Heizleistung', 2),
('Gasheizung GH-400', 'Gasheizungen', 5000.00, 40, 'Gasheizung mit 40 kW Heizleistung', 8),
('Elektroheizung EH-200', 'Elektroheizungen', 4000.00, 25, 'Elektroheizung mit 20 kW Heizleistung', 12),
('Luftleitsystem LS-500', 'Luftleitsysteme', 3200.00, 55, 'Premium Luftleitsystem für höchste Anforderungen', 10),
('Wasserleitsystem WS-400', 'Wasserleitsysteme', 3400.00, 50, 'Hochleistungs-Wasserleitsystem für Industriebetriebe', 5),
('Steuerungssystem SS-400', 'Steuerungen', 2500.00, 35, 'Premium Steuerungssystem mit erweiterten Funktionen', 18),
('Ventilator V-50', 'Zubehör', 150.00, 5, 'Leistungsstarker Ventilator für Klimaanlagen', 40),
('Ventilator V-100', 'Zubehör', 280.00, 7, 'Hocheffizienter Ventilator für große Anlagen', 30),
('Kühlmittel KM-10', 'Zubehör', 50.00, 1, 'Standard Kühlmittel für Wärmepumpen', 100),
('Kühlmittel KM-20', 'Zubehör', 90.00, 1, 'Premium Kühlmittel für hohe Effizienz', 80),
('Luft-Wasser-Wärmepumpe LW-600', 'Wärmepumpen', 9200.00, 80, 'Industrie-Luft-Wasser-Wärmepumpe mit 60 kW Heizleistung', 2),
('Wasser-Wasser-Wärmepumpe WW-500', 'Wärmepumpen', 10000.00, 85, 'Hocheffiziente Wasser-Wasser-Wärmepumpe mit 50 kW Heizleistung', 1),
('Gasheizung GH-500', 'Gasheizungen', 6000.00, 50, 'Industrie-Gasheizung mit 50 kW Heizleistung', 6),
('Elektroheizung EH-250', 'Elektroheizungen', 4800.00, 30, 'Hochleistungs-Elektroheizung mit 25 kW Heizleistung', 10),
('Luftleitsystem LS-600', 'Luftleitsysteme', 4000.00, 65, 'Hochkomplexes Luftleitsystem für große Industrieanlagen', 8),
('Wasserleitsystem WS-500', 'Wasserleitsysteme', 4000.00, 60, 'Erweitertes Wasserleitsystem für höchste Anforderungen', 4),
('Steuerungssystem SS-500', 'Steuerungen', 3000.00, 40, 'High-End Steuerungssystem mit Cloud-Anbindung', 15),
('Feuchtigkeitssensor FS-50', 'Zubehör', 80.00, 2, 'Feuchtigkeitssensor für Klimaanlagen', 70),
('Feuchtigkeitssensor FS-100', 'Zubehör', 150.00, 3, 'Präziser Feuchtigkeitssensor für große Systeme', 60),
('Temperatursensor TS-50', 'Zubehör', 60.00, 2, 'Temperatursensor für Heizungsanlagen', 80),
('Temperatursensor TS-100', 'Zubehör', 120.00, 3, 'Hochpräziser Temperatursensor für komplexe Systeme', 70);



INSERT INTO `storage_logs` (`product_id`, `order_id`, `amount`, `detail`)
VALUES
    (1, NULL, 44, 'PRODUCTION_IN'),
    (2, NULL, 12, 'PRODUCTION_IN'),
    (3, NULL, 29, 'PRODUCTION_IN'),
    (4, NULL, 11, 'PRODUCTION_IN'),
    (5, NULL, 68, 'PRODUCTION_IN'),
    (6, NULL, 5, 'PRODUCTION_IN'),
    (7, NULL, 25, 'PRODUCTION_IN'),
    (8, NULL, 9, 'PRODUCTION_IN'),
    (9, NULL, 70, 'PRODUCTION_IN'),
    (10, NULL, 22, 'PRODUCTION_IN'),
    (11, NULL, 0, 'PRODUCTION_IN'),
    (12, NULL, 36, 'PRODUCTION_IN'),
    (13, NULL, 79, 'PRODUCTION_IN'),
    (14, NULL, 85, 'PRODUCTION_IN'),
    (15, NULL, 90, 'PRODUCTION_IN'),
    (16, NULL, 93, 'PRODUCTION_IN'),
    (17, NULL, 94, 'PRODUCTION_IN'),
    (18, NULL, 91, 'PRODUCTION_IN'),
    (19, NULL, 72, 'PRODUCTION_IN'),
    (20, NULL, 86, 'PRODUCTION_IN'),
    (21, NULL, 14, 'PRODUCTION_IN'),
    (22, NULL, 13, 'PRODUCTION_IN'),
    (23, NULL, 25, 'PRODUCTION_IN'),
    (24, NULL, 86, 'PRODUCTION_IN'),
    (25, NULL, 54, 'PRODUCTION_IN'),
    (26, NULL, 10, 'PRODUCTION_IN'),
    (27, NULL, 92, 'PRODUCTION_IN'),
    (28, NULL, 26, 'PRODUCTION_IN'),
    (29, NULL, 57, 'PRODUCTION_IN'),
    (30, NULL, 6, 'PRODUCTION_IN'),
    (31, NULL, 63, 'PRODUCTION_IN'),
    (32, NULL, 92, 'PRODUCTION_IN'),
    (33, NULL, 73, 'PRODUCTION_IN'),
    (34, NULL, 88, 'PRODUCTION_IN'),
    (35, NULL, 19, 'PRODUCTION_IN'),
    (36, NULL, 33, 'PRODUCTION_IN'),
    (37, NULL, 6, 'PRODUCTION_IN'),
    (38, NULL, 35, 'PRODUCTION_IN'),
    (39, NULL, 55, 'PRODUCTION_IN'),
    (40, NULL, 69, 'PRODUCTION_IN'),
    (41, NULL, 81, 'PRODUCTION_IN'),
    (42, NULL, 97, 'PRODUCTION_IN'),
    (43, NULL, 38, 'PRODUCTION_IN'),
    (44, NULL, 4, 'PRODUCTION_IN'),
    (45, NULL, 5, 'PRODUCTION_IN'),
    (46, NULL, 15, 'PRODUCTION_IN'),
    (47, NULL, 61, 'PRODUCTION_IN'),
    (48, NULL, 57, 'PRODUCTION_IN'),
    (49, NULL, 0, 'PRODUCTION_IN'),
    (50, NULL, 34, 'PRODUCTION_IN'),
    (51, NULL, 69, 'PRODUCTION_IN'),
    (52, NULL, 39, 'PRODUCTION_IN'),
    (53, NULL, 93, 'PRODUCTION_IN'),
    (54, NULL, 44, 'PRODUCTION_IN'),
    (55, NULL, 41, 'PRODUCTION_IN'),
    (56, NULL, 75, 'PRODUCTION_IN'),
    (57, NULL, 51, 'PRODUCTION_IN'),
    (58, NULL, 30, 'PRODUCTION_IN'),
    (59, NULL, 98, 'PRODUCTION_IN'),
    (60, NULL, 96, 'PRODUCTION_IN'),
    (61, NULL, 89, 'PRODUCTION_IN'),
    (62, NULL, 54, 'PRODUCTION_IN'),
    (63, NULL, 3, 'PRODUCTION_IN'),
    (64, NULL, 57, 'PRODUCTION_IN'),
    (65, NULL, 74, 'PRODUCTION_IN'),
    (66, NULL, 99, 'PRODUCTION_IN'),
    (67, NULL, 73, 'PRODUCTION_IN'),
    (68, NULL, 67, 'PRODUCTION_IN'),
    (69, NULL, 16, 'PRODUCTION_IN'),
    (70, NULL, 81, 'PRODUCTION_IN');

-- update storage_id of storage_logs to be a random integer between 1 and 2
UPDATE storage_logs SET storage_id = FLOOR(RAND() * 2) + 1;


INSERT INTO `storage_facilities` (`id`, `address_id`, user_id) VALUES
	(1, 7, 26),
	(2, 8, 27);

