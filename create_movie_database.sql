-- Create database
CREATE DATABASE IF NOT EXISTS movies;

-- Use the database
USE movies;

-- Create directors table
CREATE TABLE IF NOT EXISTS directors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create producers table
CREATE TABLE IF NOT EXISTS producers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create writers table
CREATE TABLE IF NOT EXISTS writers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create actors table
CREATE TABLE IF NOT EXISTS actors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create film table
CREATE TABLE IF NOT EXISTS film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_year INT NOT NULL,
    genre VARCHAR(255) NOT NULL,
    director_id INT NOT NULL,
    producer_id INT NOT NULL,
    writer_id INT NOT NULL,
    FOREIGN KEY (director_id) REFERENCES directors(id),
    FOREIGN KEY (producer_id) REFERENCES producers(id),
    FOREIGN KEY (writer_id) REFERENCES writers(id)
);

-- Create movie_actors table
CREATE TABLE IF NOT EXISTS movie_actors (
    movie_id INT,
    actor_id INT,
    FOREIGN KEY (movie_id) REFERENCES film(id),
    FOREIGN KEY (actor_id) REFERENCES actors(id),
    PRIMARY KEY (movie_id, actor_id)
);
