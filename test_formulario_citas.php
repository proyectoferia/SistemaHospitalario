<!DOCTYPE html>
<html>
<head>
    <title>Test Formulario Citas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
    <h2>🧪 Test Directo del Formulario de Citas</h2>
    
    <div style="margin: 20px 0; padding: 20px; border: 2px solid #00BCD4; border-radius: 8px;">
        <h3>Probar Búsqueda de Pacientes</h3>
        <label>DNI del paciente (usar uno de la imagen):</label><br>
        <input type="text" id="dniTest" placeholder="Ej: 0101-2009-00358" style="width: 300px; padding: 8px; margin: 10px 0;">
        <button onclick="probarBusqueda()" style="padding: 8px 16px; background: #00BCD4; color: white; border: none; cursor: pointer;">Buscar Paciente</button>
    </div>
    
    <div id="resultadoTest" style="margin: 20px 0; padding: 15px; border: 1px solid #ccc; min-height: 100px;"></div>
    
    <div style="margin: 20px 0;">
        <h3>DNIs de prueba (de la imagen):</h3>
        <button onclick="testearDNI('0101-2009-00358')" style="margin: 5px; padding: 8px;">Test: 0101-2009-00358</button>
        <button onclick="testearDNI('0101-2009-00433')" style="margin: 5px; padding: 8px;">Test: 0101-2009-00433</button>
        <button onclick="testearDNI('Keren')" style="margin: 5px; padding: 8px;">Test: Keren</button>
        <button onclick="testearDNI('Genesis')" style="margin: 5px; padding: 8px;">Test: Genesis</button>
    </div>

    <script>
        function probarBusqueda() {
            const dni = document.getElementById('dniTest').value.trim();
            if (!dni) {
                alert('Ingrese un DNI para buscar');
                return;
            }
            testearDNI(dni);
        }
        
        function testearDNI(dni) {
            document.getElementById('dniTest').value = dni;
            document.getElementById('resultadoTest').innerHTML = '<div style="color: blue;">🔄 Buscando paciente...</div>';
            
            console.log('Iniciando búsqueda para:', dni);
            
            $.ajax({
                url: "backend/php/buscar_paciente.php",
                method: "POST",
                data: { 
                    dni: dni
                },
                dataType: "json",
                timeout: 10000,
                success: function(res) {
                    console.log('Respuesta del servidor:', res);
                    
                    let html = '';
                    
                    if (res.error) {
                        html = `
                            <div style="color: red; background: #ffe6e6; padding: 15px; border-radius: 5px;">
                                <h4>❌ Paciente NO encontrado</h4>
                                <p><strong>Error:</strong> ${res.error}</p>
                                ${res.debug ? `<p><strong>Debug:</strong> ${res.debug}</p>` : ''}
                                ${res.sugerencia ? `<p><strong>Sugerencia:</strong> ${res.sugerencia}</p>` : ''}
                            </div>
                        `;
                        
                        Swal.fire({
                            title: 'Paciente no encontrado',
                            text: res.error,
                            icon: 'error'
                        });
                    } else {
                        html = `
                            <div style="color: green; background: #e6ffe6; padding: 15px; border-radius: 5px;">
                                <h4>✅ Paciente ENCONTRADO</h4>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                                    <div><strong>ID:</strong> ${res.idpa}</div>
                                    <div><strong>DNI:</strong> ${res.dni}</div>
                                    <div><strong>Nombre:</strong> ${res.nombre}</div>
                                    <div><strong>Género:</strong> ${res.genero}</div>
                                    <div><strong>Grupo:</strong> ${res.grupo_sanguineo}</div>
                                    <div><strong>Contacto:</strong> ${res.contacto}</div>
                                    <div style="grid-column: 1 / -1;"><strong>Estado:</strong> ${res.state}</div>
                                    ${res.edad ? `<div style="grid-column: 1 / -1;"><strong>Edad:</strong> ${res.edad} años</div>` : ''}
                                </div>
                                <div style="margin-top: 15px; padding: 10px; background: #f0f8ff; border-radius: 3px;">
                                    <strong>✅ Este paciente puede ser usado para crear citas</strong>
                                </div>
                            </div>
                        `;
                        
                        Swal.fire({
                            title: 'Paciente encontrado',
                            text: `${res.nombre} - ${res.dni}`,
                            icon: 'success'
                        });
                    }
                    
                    document.getElementById('resultadoTest').innerHTML = html;
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', {xhr, status, error});
                    
                    let errorMsg = `Error de conexión: ${error}`;
                    if (xhr.responseText) {
                        errorMsg += `\nRespuesta del servidor: ${xhr.responseText}`;
                    }
                    
                    document.getElementById('resultadoTest').innerHTML = `
                        <div style="color: red; background: #ffe6e6; padding: 15px; border-radius: 5px;">
                            <h4>❌ Error de Conexión</h4>
                            <p><strong>Estado:</strong> ${status}</p>
                            <p><strong>Error:</strong> ${error}</p>
                            <p><strong>URL:</strong> backend/php/buscar_paciente.php</p>
                            ${xhr.responseText ? `<p><strong>Respuesta:</strong> ${xhr.responseText}</p>` : ''}
                        </div>
                    `;
                    
                    Swal.fire({
                        title: 'Error de conexión',
                        text: errorMsg,
                        icon: 'error'
                    });
                }
            });
        }
        
        // Test automático al cargar la página
        $(document).ready(function() {
            console.log('Página de test cargada');
            console.log('jQuery version:', $.fn.jquery);
        });
    </script>
    
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        button { border-radius: 4px; border: 1px solid #ccc; }
        button:hover { background-color: #f0f0f0; }
        input { border: 1px solid #ccc; border-radius: 4px; }
    </style>
</body>
</html>
