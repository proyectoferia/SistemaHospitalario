# Script para agregar la sección de Médicos a todos los archivos PHP de pacientes
$pacientesPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend\pacientes"
$files = Get-ChildItem "$pacientesPath\*.php"

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    
    if ($content -match "Áreas Hospitalarias") {
        # Buscar el patrón específico y reemplazarlo
        $pattern = '(\s+<li>\s+<a href="#"><i class=''bx bxs-building-house icon'' ></i> Áreas Hospitalarias)'
        $replacement = @"
            <li>
                <a href="#"><i class='bx bxs-user-detail icon' ></i> Médicos <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/nuevo.php">Nuevo médico</a></li>
                    <li><a href="../medicos/especialidades.php">Especialidades</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-building-house icon' ></i> Áreas Hospitalarias
"@
        
        $newContent = $content -replace $pattern, $replacement
        
        if ($newContent -ne $content) {
            Set-Content $file.FullName $newContent -Encoding UTF8
            Write-Host "Actualizado: $($file.Name)"
        }
    }
}

Write-Host "Proceso completado."
