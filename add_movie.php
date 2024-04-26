<?php
// Include database connection
include 'connect_db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_year = mysqli_real_escape_string($conn, $_POST['release_year']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $producer = mysqli_real_escape_string($conn, $_POST['producer']);
    $writer = mysqli_real_escape_string($conn, $_POST['writer']);
    // Insert movie record into database
    $sql = "INSERT INTO film (title, release_year, genre, director, producer, writer) VALUES ('$title', '$release_year', '$genre', '$director', '$producer', '$writer')";
    if (mysqli_query($conn, $sql)) {
        echo "Movie added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    // Close database connection
    mysqli_close($conn);
}
?>
