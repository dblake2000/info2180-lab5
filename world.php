<?php
$host = 'localhost';
$username = 'lab5_user';
/* exercise 2 - password for the lab5_user we made in phpmyadmin */
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

/* exercise 3 - get the country from the url e.g. world.php?country=Jamaica */
/* if there is no country in the url use an empty string - this returns all countries */
$country = isset($_GET['country']) ? trim($_GET['country']) : "";

/* only get countries with the search text in the name - LIKE lets "Jam" find "Jamaica" */
/* prepare and execute keeps the search safe from sql injection */
$stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
$stmt->execute(['country' => "%$country%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
