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

/* exercise 5 - check if we want cities e.g. world.php?country=Jamaica&lookup=cities */
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : "";

if ($lookup === "cities") {

    /* exercise 5 - join cities and countries so we can find cities using the country name */
    /* c is short for cities and cs is short for countries */
    $stmt = $conn->prepare("SELECT c.name, c.district, c.population
                            FROM cities c
                            JOIN countries cs ON c.country_code = cs.code
                            WHERE cs.name LIKE :country");
} else {

    /* only get countries with the search text in the name - LIKE lets "Jam" find "Jamaica" */
    /* prepare and execute keeps the search safe from sql injection */
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
}

$stmt->execute(['country' => "%$country%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if ($lookup === "cities"): ?>
<!-- exercise 5 - show the cities in a table with name, district and population -->
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>District</th>
      <th>Population</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($results as $row): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']); ?></td>
      <td><?= htmlspecialchars($row['district']); ?></td>
      <td><?= htmlspecialchars($row['population']); ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php else: ?>
<!-- exercise 4 - show the countries in a table instead of a list -->
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Continent</th>
      <th>Independence</th>
      <th>Head of State</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($results as $row): ?>
    <!-- one row for each country - htmlspecialchars turns things like < > into safe text -->
    <!-- ?? '' is used because some countries have no independence year or head of state -->
    <tr>
      <td><?= htmlspecialchars($row['name']); ?></td>
      <td><?= htmlspecialchars($row['continent']); ?></td>
      <td><?= htmlspecialchars($row['independence_year'] ?? ''); ?></td>
      <td><?= htmlspecialchars($row['head_of_state'] ?? ''); ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
