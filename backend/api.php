<?php

require_once('connect.php');

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $termekek = mysqli_query($conn, "SELECT * FROM products WHERE id = " . $_GET['id']);
    } else {
        $termekek = mysqli_query($conn, "SELECT * FROM products");
    }

    if (mysqli_num_rows($termekek) === 0) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "A megadott azonosítóval nem található termék: " . $_GET['id']
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        $result = mysqli_fetch_all($termekek, MYSQLI_ASSOC);
        // echo json_encode($result, JSON_PRETTY_PRINT);
        echo json_encode([
            "status" => "success",
            "data" => $result
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name'], $data['description'], $data['price'], $data['image_name'])
        && trim($data['name']) !== "" && trim($data['description']) !== "" && is_numeric($data['price']) && trim($data['image_name']) !== ""
    ){

        $name = mysqli_real_escape_string($conn, $data['name']);
        $description = mysqli_real_escape_string($conn, $data['description']);
        $price = doubleval($data['price']);
        $image_name = mysqli_real_escape_string($conn, $data['image_name']);


        $query = mysqli_query($conn,"INSERT INTO products (name, description, price, image_name) VALUES ('$name', '$description', $price, '$image_name')");

        if ($query){
            echo json_encode([
                "status" => "success",
                "message" => "Termék sikeresen létrehozva.",
                "id" => mysqli_insert_id($conn)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else{
            echo json_encode([
                "status" => "error",
                "message" => "Hiba a termék létrehozása során: " . mysqli_error($conn)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
    else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Hiányos adatok. Kérjük, töltse ki a név, leírás, ár és kép mezőket."
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "PUT"){

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {

        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['name'], $data['description'], $data['price'], $data['image_name'])
            && trim($data['name']) !== "" && trim($data['description']) !== "" && is_numeric($data['price']) && trim($data['image_name']) !== ""
        ){

            $name = mysqli_real_escape_string($conn, $data['name']);
            $description = mysqli_real_escape_string($conn, $data['description']);
            $price = doubleval($data['price']);
            $image_name = mysqli_real_escape_string($conn, $data['image_name']);

            $termekek = mysqli_query($conn, "UPDATE products SET name = '$name', description = '$description', price = $price, image_name = '$image_name' WHERE id = " . $_GET['id']);

            if (!$termekek) {
                http_response_code(404);
                echo json_encode([
                    "status" => "error",
                    "message" => "A megadott azonosítóval nem található termék: " . $_GET['id']
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    "status" => "success",
                    "data" => "Termék sikeresen frissítve."
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }
        else{
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Hiányos adatok. Kérjük, töltse ki a név, leírás, ár és kép mezőket."
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
    else{
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Hiányzik a termék azonosító (id), vagy nem megfelelő formátumú."
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
?>