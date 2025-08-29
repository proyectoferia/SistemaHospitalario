<?php
/**
 * Script para actualizar automáticamente los estilos de todas las áreas hospitalarias
 * Aplica el diseño profesional aqua/navy de manera consistente
 */

// Definir los estilos CSS profesionales
$professional_styles = '
    <!-- ESTILOS PROFESIONALES CON AZUL AQUA Y AZUL MARINO -->
    <style>
        :root {
            --aqua-primary: #00BCD4;
            --aqua-light: #26E0F3;
            --aqua-dark: #0099A8;
            --navy-primary: #1565C0;
            --navy-light: #1976D2;
            --navy-dark: #0D47A1;
            --aqua-bg: #E0F7FA;
            --navy-bg: #E3F2FD;
            --white: #FFFFFF;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #EEEEEE;
            --gray-300: #E0E0E0;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-900: #212121;
            --success: #4CAF50;
            --warning: #FF9800;
            --error: #F44336;
            --shadow-light: 0 2px 8px rgba(0, 188, 212, 0.15);
            --shadow-medium: 0 4px 16px rgba(0, 188, 212, 0.2);
            --shadow-heavy: 0 8px 32px rgba(0, 188, 212, 0.25);
        }

        main {
            background: var(--gray-50);
            min-height: 100vh;
            padding: 24px;
        }

        .title {
            background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.2em;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }

        .breadcrumbs {
            background: var(--white);
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: var(--shadow-light);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .breadcrumbs li {
            list-style: none;
        }

        .breadcrumbs a {
            color: var(--gray-600);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumbs a:hover {
            color: var(--aqua-primary);
        }

        .breadcrumbs a.active {
            color: var(--navy-primary);
            font-weight: 600;
        }

        .breadcrumbs .divider {
            color: var(--gray-300);
            margin: 0 4px;
        }

        .area-header {
            background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
            color: var(--white);
            padding: 32px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-heavy);
            position: relative;
            overflow: hidden;
        }

        .area-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--aqua-light) 0%, var(--navy-light) 100%);
        }

        .area-header h1 {
            color: var(--white);
            margin: 0 0 12px 0;
            font-size: 2.5em;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .area-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-size: 1.1em;
            font-weight: 400;
        }

        .tabs-container {
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .tabs {
            display: flex;
            background: var(--gray-100);
            padding: 8px;
            gap: 4px;
        }

        .tab {
            padding: 12px 24px;
            background: transparent;
            color: var(--gray-600);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
        }

        .tab.active {
            background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
            color: var(--white);
            box-shadow: var(--shadow-medium);
        }

        .tab:hover:not(.active) {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .content-data {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-heavy);
            overflow: hidden;
            border: 1px solid var(--gray-200);
        }
        
        .content-data .head {
            background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
            color: var(--white);
            padding: 24px;
            margin: 0;
            position: relative;
        }
        
        .content-data .head::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--aqua-light) 0%, var(--navy-light) 100%);
        }
        
        .content-data .head h3 {
            color: var(--white);
            margin: 0;
            font-size: 1.4em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-container {
            padding: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
        }

        th {
            background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
            color: var(--white);
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-700);
            font-size: 14px;
        }

        tr:hover {
            background: var(--aqua-bg);
        }

        tr:nth-child(even) {
            background: var(--gray-50);
        }

        tr:nth-child(even):hover {
            background: var(--aqua-bg);
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
            margin: 2px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--aqua-primary) 0%, var(--navy-primary) 100%);
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--navy-primary);
            border: 1px solid var(--aqua-primary);
        }

        .btn-secondary:hover {
            background: var(--aqua-primary);
            color: var(--white);
        }

        @media (max-width: 768px) {
            main {
                padding: 16px;
            }
            
            .area-header {
                padding: 24px;
            }
            
            .area-header h1 {
                font-size: 2em;
            }
            
            .tabs {
                flex-wrap: wrap;
            }
            
            .table-container {
                padding: 16px;
                overflow-x: auto;
            }
        }
    </style>';

// Lista de archivos de áreas hospitalarias
$area_files = [
    'cardiologia.php',
    'consulta_externa.php', 
    'dermatologia.php',
    'emergencia.php',
    'ginecologia.php',
    'medicina_interna.php',
    'neurologia.php',
    'oftalmologia.php',
    'pediatria.php',
    'psicologia.php',
    'psiquiatria.php',
    'traumatologia.php'
];

$areas_dir = 'frontend/areas/';
$updated_files = [];
$errors = [];

foreach ($area_files as $file) {
    $file_path = $areas_dir . $file;
    
    if (file_exists($file_path)) {
        try {
            $content = file_get_contents($file_path);
            
            // Buscar y reemplazar la sección de estilos o agregarla
            if (strpos($content, '</title>') !== false) {
                // Si ya tiene estilos personalizados, reemplazarlos
                if (strpos($content, '<!-- ESTILOS PROFESIONALES') !== false) {
                    $pattern = '/<!-- ESTILOS PROFESIONALES.*?<\/style>/s';
                    $content = preg_replace($pattern, $professional_styles, $content);
                } else {
                    // Agregar estilos después del título
                    $content = str_replace('</title>', '</title>' . "\n    " . $professional_styles, $content);
                }
                
                // Guardar el archivo actualizado
                if (file_put_contents($file_path, $content)) {
                    $updated_files[] = $file;
                } else {
                    $errors[] = "No se pudo escribir el archivo: $file";
                }
            } else {
                $errors[] = "Estructura HTML inválida en: $file";
            }
        } catch (Exception $e) {
            $errors[] = "Error procesando $file: " . $e->getMessage();
        }
    } else {
        $errors[] = "Archivo no encontrado: $file";
    }
}

// Mostrar resultados
echo "<h2>Actualización de Estilos de Áreas Hospitalarias</h2>";
echo "<h3>Archivos actualizados exitosamente (" . count($updated_files) . "):</h3>";
foreach ($updated_files as $file) {
    echo "<p>✅ $file</p>";
}

if (!empty($errors)) {
    echo "<h3>Errores encontrados:</h3>";
    foreach ($errors as $error) {
        echo "<p>❌ $error</p>";
    }
}

echo "<p><strong>Proceso completado.</strong></p>";
?>
