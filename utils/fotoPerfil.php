<?php
function obtenerRutaFoto($foto, $porDefecto = 'assets/icons/user-profile-icon-free-vector.jpg') {
    $foto = trim($foto);
    if (filter_var($foto, FILTER_VALIDATE_URL)) {
        return $foto;
    } elseif ($foto !== '' && file_exists($foto)) {
        return $foto;
    }
    return $porDefecto;
}
?>