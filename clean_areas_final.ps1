# Script final para limpiar todos los menús de áreas
$frontendPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend"

# Lista específica de archivos que necesitan actualización
$filesToProcess = @(
    "recursos\enfermera_nuevo.php",
    "recursos\enfermera_info.php", 
    "recursos\enfermera_editar.php",
    "recursos\laboratiorios.php",
    "recursos\laboratorios_nuevo.php",
    "recursos\laboratorios_info.php",
    "recursos\laboratorios_editar.php",
    "profile\mostrar.php",
    "pacientes\crear.php",
    "pacientes\documentos.php",
    "pacientes\documentos_nuevo.php",
    "pacientes\editar.php",
    "pacientes\historia.php",
    "pacientes\historial.php",
    "pacientes\info.php",
    "pacientes\nuevo.php",
    "pacientes\pago.php",
    "pacientes\password.php",
    "medicos\password.php"
)

foreach ($relativeFile in $filesToProcess) {
    $fullPath = Join-Path $frontendPath $relativeFile
    
    if (Test-Path $fullPath) {
        $content = Get-Content $fullPath -Raw -Encoding UTF8
        $originalContent = $content
        
        # Reemplazar menús con solo "Todas las áreas"
        $content = $content -replace '(?s)<li>\s*<a href="#"><i class=''bx bxs-buildings icon'' ></i> Áreas Hospitalarias <i class=''bx bx-chevron-right icon-right'' ></i></a>\s*<ul class="side-dropdown">\s*<li><a href="../areas/mostrar.php">Todas las áreas</a></li>\s*</ul>\s*</li>', '<li>
                <a href="../areas/mostrar.php"><i class=''bx bxs-buildings icon'' ></i> Áreas Hospitalarias</a>
            </li>'
        
        # Reemplazar menús con icono building-house
        $content = $content -replace '(?s)<li>\s*<a href="#"><i class=''bx bxs-building-house icon'' ></i> Áreas Hospitalarias <i class=''bx bx-chevron-right icon-right'' ></i></a>\s*<ul class="side-dropdown">.*?</ul>\s*</li>', '<li>
                <a href="../areas/mostrar.php"><i class=''bx bxs-building-house icon'' ></i> Áreas Hospitalarias</a>
            </li>'
        
        if ($content -ne $originalContent) {
            Set-Content $fullPath $content -Encoding UTF8
            Write-Host "Actualizado: $relativeFile"
        }
    }
}

Write-Host "Limpieza final completada."
