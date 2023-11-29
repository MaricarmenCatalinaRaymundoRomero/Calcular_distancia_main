<?php
    // Obtener el número de WhatsApp desde el formulario
    $numero_whatsapp = $_POST['numero'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precioSeleccionado'];

    // Configurar la solicitud cURL con el número proporcionado
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://qr.chat.buho.la/api/create-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'appkey' => 'ce3b82d1-370d-4b8e-8f16-a49cfa624379',
            'authkey' => 'Y3vda2G1uoBW9sB8S4rl89Rc2u5F3xfDbYHaCFHgPqDg0H3sc3',
            'to' => $numero_whatsapp,
            'message' => ' Muchas gracias por seleccionar nuestros servicio señor/a: ' . $nombre . ' El valor del viaje es de: ' . $precio ,
            'sandbox' => 'false'
        ),
    ));

    // Ejecutar la solicitud cURL
    $response = curl_exec($curl);

    // Cerrar la sesión cURL
    curl_close($curl);

    // Redirigir a index.php después de enviar el mensaje
    header("Location: index.php");
    exit();
?>
