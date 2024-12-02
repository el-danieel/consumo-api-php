<?php
    $url = 'https://pokeapi.co/api/v2/pokemon/';
    $data = file_get_contents($url);
    $info = json_decode($data);
    $count = $info->count;
    $QTD_MAX = 40;
    $generation = 'generation-viii';
    $game = 'legends-arceus';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Consumo da PokeAPI</title>
</head>

<body>
    <h1> Consumo da PokeAPI</h1>
    <p>
        <a href="index.php">Voltar</a>
    </p>
    <div class="container">
        <div class="row">
            <?php
                $id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
                echo '<h2>Página '.$id.'</h2>';
                $start = $QTD_MAX * ($id - 1) + 1;
                $end = min($QTD_MAX * $id, $count);
                for($i = $start; $i <= $end; $i++){
                    $poke_data = file_get_contents($url.$i.'/');
                    $poke_info = json_decode($poke_data);
                    if($poke_info){
                        echo '
                            <div class="col-md-3">
                                <div class="card" style="width: 18rem;">
                                    <img src="'.$poke_info->sprites->front_default.'" class="card-img-top" alt="Pokemon sprite">
                                    <div class="card-body">
                                        <p class="text-center">Id: '.$poke_info->id.'</p>
                                        <h5 class="card-title text-center">'.ucfirst($poke_info->name).'</h5>
                                        <div class="row text-center">';
                                            foreach($poke_info->types as $poke_type){
                                                $type_data = file_get_contents($poke_type->type->url);
                                                $type_info = json_decode($type_data);
                                                if($type_info) {
                                                    echo '
                                                        <div class="col">
                                                            <img src="'.$type_info->sprites->$generation->$game->name_icon.'" class="img-fluid" alt="Pokemon type">
                                                        </div>
                                                    '; 
                                                }
                                            } echo '</div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php
            for($j = 1; $j <= ceil($count / $QTD_MAX); $j++){
                echo '
                    <div class="col-1">
                        <form method="GET">
                            <input type="hidden" name="id" value="'.$j.'">
                            <button type="submit" class="btn btn-primary">'.$j.'</button>
                        </form>
                    </div>
                ';
            }
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
            }
            ?>
        </div>
    </div>
</body>

</html>