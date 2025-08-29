<?php
/**
 * Script para actualizar todas las referencias de swal() a Swal.fire() en el sistema
 * Ejecutar desde la raíz del proyecto
 */

function updateSwalReferences($directory) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    $updatedFiles = 0;
    $totalReplacements = 0;
    
    foreach ($iterator as $file) {
        if ($file->isFile() && in_array($file->getExtension(), ['php', 'js', 'html'])) {
            $content = file_get_contents($file->getPathname());
            $originalContent = $content;
            
            // Reemplazos principales
            $replacements = [
                // Swal.fire({ -> Swal.fire({
                '/\bswal\s*\(\s*\{/' => 'Swal.fire({',
                
                // type: -> icon:
                '/(\s+)type:\s*([\'"])/' => '$1icon: $2',
                
                // Swal.showLoading() -> Swal.showLoading()
                '/\bswal\.showLoading\s*\(\s*\)/' => 'Swal.showLoading()',
                
                // didOpen: -> didOpen:
                '/(\s+)onOpen:\s*/' => '$1didOpen: ',
                
                // Casos específicos comunes
                '/swal\(\s*[\'"]([^\'\"]+)[\'"]\s*,\s*[\'"]([^\'\"]+)[\'"]\s*,\s*[\'"]([^\'\"]+)[\'"]\s*\)/' => 'Swal.fire("$1", "$2", "$3")',
            ];
            
            foreach ($replacements as $pattern => $replacement) {
                $newContent = preg_replace($pattern, $replacement, $content);
                if ($newContent !== $content) {
                    $content = $newContent;
                    $totalReplacements++;
                }
            }
            
            // Si hubo cambios, guardar el archivo
            if ($content !== $originalContent) {
                file_put_contents($file->getPathname(), $content);
                $updatedFiles++;
                echo "✅ Actualizado: " . $file->getPathname() . "\n";
            }
        }
    }
    
    echo "\n📊 Resumen:\n";
    echo "- Archivos actualizados: $updatedFiles\n";
    echo "- Total de reemplazos: $totalReplacements\n";
}

// Ejecutar actualización
echo "🔄 Iniciando actualización masiva de swal() a Swal.fire()...\n\n";
updateSwalReferences(__DIR__);
echo "\n✅ Actualización completada!\n";
?>
