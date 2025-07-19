<?php
echo "<h1>Installation Script</h1>";

// Include the schema update script
echo "<p>Setting up the database schema...</p>";
include 'update_schema.php';

echo "<p>Installation complete.</p>";
echo '<p><a href="index.php">Go to Student Info Page</a></p>';
?>
