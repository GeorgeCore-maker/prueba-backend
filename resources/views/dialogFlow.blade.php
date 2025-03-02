<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta de Productos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow bg-dark text-white"> <!-- Tarjeta oscura con texto blanco -->
                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title text-center fw-bold">Consulta sobre productos</h1>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" id="message" class="form-control" placeholder="Pregunta sobre productos...">
                            <button class="btn btn-primary" onclick="sendMessage()">Enviar</button>
                        </div>
                        <div id="response" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        async function sendMessage() {
            const message = document.getElementById('message').value;

            // Validar que no vaya vacio mensaje
            if (!message.trim()) {
                alert('Por favor, ingrese un texto para buscar productos.');
                return;
            }

            const response = await fetch('/api/dialogflow/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            document.getElementById('response').innerHTML = `<div class="alert alert-info">${data.response}</div>`;
        }
    </script>
</body>
</html>
