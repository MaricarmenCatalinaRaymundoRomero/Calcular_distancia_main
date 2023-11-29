<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora de Distancias</title>
    <script src="node_modules/jquery/dist/jquery.js"></script>
</head>
<body>

    <div class="container" id="ocultar">
        <div class="input-section">
            <h2>Ingrese los puntos de partida y llegada:</h2>
            <!--Direcciones-->
            <label for="startPoint">Punto de Partida:</label>
            <select id="startPoint">
                <option value="Jr. de la Unión 456, Cercado de Lima, Lima, Perú">Jr. de la Unión 456, Cercado de Lima</option>
                <option value="Calle Berlin 234, Miraflores, Lima, Perú">Calle Berlin 234, Miraflores</option>
                <option value="Av. Pardo 890, Miraflores, Lima, Perú">Av. Pardo 890, Miraflores</option>
                <option value="Calle Colón 432, Barranco, Lima, Perú">Calle Colón 432, Barranco</option>
                <option value="Av. Grau 876, Callao, Lima, Perú">Av. Grau 876, Callao</option>
            </select>
            <label for="endPoint">Punto de Llegada:</label>
            <select id="endPoint">
                <option value="Av. La Marina 1234, San Miguel, Lima, Perú">Av. La Marina 1234, San Miguel</option>
                <option value="Av. Javier Prado Este 789, San Isidro, Lima, Perú">Av. Javier Prado Este 789, San Isidro</option>
                <option value="Av. Salaverry 567, Jesús María, Lima, Perú">Av. Salaverry 567, Jesús María</option>
                <option value="Av. Brasil 567, Breña, Lima, Perú">Av. Brasil 567, Breña</option>
                <option value="Av. Universitaria 345, San Martín de Porres, Lima, Perú">Av. Universitaria 345, San Martín de Porres</option>
            </select>
            
            <button onclick="calcularDistancia()">Calcular Distancia</button>
        </div>
        <div class="options-section">
            <h2>Opciones de Servicio:</h2>
            <h3>Distancia en Kilometros: <span id="distenciaMetros">0.00</span></h3>
            <div class="service-option" id="economicOption">
                <h3>Económico</h3>
                <!--Imagen-->
                <div id="car-image-container">
                    <img id="car-image" src="img/economic.jpg" alt="Imagen del carro">
                </div>
                <p>Precio por metro: S/ 0.5</p>
                <p>Total: <span id="economicTotal">0.00</span></p>
                <button type="button" onclick="hacerFormulario('economico')">Seleccionar Económico</button>
            </div>

            <div class="service-option" id="executiveOption">
                <h3>Executive</h3>
                <!--Imagen-->
                <div id="car-image-container">
                    <img id="car-image" src="img/ejecutivo.jpg" alt="Imagen del carro">
                </div>
                <p>Precio por metro: S/ 1.5</p>
                <p>Total: <span id="executiveTotal">0.00</span></p>
                <button type="button" onclick="hacerFormulario('executive')">Seleccionar Executive</button>
            </div>
        </div>
    </div>

     <!-- Formulario -->
     <div id="formulario" class="container" style="display: none;">
        <h2>Formulario</h2>
        <form action="enviar_mensaje.php" method="post">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="numero">Teléfono:</label>
            <input type="text" id="numero" name="numero" required>

            <label for="precioSeleccionado">Precio:</label>
            <input type="text" id="precioSeleccionado" name="precioSeleccionado" readonly>

            <button type="submit">Aceptar</button>
        </form>
    </div>  
    <script>    
        
        function ocultarMostrar() {
            document.getElementById('ocultar').style.display = 'none';
            document.getElementById('formulario').style.display = 'block';
        }

        function hacerFormulario(servicio) {
            ocultarMostrar();
            // Obtener el precio del servicio seleccionado
            var precioSeleccionado = 0;
            if (servicio === 'economico') {
                precioSeleccionado = parseFloat(document.getElementById('economicTotal').innerText);
            } else if (servicio === 'executive') {
                precioSeleccionado = parseFloat(document.getElementById('executiveTotal').innerText);
            }
            // Actualizar el valor del precio en el formulario
            document.getElementById('precioSeleccionado').value = precioSeleccionado.toFixed(2);

        }

    </script>
    <script>
        //Función para obtener coordenadas del inicio y final 
        function geocodeAddress(address, callback) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status === 'OK') {
                    var coordinates = {
                        lat: results[0].geometry.location.lat(),
                        lng: results[0].geometry.location.lng()
                    };
                    callback(coordinates);
                } else {
                    window.alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>

    <script>
        function calcularDistancia() {
            // Obtener las ubicaciones a partir de las direcciones ingresadas por el usuario
            var startAddress = document.getElementById('startPoint').value;
            var endAddress = document.getElementById('endPoint').value;

            // Convertir direcciones en coordenadas
            geocodeAddress(startAddress, function(partida) {
                geocodeAddress(endAddress, function(llegada) {
                    // Ahora tienes las coordenadas de partida y llegada, puedes continuar con el cálculo de distancia
                    // y la actualización de precios.
                    console.log("Coordenadas de Partida:", partida);
                    console.log("Coordenadas de Llegada:", llegada);

                    //Ruta
                    let directionsService = new google.maps.DirectionsService();
                    let directionsRenderer = new google.maps.DirectionsRenderer();

                    // Create route from existing points used for markers
                    const route = {
                        origin: partida,
                        destination: llegada,
                        travelMode: 'DRIVING'
                    }

                    directionsService.route(route, function(response, status) {
                        // anonymous function to capture directions
                        if (status !== 'OK') {
                            window.alert('Directions request failed due to ' + status);
                            return;
                        } else {
                            directionsRenderer.setDirections(response); // Add route to the map
                            var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
                            if (!directionsData) {
                                window.alert('Directions request failed');
                                return;
                            } else {
                                // Supongamos que la distancia se almacena en la variable 'distanciaEnKm'
                                var distanciaEnKm = parseFloat(directionsData.distance.text.replace(" mi", "")) * 1.60934;

                                // Actualizar el precio en función de la distancia
                                var precioEconomico = distanciaEnKm * 0.5;
                                var precioExecutive = distanciaEnKm * 1.5;

                                // Actualizar los elementos HTML con los nuevos precios
                                document.getElementById('economicTotal').innerText = precioEconomico.toFixed(2);
                                document.getElementById('executiveTotal').innerText = precioExecutive.toFixed(2);
                                //Distancia
                                document.getElementById('distenciaMetros').innerText = distanciaEnKm.toFixed(1);
                            }
                        }
                    });
                });
            });
        }
    </script>
    <!--API KEY GOOGLE MAPS-->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=Agregarkey&callback=initMap">
    </script>
    
</body>
</html>
