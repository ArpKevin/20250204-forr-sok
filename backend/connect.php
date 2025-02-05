<?php
// Adatbázis kapcsolódási adatok
$servername = "localhost";      // Szerver címe (általában localhost)
$username = "root";             // Felhasználónév (alapértelmezett: root)
$password = "";                 // Jelszó (alapértelmezett: üres XAMPP esetén)
$database = "products2025";      // Adatbázis neve

// Kapcsolat létrehozása
$conn = mysqli_connect($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
if (!$conn) {
    // Hiba esetén JSON formátumban visszaadja az üzenetet
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Adatbázis kapcsolódási hiba: ' . mysqli_connect_error()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit(); // Megállítja a szkript futását
}

// Sikeres kapcsolódás esetén opcionális visszajelzés (fejlesztés közben hasznos lehet)
// echo json_encode(['status' => 'success', 'message' => 'Sikeres kapcsolódás az adatbázishoz.']);
?>
