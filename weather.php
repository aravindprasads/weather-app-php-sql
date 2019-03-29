<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>What's the weather like?</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.css" />
</head>

<body>
<?php
require_once('weather_db.php');
db_init();                                                                                          
$conn = get_conn();                                                                                 
db_create($conn);                                                                                   
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_reporting(0);
    $add_city = $_POST["city_add"];
    $del_city = $_POST["city_delete"];

    $string = "http://api.openweathermap.org/data/2.5/weather?q=".$add_city."&units=metric&appid=<openweathermap-key>";
    $payload = file_get_contents($string);
    if($add_city){
        if(($payload)) {
            db_insert($conn, $add_city); 
        }
        else {
            echo "<script type='text/javascript'>alert('\"$add_city\" is not supported. Kindly provider another city.');</script>";
        }
    }
    if($del_city)
        db_delete($conn, $del_city);
//    db_print($conn);        
}
?>
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    What's the weather like?
                </h1>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-offset-4 is-4">
                    <form method="POST">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input" name="city_add" type="text" placeholder="City Name">
                            </div>
                            <div class="control">
                                <button class="button is-info">
                                    Add City
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-offset-4 is-4">
                    <form method="POST">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input" name="city_delete" type="text" placeholder="City Name">
                            </div>
                            <div class="control">
                                <button class="button is-info">
                                    Delete City
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-offset-4 is-4">
                <?php
                    $sql = "SELECT * FROM CityTable";                                                               
                    $result = $conn->query($sql);                                                                   
                    if ($result->num_rows > 0) 
                    {
                        while($row = $result->fetch_assoc()) 
                        {
                            $city = $row["city"];
                            $string = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&appid=4da85e50a9e8c8b0e38766bcdb4de4da";
                            $data = json_decode(file_get_contents($string),true);
                            $temp = $data['main']['temp'];
                            $icon = $data['weather'][0]['icon'];
                            $desc = $data['weather'][0]['description'];
                 ?>           
                    <div class="box">
                        <article class="media">
                            <div class="media-left">
                                <figure class="image is-50x50">
                                    <img src="http://openweathermap.org/img/w/<?php echo $icon?>.png" alt="Image">
                                </figure>
                            </div>
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <span class="title"><?php echo $city?></span>
                                        <br>
                                        <span class="subtitle"><?php echo $temp?> ° C</span>
                                        <br> <?php echo $desc?> 
                                    </p>
                                </div>
                            </div>
                        </article>
                    </div>                    
                 <?
                        }                                                                                           
                    }
                    db_close($conn);
                 ?>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
    </footer>
</body>

</html>
