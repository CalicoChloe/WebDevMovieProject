<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <!-- Include Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>Add Movie</h1>
        <form action="add_movie.php" method="post">
            <div class="input-field">
                <input type="text" id="title" name="title" required>
                <label for="title">Title</label>
            </div>
            <div class="input-field">
                <input type="number" id="release_year" name="release_year" required>
                <label for="release_year">Release Year</label>
            </div>
            <div class="input-field">
                <input type="text" id="genre" name="genre" required>
                <label for="genre">Genre</label>
            </div>
            <div class="input-field">
                <input type="text" id="director" name="director" required>
                <label for="director">Director</label>
            </div>
            <div class="input-field">
                <input type="text" id="producer" name="producer" required>
                <label for="producer">Producer</label>
            </div>
            <div class="input-field">
                <input type="text" id="writer" name="writer" required>
                <label for="writer">Writer</label>
            </div>
            <div class="input-field">
                <input type="text" id="actors" name="actors" required>
                <label for="actors">Actors (Separate by commas)</label>
            </div>
            <button type="submit" class="btn waves-effect waves-light pink">Add Movie</button>
        </form>
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
            $actors_input = $_POST['actors']; // Actors input as comma-separated string
            $actors = array_map('trim', explode(',', $actors_input)); // Trim and split the string into an array
            
            // Check if director exists, if not, insert into directors table
            $sql = "SELECT id FROM director WHERE name = '$director'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 0) {
                mysqli_query($conn, "INSERT INTO director (name) VALUES ('$director')");
            }
            // Retrieve director id
            $director_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM director WHERE name = '$director'"))['id'];

            // Check if producer exists, if not, insert into producers table
            $sql = "SELECT id FROM producer WHERE name = '$producer'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 0) {
                mysqli_query($conn, "INSERT INTO producer (name) VALUES ('$producer')");
            }
            // Retrieve producer id
            $producer_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM producer WHERE name = '$producer'"))['id'];

            // Check if writer exists, if not, insert into writers table
            $sql = "SELECT id FROM writer WHERE name = '$writer'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 0) {
                mysqli_query($conn, "INSERT INTO writer (name) VALUES ('$writer')");
            }
            // Retrieve writer id
            $writer_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM writer WHERE name = '$writer'"))['id'];

            // Insert movie record into film table with foreign key associations
            $sql = "INSERT INTO film (title, release_year, genre, director_id, producer_id, writer_id) VALUES ('$title', '$release_year', '$genre', '$director_id', '$producer_id', '$writer_id')";
            if (mysqli_query($conn, $sql)) {
                // Retrieve the movie id
                $movie_id = mysqli_insert_id($conn);

                // Insert actors into actor table if they don't exist and associate them with the movie
                foreach ($actors as $actor_name) {
                    $actor_name = mysqli_real_escape_string($conn, $actor_name);
                    $sql = "SELECT id FROM actor WHERE name = '$actor_name'";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) == 0) {
                        mysqli_query($conn, "INSERT INTO actor (name) VALUES ('$actor_name')");
                    }
                    // Retrieve actor id
                    $actor_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM actor WHERE name = '$actor_name'"))['id'];

                    // Associate actor with the movie in the movie_actor table
                    mysqli_query($conn, "INSERT INTO movie_actor (film_id, actor_id) VALUES ('$movie_id', '$actor_id')");
                }

                echo "Movie added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            // Close database connection
            mysqli_close($conn);
        }
        ?>
    </div>
</body>
</html>
