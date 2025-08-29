<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Búsqueda Simple</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h2>🔍 Test Búsqueda Pacientes - Versión Simple</h2>
    
    <div style="margin: 20px 0; padding: 20px; border: 2px solid #00BCD4;">
        <label>DNI del paciente:</label><br>
        <input type="text" id="dniInput" placeholder="Ej: 0101-2009-00358" style="width: 300px; padding: 10px; margin: 10px 0;">
        <button onclick="buscarPacienteSimple()" style="padding: 10px 20px; background: #00BCD4; color: white; border: none;">Buscar</button>
    </div>
    
    <div id="resultado" style="margin: 20px 0; padding: 15px; border: 1px solid #ccc; min-height: 100px;"></div>
    
    <div style="margin: 20px 0;">
        <h3>Pruebas rápidas:</h3>
        <button onclick="testDNI('0101-2009-00358')" style="margin: 5px; padding: 8px;">Genesis</button>
        <button onclick="testDNI('0101-2009-00433')" style="margin: 5px; padding: 8px;">Keren</button>
        <button onclick="testDNI('Genesis')" style="margin: 5px; padding: 8px;">Por nombre: Genesis</button>
    </div>

    <script>
        function buscarPacienteSimple() {
            const dni = document.getElementById('dniInput').value.trim();
            if (!dni) {
                Swal.fire('Error', 'Ingrese un DNI', 'error');
                return;
            }
            testDNI(dni);
        }
        
        function testDNI(dni) {
            document.getElementById('dniInput').value = dni;
            document.getElementById('resultado').innerHTML = '<div style="color: blue;">🔄 Buscando...</div>';
            
            console.log('=== INICIANDO BÚSQUEDA ===');
            console.log('DNI:', dni);
            console.log('URL:', 'backend/php/buscar_paciente.php');
            
            $.ajax({
                url: "backend/php/buscar_paciente.php",
                method: "POST",
                data: { dni: dni },
                dataType: "json",
                success: function(response) {
                    console.log('=== RESPUESTA EXITOSA ===');
                    console.log('Respuesta completa:', response);
                    
                    let html = '';
                    
                    if (response.error) {
                        html = `
                            <div style="background: #ffe6e6; padding: 15px; border-radius: 5px; color: red;">
                                <h4>❌ NO ENCONTRADO</h4>
                                <p><strong>Error:</strong> ${response.error}</p>
                                ${response.debug ? `<p><strong>Debug:</strong> ${response.debug}</p>` : ''}
                                ${response.sugerencia ? `<p><strong>Sugerencia:</strong> ${response.sugerencia}</p>` : ''}
                            </div>
                        `;
                        
                        Swal.fire({
                            title: 'Paciente no encontrado',
                            text: response.error,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        html = `
                            <div style="background: #e6ffe6; padding: 15px; border-radius: 5px; color: green;">
                                <h4>✅ PACIENTE ENCONTRADO</h4>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr><td><strong>ID:</strong></td><td>${response.idpa}</td></tr>
                                    <tr><td><strong>DNI:</strong></td><td>${response.dni}</td></tr>
                                    <tr><td><strong>Nombre:</strong></td><td>${response.nombre}</td></tr>
                                    <tr><td><strong>Género:</strong></td><td>${response.genero}</td></tr>
                                    <tr><td><strong>Grupo:</strong></td><td>${response.grupo_sanguineo}</td></tr>
                                    <tr><td><strong>Contacto:</strong></td><td>${response.contacto}</td></tr>
                                    <tr><td><strong>Estado:</strong></td><td>${response.state}</td></tr>
                                    ${response.edad ? `<tr><td><strong>Edad:</strong></td><td>${response.edad} años</td></tr>` : ''}
                                </table>
                                <div style="margin-top: 15px; padding: 10px; background: #f0f8ff;">
                                    <strong>✅ ESTE PACIENTE PUEDE USARSE PARA CITAS</strong>
                                </div>
                            </div>
                        `;
                        
                        Swal.fire({
                            title: 'Paciente encontrado',
                            text: `${response.nombre} - ID: ${response.idpa}`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                    
                    document.getElementById('resultado').innerHTML = html;
                },
                error: function(xhr, status, error) {
                    console.log('=== ERROR AJAX ===');
                    console.log('Status:', status);
                    console.log('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                    console.log('Status Code:', xhr.status);
                    
                    let errorHtml = `
                        <div style="background: #ffe6e6; padding: 15px; border-radius: 5px; color: red;">
                            <h4>❌ ERROR DE CONEXIÓN</h4>
                            <p><strong>Status:</strong> ${status}</p>
                            <p><strong>Error:</strong> ${error}</p>
                            <p><strong>Código:</strong> ${xhr.status}</p>
                            <p><strong>URL:</strong> backend/php/buscar_paciente.php</p>
                            ${xhr.responseText ? `<p><strong>Respuesta del servidor:</strong><br><pre>${xhr.responseText}</pre></p>` : ''}
                        </div>
                    `;
                    
                    document.getElementById('resultado').innerHTML = errorHtml;
                    
                    Swal.fire({
                        title: 'Error de conexión',
                        text: `${status}: ${error}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
        
        // Auto-test al cargar
        $(document).ready(function() {
            console.log('=== PÁGINA CARGADA ===');
            console.log('jQuery:', $.fn.jquery);
            console.log('SweetAlert2:', typeof Swal);
        });
    </script>
    
    <style>
        table td { padding: 5px 10px; border: 1px solid #ddd; }
        table td:first-child { background: #f5f5f5; font-weight: bold; }
    </style>
</body>
</html>
