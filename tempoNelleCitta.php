<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="navBar.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Il Tempo Nelle Citta</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- bottone  -->
            <nav class="navbar navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
            </nav>

            <img  src="https://snow-effect.com/img/logos/schnee-effekt_logo.png" alt=""> 
            <img src="https://freepngimg.com/thumb/sun/1-2-sun-download-png-thumb.png" alt="">
            <img src="https://www.freepngimg.com/thumb/rain/86915-blue-petal-cartoon-rain-thunderstorm-free-download-image-thumb.png" alt="">


          



    </nav>
<!-- codice PHP -->
<?php
$apiKey = "2a27dd4dbda024e1daec25bb7a9115de";
$cityId = "";
$conta2 = 0;
$citta_cercata = "";



if(isset($_GET["search"])){
    $citta_cercata = $_GET["search"];
    $citta_cercata = strtolower($citta_cercata);
    echo $citta_cercata;
    $conta2 = $conta2 +1;

}

$firstStringCharacter = substr($citta_cercata, 0, 1);
$carattere_finale = strtoupper($firstStringCharacter);
$citta_cercata = str_replace($firstStringCharacter,$carattere_finale ,$citta_cercata);




$json = json_decode(file_get_contents('city.list.json'));
$conta = 0;
foreach ($json as $item) {
    if($conta2 == 0){

        if ($conta == 0)
        {
        if ($item->name == "Brescia") {
            $cityId  =  $item->id;
            $conta = $conta +1;
        }
    }

    }else{

        if ($conta == 0)
        {
        if ($item->name == $citta_cercata) {
            $cityId  =  $item->id;
            $conta = $conta +1;
        }
    }
    }
   
}





$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=it&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response); 
$currentTime = time();

// prendo ID dal file JSON tramite il nome della citta 
// $json = json_decode(file_get_contents('city.list.json'));
// $conta = 0;
// foreach ($json as $item) {
//     if ($conta == 0)
//     {
//     if ($item->name == "Bari") {
//         echo $item->id;
//         $conta = $conta +1;
//     }
// }
// }


?>
<!-- prova ricerca -->

    <!-- contenuto pagina  -->
    <div class="container">
        <div class="card border-0 shadow my-5">
            <div class="card-body p-5">
            <div class="report-container">
            <div class="jumbotron">

<!--inizio ricerca  -->

<div class="search-container">

                            <form action="" method="GET">
                             <input class="form-control" type="text" id="input" name="search" placeholder="Quale città italiana vuoi cercare?"/>
                            <br>
                                <button class="btn btn-secondary" type="submit" name="submit_btn">Cerca</button>
                            </form>
                        </div>  
<!-- fine ricerca  -->

        <h2>il Tempo a <?php echo $data->name; ?> </h2>
        <div class="time">
            <div><?php echo date("l g:i a", $currentTime); ?></div>
            <div><?php echo date("jS F, Y",$currentTime); ?></div>
            <div><?php echo ucwords($data->weather[0]->description); ?></div>
        </div>
       
        <div class="weather-forecast">
            <img
                src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"class="weather-icon" />
                <br>
                temperatura massima : <?php echo $data->main->temp_max; ?>&deg;C
                <br>
                <span
                class="min-temperature"> temperatura minima <?php echo $data->main->temp_min; ?>&deg;C</span>
                <br>
        </div>
        <div class="time">
            <div>Umidità : <?php echo $data->main->humidity; ?> %</div>
            <div>Vento: <?php echo $data->wind->speed; ?> km/h</div>
        </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</body>

</html>