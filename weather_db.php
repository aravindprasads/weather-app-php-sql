<?php
function db_init()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "WeatherDB";
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    // Create database
    $sql = "CREATE DATABASE ".$dbname;
    $result = $conn->query($sql);
/*    
    if ($result === TRUE) {
        echo "<br>Database created successfully";
    } else {
        echo "<br>Error creating database: " . $conn->error;
    }
*/    
    $conn->close();
}

function get_conn()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mymymyDB";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    return $conn;
}

function db_create($conn)
{
    $sql = "CREATE TABLE CityTable (
            city VARCHAR(50) NOT NULL
            )";
    $result = $conn->query($sql);            
/*
    if ($result  === TRUE) {
        echo "<br>Table CityTable created successfully";
    } else {
        echo "<br>Error creating table: " . $conn->error;
    }
*/    
}

function db_insert($conn, $input_city) 
{
    $sql = "SELECT * FROM CityTable";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($input_city == $row["city"]) {
                //echo "<br>Duplicate city found<br>";
                return;
            }    
        }
    } 
    $sql = "INSERT INTO CityTable (city) VALUES ('$input_city')";
    $result = $conn->query($sql);
/*    
    if ($result === TRUE) {
        echo "<br>New record created successfully";
    } else {
        echo "<br>Error: " . $sql . $conn->error;
    }
*/    
}

function db_update($conn)
{
    $sql = "UPDATE CityTable SET lastname='Dmuyyy' WHERE id=11";
    $result = $conn->query($sql);
/*
    if ($result === TRUE) {
        echo "<br>Record updated successfully";
    } else {
        echo "<br>Error updating record: " . $conn->error;
    }
*/
}

function db_delete($conn, $city)
{
    $sql = "DELETE FROM CityTable WHERE city='$city'";
    $result = $conn->query($sql);
/*    
    if ($result === TRUE) {
        echo "<br>Record deleted successfully";
    } else {
        echo "<br>Error deleting record: " . $conn->error;
    }
*/    
}

function db_delete_all($conn)
{
    $sql = "DELETE FROM CityTable";
    $result = $conn->query($sql);
/*
    if ($result === TRUE) {
        echo "<br>All Records deleted successfully";
    } else {
        echo "<br>Error deleting record: " . $conn->error;
    }
*/
}

function db_print($conn)
{
    $sql = "SELECT * FROM CityTable";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<br>City: " . $row["city"];
        }
    } else {
        echo "<br>0 results";
    }
}

function db_close($conn) {
    $conn->close();                                                                                     
}

/*
db_init();
$conn = get_conn();
db_create($conn);
db_insert($conn, "Chennai");
db_print($conn);
//db_update($conn);
//db_print($conn);
db_delete($conn, "Chennai");
db_print($conn);
db_delete_all($conn);
db_print($conn);
$conn->close();
*/
?>

