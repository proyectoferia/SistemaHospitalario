<!DOCTYPE html>
<html>
<head>
    <title>Test Búsqueda Pacientes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>🔍 Test de Búsqueda de Pacientes</h2>
    
    <div>
        <label>Buscar paciente:</label>
        <input type="text" id="testDni" placeholder="DNI o nombre">
        <button onclick="buscarPaciente()">Buscar</button>
    </div>
    
    <div id="resultado" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;"></div>
    
    <div style="margin-top: 20px;">
        <h3>Pruebas sugeridas:</h3>
        <button onclick="testDni('77458745')">Test DNI: 77458745</button>
        <button onclick="testDni('76433434')">Test DNI: 76433434</button>
        <button onclick="testDni('JAVIER')">Test Nombre: JAVIER</button>
        <button onclick="testDni('Manuel')">Test Nombre: Manuel</button>
        <button onclick="verTodosPacientes()">Ver Todos los Pacientes</button>
    </div>

    <script>
        function buscarPaciente() {
            const dni = document.getElementById('testDni').value;
            testDni(dni);
        }
        
        function testDni(dni) {
            document.getElementById('testDni').value = dni;
            
            $.ajax({
                url: "backend/php/buscar_paciente.php",
                method: "POST",
                data: { dni: dni },
                dataType: "json",
                success: function(response) {
                    console.log("Respuesta:", response);
                    
                    if (response.error) {
                        document.getElementById('resultado').innerHTML = 
                            '<div style="color: red;"><strong>Error:</strong> ' + response.error + 
                            (response.debug ? '<br><strong>Debug:</strong> ' + response.debug : '') +
                            (response.sugerencia ? '<br><strong>Sugerencia:</strong> ' + response.sugerencia : '') +
                            '</div>';
                    } else {
                        document.getElementById('resultado').innerHTML = 
                            '<div style="color: green;"><strong>✅ Paciente encontrado:</strong><br>' +
                            '<strong>ID:</strong> ' + response.idpa + '<br>' +
                            '<strong>DNI:</strong> ' + response.dni + '<br>' +
                            '<strong>Nombre:</strong> ' + response.nombre + '<br>' +
                            '<strong>Género:</strong> ' + response.genero + '<br>' +
                            '<strong>Grupo:</strong> ' + response.grupo_sanguineo + '<br>' +
                            '<strong>Contacto:</strong> ' + response.contacto + '<br>' +
                            '<strong>Estado:</strong> ' + response.state + '<br>' +
                            (response.edad ? '<strong>Edad:</strong> ' + response.edad + ' años<br>' : '') +
                            '</div>';
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX:", error);
                    document.getElementById('resultado').innerHTML = 
                        '<div style="color: red;"><strong>Error de conexión:</strong> ' + error + '</div>';
                }
            });
        }
        
        function verTodosPacientes() {
            $.ajax({
                url: "backend/php/debug_pacientes.php",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log("Debug pacientes:", response);
                    
                    let html = '<div style="color: blue;"><strong>📊 Información de la Base de Datos:</strong><br>';
                    html += '<strong>Total pacientes:</strong> ' + response.total_pacientes + '<br>';
                    html += '<strong>Pacientes activos:</strong> ' + response.pacientes_activos + '<br><br>';
                    
                    if (response.ultimos_10_pacientes && response.ultimos_10_pacientes.length > 0) {
                        html += '<strong>Últimos 10 pacientes:</strong><br>';
                        response.ultimos_10_pacientes.forEach(function(p) {
                            html += '• ID: ' + p.idpa + ' | DNI: ' + p.numhs + ' | ' + p.nompa + ' ' + p.apepa + ' | Estado: ' + (p.state == '1' ? 'Activo' : 'Inactivo') + '<br>';
                        });
                    }
                    html += '</div>';
                    
                    document.getElementById('resultado').innerHTML = html;
                },
                error: function(xhr, status, error) {
                    document.getElementById('resultado').innerHTML = 
                        '<div style="color: red;"><strong>Error al obtener debug:</strong> ' + error + '</div>';
                }
            });
        }
    </script>
</body>
</html>
