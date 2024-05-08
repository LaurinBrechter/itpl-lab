INSERT INTO `addresses` (`address_id`, `street`, `house_number`, `city`, `state`, `zip`, `country`) VALUES
	(1, 'Harold Green Road', '1', 'Austin', 'Texas', '13101 ', 'USA'),
	(2, 'Emil-Erpel-Straße', '15', 'Entenhausen', NULL, '82837', 'Deutschland'),
	(3, 'August-Schmidt-Straße', '1', 'Dortmund', 'Nordrhein-Westfalen', '44227', 'Deutschland'),
	(4, 'Musterstraße', '123', 'Musterstadt', 'NRW', '12345', 'Deutschland'),
	(5, 'Beispielweg', '456', 'Beispielburg', 'Bayern', '23456', 'Deutschland'),
	(6, 'Demoallee', '789', 'Demostadt', 'Hessen', '34567', 'Deutschland'),
	(7, 'Teststraße', '101', 'Testort', 'Sachsen', '45678', 'Deutschland'),
	(8, 'Straßenstraße', '202', 'Ortsstadt', 'Baden-Württemberg', '56789', 'Deutschland');

INSERT INTO `customers` (`customer_id`, `name`, `address_id`, `telephone_number`, `isVip`) VALUES
	(1, 'Max Mustermann', 1, '+1234567890', 'Yes'),
	(2, 'Erika Musterfrau', 2, '+2147483647', 'No'),
	(3, 'John Doe', 8, '+3456789012', 'No'),
	(4, 'TU Dortmund', 3, '+492317551', 'Yes');

INSERT INTO `orders` (`order_id`, `priority`, `sp_id`, `customer_id`, `status`, `created_at`) VALUES
	(1, 'High', 1, 1, 'PENDING', '2024-05-08 14:35:49'),
	(2, 'Medium', 2, 2, 'COMPLETED', '2024-05-08 14:35:49'),
	(3, 'low', 1, 3, 'CANCELLED', '2024-05-08 14:35:49');

INSERT INTO `order_items` (`item_count_id`, `order_id`, `sku`, `amount`, `created_at`) VALUES
	(1, 1, 60, 3, '2024-05-08 18:41:13'),
	(2, 1, 22, 2, '2024-05-08 18:41:29'),
	(3, 2, 67, 4, '2024-05-08 18:45:35'),
	(4, 3, 59, 3, '2024-05-08 18:47:12'),
	(5, 3, 14, 2, '2024-05-08 18:47:21'),
	(6, 3, 26, 6, '2024-05-08 18:47:28');

INSERT INTO `products` (`sku`, `name`, `price`, `production_duration`, `description`, `created_at`, `storage_amount`) VALUES
	(1, 'Premium Smartphone', 599.99, 2, 'High-end smartphone with cutting-edge features.', '2024-05-07 15:30:01', 44),
	(2, 'Laptop Computer', 999.99, 3, 'Powerful laptop for professional and personal use.', '2024-05-07 15:30:01', 12),
	(3, 'Wireless Headphones', 149.99, 1, 'Sleek and comfortable headphones for immersive audio experience.', '2024-05-07 15:30:01', 29),
	(4, 'Smart Watch', 249.99, 2, 'Fitness tracker and smartwatch with advanced health monitoring features.', '2024-05-07 15:30:01', 11),
	(5, 'Digital Camera', 399.99, 4, 'Professional-grade camera for capturing stunning photos and videos.', '2024-05-07 15:30:01', 68),
	(6, 'Tablet Computer', 349.99, 2, 'Portable device for entertainment and productivity on-the-go.', '2024-05-07 15:30:01', 5),
	(7, 'Gaming Console', 449.99, 3, 'Next-generation gaming console for immersive gaming experiences.', '2024-05-07 15:30:01', 25),
	(8, 'Smart Speaker', 129.99, 1, 'Voice-controlled speaker with smart home integration.', '2024-05-07 15:30:01', 9),
	(9, 'Wireless Router', 79.99, 1, 'High-speed wireless router for seamless internet connectivity.', '2024-05-07 15:30:01', 70),
	(10, 'Fitness Tracker', 79.99, 1, 'Track your activity, exercise, sleep, and more with this fitness tracker.', '2024-05-07 15:30:01', 22),
	(11, 'Bluetooth Earbuds', 99.99, 1, 'Wireless earbuds with long battery life and clear sound quality.', '2024-05-07 15:30:01', 0),
	(12, 'External Hard Drive', 119.99, 1, 'Expand your storage capacity with this reliable external hard drive.', '2024-05-07 15:30:01', 36),
	(13, 'Coffee Maker', 59.99, 1, 'Start your day with a perfect cup of coffee from this programmable coffee maker.', '2024-05-07 15:30:01', 79),
	(14, 'Air Purifier', 199.99, 1, 'Keep the air in your home clean and fresh with this efficient air purifier.', '2024-05-07 15:30:01', 85),
	(15, 'Electric Toothbrush', 39.99, 1, 'Improve your oral health with this advanced electric toothbrush.', '2024-05-07 15:30:01', 90),
	(16, 'Robot Vacuum Cleaner', 299.99, 1, 'Effortlessly clean your floors with this smart robot vacuum cleaner.', '2024-05-07 15:30:01', 93),
	(17, 'Portable Power Bank', 29.99, 1, 'Stay charged on-the-go with this compact and lightweight power bank.', '2024-05-07 15:30:01', 94),
	(18, 'Wireless Charging Pad', 39.99, 1, 'Conveniently charge your devices wirelessly with this charging pad.', '2024-05-07 15:30:01', 91),
	(19, 'LED Desk Lamp', 49.99, 1, 'Illuminate your workspace with this energy-efficient LED desk lamp.', '2024-05-07 15:30:01', 72),
	(20, 'Smart Thermostat', 149.99, 1, 'Control your homes temperature from anywhere with this smart thermostat.', '2024-05-07 15:30:01', 86),
	(21, 'Electric Kettle', 29.99, 1, 'Boil water quickly and efficiently with this electric kettle.', '2024-05-07 15:30:01', 14),
	(22, 'Bluetooth Speaker', 79.99, 1, 'Enjoy your favorite music wirelessly with this portable Bluetooth speaker.', '2024-05-07 15:30:01', 13),
	(23, 'Noise Cancelling Headphones', 199.99, 1, 'Immerse yourself in music without distractions with these noise cancelling headphones.', '2024-05-07 15:30:01', 25),
	(24, 'Digital Picture Frame', 99.99, 1, 'Display your favorite memories with this digital picture frame.', '2024-05-07 15:30:01', 86),
	(25, 'Smart Doorbell', 199.99, 1, 'Enhance your home security with this smart video doorbell.', '2024-05-07 15:30:01', 54),
	(26, 'Action Camera', 199.99, 1, 'Capture your adventures in stunning detail with this action camera.', '2024-05-07 15:30:01', 10),
	(27, 'Wireless Security Camera', 149.99, 1, 'Keep an eye on your home with this wireless security camera.', '2024-05-07 15:30:01', 92),
	(28, 'Smart Lock', 149.99, 1, 'Secure your home with this keyless smart lock.', '2024-05-07 15:30:01', 26),
	(29, 'Compact Refrigerator', 199.99, 1, 'Keep your drinks and snacks cool with this compact refrigerator.', '2024-05-07 15:30:01', 57),
	(30, 'Blender', 39.99, 1, 'Create delicious smoothies and shakes with this powerful blender.', '2024-05-07 15:30:01', 6),
	(31, 'Air Fryer', 79.99, 1, 'Cook your favorite foods with little to no oil using this air fryer.', '2024-05-07 15:30:01', 63),
	(32, 'Rice Cooker', 29.99, 1, 'Cook perfect rice every time with this easy-to-use rice cooker.', '2024-05-07 15:30:01', 92),
	(33, 'Portable Bluetooth Printer', 99.99, 1, 'Print photos and documents on-the-go with this portable Bluetooth printer.', '2024-05-07 15:30:01', 73),
	(34, 'Wireless Mouse', 29.99, 1, 'Navigate your computer with ease using this wireless mouse.', '2024-05-07 15:30:01', 88),
	(35, 'Compact Digital Scale', 19.99, 1, 'Accurately measure ingredients with this compact digital scale.', '2024-05-07 15:30:01', 19),
	(36, 'Stainless Steel Water Bottle', 19.99, 1, 'Stay hydrated on-the-go with this durable stainless steel water bottle.', '2024-05-07 15:30:01', 33),
	(37, 'Travel Pillow', 14.99, 1, 'Rest comfortably during your travels with this ergonomic travel pillow.', '2024-05-07 15:30:01', 6),
	(38, 'UV Sterilizer', 49.99, 1, 'Sanitize your belongings quickly and effectively with this UV sterilizer.', '2024-05-07 15:30:01', 35),
	(39, 'Car Dash Cam', 79.99, 1, 'Record your drives for safety and security with this car dash cam.', '2024-05-07 15:30:01', 55),
	(40, 'Foldable Laptop Stand', 29.99, 1, 'Elevate your laptop for ergonomic typing and viewing with this foldable stand.', '2024-05-07 15:30:01', 69),
	(41, 'Cordless Handheld Vacuum', 79.99, 1, 'Clean up messes quickly and easily with this cordless handheld vacuum.', '2024-05-07 15:30:01', 81),
	(42, 'Wireless Charging Stand', 49.99, 1, 'Charge your phone wirelessly while keeping it upright with this charging stand.', '2024-05-07 15:30:01', 97),
	(43, 'Solar Power Bank', 39.99, 1, 'Charge your devices using renewable energy with this solar power bank.', '2024-05-07 15:30:01', 38),
	(44, 'Memory Foam Mattress Topper', 99.99, 1, 'Upgrade your mattress for added comfort and support with this memory foam topper.', '2024-05-07 15:30:01', 4),
	(45, 'Smart Plug', 19.99, 1, 'Control your devices remotely with this WiFi-enabled smart plug.', '2024-05-07 15:30:01', 5),
	(46, 'Electric Wine Opener', 29.99, 1, 'Open wine bottles effortlessly with this electric wine opener.', '2024-05-07 15:30:01', 15),
	(47, 'Handheld Milk Frother', 19.99, 1, 'Froth milk for lattes and cappuccinos at home with this handheld frother.', '2024-05-07 15:30:01', 61),
	(48, 'Grill Thermometer', 19.99, 1, 'Monitor the temperature of your grill for perfect cooking results with this thermometer.', '2024-05-07 15:30:01', 57),
	(49, 'Adjustable Laptop Stand', 39.99, 1, 'Customize the height and angle of your laptop for comfortable use with this adjustable stand.', '2024-05-07 15:30:01', 0),
	(50, 'Wireless Charging Car Mount', 49.99, 1, 'Charge your phone while driving with this wireless charging car mount.', '2024-05-07 15:30:01', 34),
	(51, 'Fitness Exercise Ball', 19.99, 1, 'Improve your balance, stability, and core strength with this fitness exercise ball.', '2024-05-07 15:30:01', 69),
	(52, 'Digital Alarm Clock', 14.99, 1, 'Wake up on time with this easy-to-use digital alarm clock.', '2024-05-07 15:30:01', 39),
	(53, 'Collapsible Water Bottle', 9.99, 1, 'Stay hydrated on-the-go with this collapsible water bottle.', '2024-05-07 15:30:01', 93),
	(54, 'LED Flashlight', 9.99, 1, 'Illuminate your path with this compact and bright LED flashlight.', '2024-05-07 15:30:01', 44),
	(55, 'Mini Portable Fan', 14.99, 1, 'Stay cool wherever you go with this mini portable fan.', '2024-05-07 15:30:01', 41),
	(56, 'Desktop Organizer', 24.99, 1, 'Keep your desk neat and organized with this desktop organizer.', '2024-05-07 15:30:01', 75),
	(57, 'Reusable Shopping Bags', 14.99, 1, 'Reduce waste and carry groceries with ease using these reusable shopping bags.', '2024-05-07 15:30:01', 51),
	(58, 'Foldable Umbrella', 9.99, 1, 'Stay dry on rainy days with this compact and lightweight foldable umbrella.', '2024-05-07 15:30:01', 30),
	(59, 'Ceramic Mug Set', 19.99, 1, 'Enjoy your favorite beverages in style with this ceramic mug set.', '2024-05-07 15:30:01', 98),
	(60, 'Bluetooth Car Adapter', 24.99, 1, 'Stream music and take calls hands-free in your car with this Bluetooth adapter.', '2024-05-07 15:30:01', 96),
	(61, 'Portable Clothes Steamer', 29.99, 1, 'Remove wrinkles from clothing quickly and easily with this portable clothes steamer.', '2024-05-07 15:30:01', 89),
	(62, 'Mini Projector', 99.99, 1, 'Transform any space into a home theater with this compact mini projector.', '2024-05-07 15:30:01', 54),
	(63, 'Wireless Earbuds Case', 9.99, 1, 'Protect and charge your wireless earbuds with this convenient case.', '2024-05-07 15:30:01', 3),
	(64, 'Kitchen Timer', 9.99, 1, 'Keep track of cooking times with this easy-to-use kitchen timer.', '2024-05-07 15:30:01', 57),
	(65, 'Vegetable Spiralizer', 14.99, 1, 'Create healthy vegetable noodles and ribbons with this spiralizer.', '2024-05-07 15:30:01', 74),
	(66, 'Resistance Bands Set', 29.99, 1, 'Work out anywhere with this set of resistance bands for strength training.', '2024-05-07 15:30:01', 99),
	(67, 'Reusable Silicone Food Bags', 19.99, 1, 'Reduce plastic waste with these reusable silicone food storage bags.', '2024-05-07 15:30:01', 73),
	(68, 'Compact Binoculars', 29.99, 1, 'Explore the outdoors and enjoy sporting events with these compact binoculars.', '2024-05-07 15:30:01', 67),
	(69, 'Stainless Steel Travel Mug', 14.99, 1, 'Keep your beverages hot or cold on-the-go with this stainless steel travel mug.', '2024-05-07 15:30:01', 16),
	(70, 'Phone Stand', 9.99, 1, 'View your phone hands-free in portrait or landscape mode with this versatile phone stand.', '2024-05-07 15:30:01', 81);

INSERT INTO `servicepartners` (`sp_id`, `name`, `tax_number`, `address_id`) VALUES
	(1, 'TechnikService24', '987654321', 7),
	(2, 'ReparaturProfi', '876543219', 8),
	(3, 'Inhouse Reperatur', '273647821', NULL);

