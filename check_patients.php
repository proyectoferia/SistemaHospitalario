<?php
require_once 'backend/bd/Conexion.php';

try {
    echo "=== VERIFICANDO PACIENTES EN LA BASE DE DATOS ===\n";
    
    $stmt = $connect->query("SELECT idpa, nompa, apepa, numhs, phon, sex, state FROM patients ORDER BY idpa");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total pacientes: " . count($patients) . "\n\n";
    
    foreach($patients as $patient) {
        echo "ID: " . $patient['idpa'] . "\n";
        echo "Nombre: " . $patient['nompa'] . " " . $patient['apepa'] . "\n";
        echo "DNI: " . $patient['numhs'] . "\n";
        echo "Teléfono: " . ($patient['phon'] ?: 'No registrado') . "\n";
        echo "Sexo: " . ($patient['sex'] ?: 'No especificado') . "\n";
        echo "Estado: " . ($patient['state'] == 1 ? 'Activo' : 'Inactivo') . "\n";
        echo "------------------------\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
