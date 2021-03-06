<?php

// var_dump($_FILES);

// On vérifie si c'est bien une méthode POST
// var_dump($_SERVER["REQUEST_METHOD"]);
// var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_btn"])) {
    // ... On continue
    if ($_FILES["fichier"]["error"] !== 0) {
        echo "Une erreur fatale est survenue";
        die; // On stoppe
    }
    $sizeMax = 2 * 1_048_576; // 2 Mo
    if ($_FILES["fichier"]["size"] > $sizeMax) {
        echo "Fichier trop volumineux";
        die; // On stoppe
    }
    // Extensions qu'on souhaite autorisée
    $authorizedExt = [
        "jpg",
        "png",
        "webp"
    ];
    // Extension du fichier uploadé
    $params = explode(".", $_FILES['fichier']["name"]);
    $extension = strtolower(end($params)); // jpg, png, ...
    // On va vérifier si l'extension est autorisée
    if (!in_array($extension, $authorizedExt)) {
        echo "Extension non autorisée";
        die;
    }

    $filename = time() . bin2hex(random_bytes(48)) . "." . $extension;

    $status = move_uploaded_file(
        $_FILES["fichier"]["tmp_name"],
        "uploads/" . $filename
    );
    echo "Uploadé";
    var_dump($status);
}
