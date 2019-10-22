<?php

require_once 'conexion.php';

$url = "https://www.amazon.com/s?k=tarjeta+de+video&__mk_es_US=%C3%85M%C3%85%C5%BD%C3%95%C3%91&ref=nb_sb_noss";

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$contenido = file_get_contents($url, false, stream_context_create($arrContextOptions));

$id_producto = "s-include-content-margin s-border-bottom";

$lista_productos = explode($id_producto, $contenido);

$id_titulo = "a-size-medium a-color-base a-text-normal";
$id_valoracion = "a-icon-alt";
$id_precio = "a-offscreen";
$id_imagen = "img";

for ($i=1; $i < 16; $i = $i + 2) {
    $producto = $lista_productos[$i];

    $titulo = explode($id_titulo, $producto);
    $titulo = $titulo[1];
    $titulo = explode('>', $titulo);
    $titulo = $titulo[1];

    $valoracion = explode($id_valoracion, $producto);
    $valoracion = $valoracion[1];
    $valoracion = explode('>', $valoracion);
    $valoracion = $valoracion[1];
    $valoracion = substr($valoracion, 0, 3);

    $precio = explode($id_precio, $producto);
    $precio = $precio[1];
    $precio = explode('>', $precio);
    $precio = $precio[1];
    $precio = substr($precio, 1);

    $imagen = explode($id_imagen, $producto);
    $imagen = $imagen[1];
    $imagen = explode('"', $imagen);
    $imagen = $imagen[1];

    if (substr($imagen, 0, 5) == 'https' && isset($titulo)) {
        echo "
        <div>
            <div>
                <h3>$titulo</h3>
            </div>
            <div>
                <img src='$imagen'>
                <div>
                    <span><b>Precio:</b> $ $precio</span>
                    <br>
                    <span><b>Valoración:</b> $valoracion</span>
                </div>
            </div>
        </div>
        <hr>
        ";
        $query = "INSERT INTO producto VALUES (DEFAULT, '$titulo', '$precio', '$valoracion');";
        $cnx -> query($query) OR die($query);
    } else {
        header('location: scrap02.php');
    }

}
