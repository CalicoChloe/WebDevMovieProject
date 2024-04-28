<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Movie</title>
    <!-- Include Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>Remove Movie</h1>
        <form action="remove_movie.php" method="post">
            <div class="input-field">
                <input type="text" id="title" name="title" required>
                <label for="title">Title</label>
            </div>
            <div class="input-field">
                <input type="number" id="release_year" name="release_year" required>
                <label for="release_year">Release Year</label>
            </div>
            <button type="submit" class="btn waves-effect waves-light pink">Remove Movie</button>
        </form>
        <?php
        // Include database connection
        include 'connect_db.php';

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Escape user inputs to prevent SQL injection
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $release_year = mysqli_real_escape_string($conn, $_POST['release_year']);

            // Check if the movie exists in the database
            $sql = "SELECT id FROM film WHERE title = '$title' AND release_year = '$release_year'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $movie_id = mysqli_fetch_assoc($result)['id'];
                // Delete the movie record from film table
                $delete_film_sql = "DELETE FROM film WHERE id = '$movie_id'";
                if (mysqli_query($conn, $delete_film_sql)) {
                    // Delete associated records from movie_actors table
                    $delete_actors_sql = "DELETE FROM movie_actors WHERE movie_id = '$movie_id'";
                    mysqli_query($conn, $delete_actors_sql);
                    echo "<p>Movie removed successfully.</p>";
                } else {
                    echo "<p>Error removing movie: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p>Movie not found.</p>";
            }
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
