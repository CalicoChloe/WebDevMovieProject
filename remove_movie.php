<?php
// Include database connection
include 'connect_db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_year = mysqli_real_escape_string($conn, $_POST['release_year']);
    
    // Delete movie record from database based on title and release year
    $sql = "DELETE FROM film WHERE title='$title' AND release_year='$release_year'";
    if (mysqli_query($conn, $sql)) {
        echo "Movie removed successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    // Close database connection
    mysqli_close($conn);
}
?>
