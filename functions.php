<?php
function generarToken() {
    return bin2hex(random_bytes(32));
}

function actualizarToken($userId, $token) {
    global $conn;
    $updateTokenSql = "UPDATE usuarios SET token = '$token' WHERE Id = $userId";
    $conn->query($updateTokenSql);
}
?>
