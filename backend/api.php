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

    $name = $data['name'] ?? null;
    $description = $data['description'] ?? null;
    $price = $data['price'] ?? null;
    $image_name = $data['image_name'] ?? null;

    if ($name && $description && $price && $image_name){

        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $description, $price, $image_name);

        echo json_encode([
            "status" => "success",
            "message" => "asdsads"
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Product added successfully"
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Failed to add product."
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
?>