<?php
require_once 'backend/bd/Conexion.php';

echo "Probando conexión a la base de datos...\n";

try {
    // Verificar conexión
    $stmt = $connect->query("SELECT COUNT(*) as total FROM patients");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total de pacientes en la base de datos: " . $result['total'] . "\n";
    
    // Buscar el paciente específico
    $dni = '0101200900358';
    $stmt = $connect->prepare("SELECT idpa, nompa, apepa, numhs, phon, sex, state FROM patients WHERE numhs = ?");
    $stmt->execute([$dni]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($patient) {
        echo "Paciente encontrado:\n";
        print_r($patient);
    } else {
        echo "Paciente NO encontrado con DNI: $dni\n";
        
        // Buscar pacientes similares
        $stmt = $connect->prepare("SELECT idpa, nompa, apepa, numhs, state FROM patients WHERE numhs LIKE ? LIMIT 5");
        $stmt->execute(['%' . substr($dni, 0, 8) . '%']);
        $similares = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "Pacientes con DNI similar:\n";
        print_r($similares);
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
