<?php
// Script para actualizar automáticamente todas las referencias de médicos a áreas en los sidebars

$directories = [
    'pacientes',
    'citas', 
    'medicinas',
    'admin',
    'ajustes',
    'acerca',
    'actividades',
    'recursos',
    'usuarios',
    'profile'
];

$medicos_section = '            <li>
                <a href="#"><i class=\'bx bxs-briefcase icon\' ></i> Médicos <i class=\'bx bx-chevron-right icon-right\' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>
                </ul>
            </li>';

$areas_section = '            <li>
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

$session_fix_old = '    if(!isset($_SESSION[\'rol\']) || $_SESSION[\'rol\'] != 1){
    header(\'location: ../login.php\');

    $id=$_SESSION[\'id\'];
  }';

$session_fix_new = '    if(!isset($_SESSION[\'rol\']) || $_SESSION[\'rol\'] != 1){
        header(\'location: ../login.php\');
        exit();
    }
    $id=$_SESSION[\'id\'];';

foreach ($directories as $dir) {
    $path = "frontend/$dir/";
    if (is_dir($path)) {
        $files = glob($path . "*.php");
        foreach ($files as $file) {
            $content = file_get_contents($file);
            
            // Reemplazar sección de médicos con áreas
            $content = str_replace($medicos_section, $areas_section, $content);
            
            // Corregir sesiones
            $content = str_replace($session_fix_old, $session_fix_new, $content);
            
            file_put_contents($file, $content);
            echo "Actualizado: $file\n";
        }
    }
}

echo "¡Actualización completada!\n";
?>
