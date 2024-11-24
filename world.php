<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Establish connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if ($lookup === 'cities') {
        // Fetch cities in the country
        $stmt = $pdo->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
        ");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1' style='width:100%; border-collapse:collapse; text-align:left;'>";
            echo "<thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                echo "<td>" . htmlspecialchars($row['population']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No cities found for this country.</p>";
        }
    } else {
        // Fetch country information
        $stmt = $pdo->prepare("
            SELECT name, continent, independence_year, head_of_state 
            FROM countries 
            WHERE name LIKE :country
        ");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1' style='width:100%; border-collapse:collapse; text-align:left;'>";
            echo "<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
                echo "<td>" . ($row['independence_year'] ? htmlspecialchars($row['independence_year']) : "N/A") . "</td>";
                echo "<td>" . ($row['head_of_state'] ? htmlspecialchars($row['head_of_state']) : "N/A") . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No countries found matching your query.</p>";
        }
    }
} catch (Exception $e) {
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
