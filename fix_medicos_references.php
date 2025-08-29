<?php
// Script para eliminar TODAS las referencias a médicos y reemplazarlas con áreas

$directories = [
    'frontend/citas',
    'frontend/medicinas', 
    'frontend/admin',
    'frontend/ajustes',
    'frontend/acerca',
    'frontend/actividades',
    'frontend/recursos',
    'frontend/areas'
];

// Patrón de médicos a reemplazar
$medicos_pattern = '            <li>
                <a href="#"><i class=\'bx bxs-briefcase icon\' ></i> Médicos <i class=\'bx bx-chevron-right icon-right\' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>
                </ul>
            </li>';

// Reemplazo con áreas
$areas_replacement = '            <li>
                <a href="#"><i class=\'bx bxs-building-house icon\' ></i> Áreas Hospitalarias <i class=\'bx bx-chevron-right icon-right\' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../areas/mostrar.php">Todas las Áreas</a></li>
                    <li><a href="../areas/emergencia.php">Emergencia</a></li>
                    <li><a href="../areas/consulta_externa.php">Consulta Externa</a></li>
                    <li><a href="../areas/pediatria.php">Pediatría</a></li>
                    <li><a href="../areas/ginecologia.php">Ginecología</a></li>
                    <li><a href="../areas/cardiologia.php">Cardiología</a></li>
                    <li><a href="../areas/traumatologia.php">Traumatología</a></li>
                    <li><a href="../areas/medicina_interna.php">Medicina Interna</a></li>
                    <li><a href="../areas/neurologia.php">Neurología</a></li>
                    <li><a href="../areas/dermatologia.php">Dermatología</a></li>
                    <li><a href="../areas/oftalmologia.php">Oftalmología</a></li>
                </ul>
            </li>';

// Variaciones del patrón médicos
$medicos_variations = [
    // Variación 1: con espacios extra
    '            <li>
                <a href="#"><i class=\'bx bxs-briefcase icon\' ></i> Médicos <i class=\'bx bx-chevron-right icon-right\' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>
                   
                </ul>
            </li>',
    
    // Variación 2: sin espacios extra
    '            <li>
                <a href="#"><i class=\'bx bxs-briefcase icon\' ></i> Médicos <i class=\'bx bx-chevron-right icon-right\' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>
                </ul>
            </li>',
    
    // Variación 3: con diferentes espacios
    '            <li>
                <a href="#"><i class=\'bx bxs-briefcase icon\'></i> Médicos <i class=\'bx bx-chevron-right icon-right\'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>
                </ul>
            </li>'
];

$files_updated = 0;
$total_replacements = 0;

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . "/*.php");
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $original_content = $content;
            
            // Probar todas las variaciones
            foreach ($medicos_variations as $pattern) {
                $content = str_replace($pattern, $areas_replacement, $content);
            }
            
            // Si hubo cambios, guardar el archivo
            if ($content !== $original_content) {
                file_put_contents($file, $content);
                $files_updated++;
                $replacements = substr_count($original_content, 'medicos') - substr_count($content, 'medicos');
                $total_replacements += $replacements;
                echo "✓ Actualizado: $file ($replacements reemplazos)\n";
            }
        }
    }
}

echo "\n=== RESUMEN ===\n";
echo "Archivos actualizados: $files_updated\n";
echo "Total de reemplazos: $total_replacements\n";
echo "¡Actualización completada!\n";
?>
