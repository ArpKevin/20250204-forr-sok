<?php

require_once('connect.php');

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

$torzs = json_decode(
    '
    {
        "name": "New Product",
        "description": "Product description",
        "price": 99.99,
        "image_name": "new_product.jpg"
      }
    ', true
    );
    echo json_encode($torzs);


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
        ]);
    } else {
        $result = mysqli_fetch_all($termekek, MYSQLI_ASSOC);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
}

?>