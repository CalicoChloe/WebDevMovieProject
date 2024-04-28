<?php
// Include database connection
include 'connect_db.php';

// Select all movies from the database
$sql = "SELECT * FROM film";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Movies</title>
    <!-- Include Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <div class="container">
        <h1>Display Movies</h1>
        <table class="striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Release Year</th>
                    <th>Genre</th>
                    <th>Director</th>
                    <th>Producer</th>
                    <th>Writer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['release_year']."</td>";
                    echo "<td>".$row['genre']."</td>";
                    
                    // Retrieve director name
                    $director_id = $row['director_id'];
                    $director_result = mysqli_query($conn, "SELECT name FROM directors WHERE id = '$director_id'");
                    $director_name = mysqli_fetch_assoc($director_result)['name'];
                    echo "<td>".$director_name."</td>";

                    // Retrieve producer name
                    $producer_id = $row['producer_id'];
                    $producer_result = mysqli_query($conn, "SELECT name FROM producers WHERE id = '$producer_id'");
                    $producer_name = mysqli_fetch_assoc($producer_result)['name'];
                    echo "<td>".$producer_name."</td>";

                    // Retrieve writer name
                    $writer_id = $row['writer_id'];
                    $writer_result = mysqli_query($conn, "SELECT name FROM writers WHERE id = '$writer_id'");
                    $writer_name = mysqli_fetch_assoc($writer_result)['name'];
                    echo "<td>".$writer_name."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
