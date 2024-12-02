<?php
    function get_api_by_url($url) {
        // Inicializa o cURL
        $ch = curl_init();

        // Configurações do cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Define a URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
        curl_setopt($ch, CURLOPT_HTTPGET, true); // Método HTTP GET

        // Executa o pedido e armazena a resposta
        $response = curl_exec($ch);

        // Verifica se ocorreu algum erro no cURL
        if (curl_errno($ch)) {
            echo "Erro ao consumir API: " . curl_error($ch);
        } else {
            // Decodifica o JSON da resposta
            $data = json_decode($response, true);
        }
        // Fecha a conexão cURL
        curl_close($ch);
        return $data;
    }
    // URL da API para obter informações sobre Bulbasaur
    $url = 'https://pokeapi.co/api/v2/pokemon/';
    $data = get_api_by_url($url);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
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
                foreach($data['results'] as $pokemon){
                    $url = $pokemon['url'];
                    $poke_info = get_api_by_url($url);
                    if($poke_info){
                        // Decodifica o JSON da resposta
                        echo
                        '
                            <div class="col-md-3">
                                <div class="card" style="width: 18rem;">
                                    <img src="'.$poke_info['sprites']['front_default'].'" class="card-img-top" alt="Pokemon sprite">
                                    <div class="card-body">
                                        <p class="poke_id">'.$poke_info['id'].'</p>
                                        <h5 class="card-title poke-name">'.$pokemon['name'].'</h5>
                                        <div class="row">';
                                            foreach($poke_info['types'] as $type){
                                                $url = $type['type']['url'];
                                                $type_info = get_api_by_url($url);
                                                if($type_info) {
                                                    echo '
                                                        <div class="col">
                                                            <img src="'.$type_info['sprites']['generation-viii']['legends-arceus']['name_icon'].'" class="img-fluid img-type" alt="Pokemon type">
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

</body>

</html>