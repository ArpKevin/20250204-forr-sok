<?php

require_once('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET"){   
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $termekek = mysqli_query($conn, "select * from products where id = " . $_GET['id']);
        if(!$termekek){
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "A megadott azonosítóval nem található termék: " . $_GET['id']
            ]);
        }
        else{
            echo json_encode($termekek);
        }
        
    }
    else{
        echo "Helytelen paraméter.";
    }
}
else{
    http_response_code(405);
}

?>