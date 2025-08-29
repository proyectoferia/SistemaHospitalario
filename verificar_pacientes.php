<?php
// Script directo para verificar pacientes en la base de datos
require_once 'backend/bd/Conexion.php';

echo "<h2>🔍 Verificación Directa de Pacientes</h2>";

try {
    // 1. Verificar conexión
    echo "<h3>1. Estado de la Base de Datos:</h3>";
    $stmt = $connect->query("SELECT DATABASE() as db_name");
    $db = $stmt->fetch();
    echo "✅ Conectado a: " . $db['db_name'] . "<br><br>";
    
    // 2. Contar pacientes
    echo "<h3>2. Conteo de Pacientes:</h3>";
    $stmt = $connect->query("SELECT COUNT(*) as total, COUNT(CASE WHEN state = '1' THEN 1 END) as activos FROM patients");
    $count = $stmt->fetch();
    echo "📊 Total pacientes: " . $count['total'] . "<br>";
    echo "✅ Pacientes activos: " . $count['activos'] . "<br><br>";
    
    // 3. Mostrar todos los pacientes
    echo "<h3>3. Lista de Todos los Pacientes:</h3>";
    $stmt = $connect->query("SELECT idpa, numhs, nompa, apepa, state FROM patients ORDER BY idpa");
    $pacientes = $stmt->fetchAll();
    
    if (count($pacientes) > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>DNI</th><th>Nombre</th><th>Apellido</th><th>Estado</th><th>Acción</th></tr>";
        
        foreach ($pacientes as $p) {
            $estado = $p['state'] == '1' ? '✅ Activo' : '❌ Inactivo';
            $color = $p['state'] == '1' ? 'green' : 'red';
            
            echo "<tr>";
            echo "<td>" . $p['idpa'] . "</td>";
            echo "<td><strong>" . $p['numhs'] . "</strong></td>";
            echo "<td>" . $p['nompa'] . "</td>";
            echo "<td>" . $p['apepa'] . "</td>";
            echo "<td style='color: $color;'>" . $estado . "</td>";
            echo "<td><button onclick='testBusqueda(\"" . $p['numhs'] . "\")'>Probar Búsqueda</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ <strong>NO HAY PACIENTES EN LA BASE DE DATOS</strong><br>";
        echo "Esto explica por qué no se encuentran pacientes al buscar.<br>";
    }
    
    // 4. Probar búsqueda con primer paciente
    if (count($pacientes) > 0) {
        echo "<h3>4. Prueba de Búsqueda Automática:</h3>";
        $primerPaciente = $pacientes[0];
        echo "Probando búsqueda con DNI: " . $primerPaciente['numhs'] . "<br>";
        
        // Simular la búsqueda
        $dni = $primerPaciente['numhs'];
        $dniLimpio = str_replace(['-', ' '], '', $dni);
        
        $stmt = $connect->prepare("SELECT idpa, numhs as dni, CONCAT(nompa, ' ', apepa) as nombre FROM patients WHERE (REPLACE(REPLACE(numhs, '-', ''), ' ', '') = ? OR numhs = ?) AND state = '1' LIMIT 1");
        $stmt->execute([$dniLimpio, $dni]);
        $resultado = $stmt->fetch();
        
        if ($resultado) {
            echo "✅ <strong>Búsqueda exitosa:</strong> " . $resultado['nombre'] . " (ID: " . $resultado['idpa'] . ")<br>";
        } else {
            echo "❌ <strong>Búsqueda falló</strong> - Revisar código de búsqueda<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Error:</strong> " . $e->getMessage();
}
?>

<script>
function testBusqueda(dni) {
    // Abrir en nueva ventana para probar
    window.open('test_busqueda.php?dni=' + dni, '_blank');
}
</script>

<style>
table { margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
button { padding: 5px 10px; cursor: pointer; }
</style>
