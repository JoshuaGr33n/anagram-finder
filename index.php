<?php
session_start(); // Start the session

// Check for results in the session
$anagramGroups = [];
if (isset($_SESSION['anagramGroups'])) {
    $anagramGroups = $_SESSION['anagramGroups'];
    unset($_SESSION['anagramGroups']); // Clear the session variable after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anagram Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Anagram Finder</h1>
    <form action="anagramFinder.php" method="POST" enctype="multipart/form-data">
        <label for="file">Upload Dictionary File (.txt):</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Find Anagrams</button>
    </form>
    
    <?php
    // Display the results if there are any anagram groups
    if (!empty($anagramGroups)) {
        echo "<h2>Anagrams:</h2>";
        echo "<table>";
        echo "<tr><th>Count</th><th>Anagrams</th></tr>"; 

        foreach ($anagramGroups as $anagrams) {
            if (count($anagrams) > 1) { // Only show groups with more than one anagram
                $count = count($anagrams);
                // Apply htmlspecialchars to each anagram as a safe list
                $safeAnagrams = array_map('htmlspecialchars', $anagrams);
                echo "<tr><td>$count</td><td>" . implode(", ", $safeAnagrams) . "</td></tr>";
            }
        }

        echo "</table>";
    } else {
        echo "<h3>No anagrams found.</h3>";
    }
    ?>
</body>
</html>
