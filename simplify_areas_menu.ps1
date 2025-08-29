# Script para simplificar el menú de Áreas Hospitalarias en todos los archivos PHP
$frontendPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend"

# Patrón a buscar (menú completo con subáreas)
$oldPattern = @'
            <li>
                <a href="#"><i class='bx bxs-buildings icon' ></i> Áreas Hospitalarias <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../areas/mostrar.php">Todas las áreas</a></li>
                    <li><a href="../areas/emergencia.php">Emergencia</a></li>
                    <li><a href="../areas/consulta_externa.php">Consulta Externa</a></li>
                    <li><a href="../areas/cardiologia.php">Cardiología</a></li>
                    <li><a href="../areas/pediatria.php">Pediatría</a></li>
                    <li><a href="../areas/ginecologia.php">Ginecología</a></li>
                    <li><a href="../areas/neurologia.php">Neurología</a></li>
                    <li><a href="../areas/oftalmologia.php">Oftalmología</a></li>
                    <li><a href="../areas/dermatologia.php">Dermatología</a></li>
                    <li><a href="../areas/traumatologia.php">Traumatología</a></li>
                    <li><a href="../areas/medicina_interna.php">Medicina Interna</a></li>
                </ul>
            </li>
'@

# Patrón de reemplazo (menú simplificado)
$newPattern = @'
            <li>
                <a href="../areas/mostrar.php"><i class='bx bxs-buildings icon' ></i> Áreas Hospitalarias</a>
            </li>
'@

# Buscar todos los archivos PHP
Get-ChildItem -Path $frontendPath -Recurse -Include "*.php" | ForEach-Object {
    $filePath = $_.FullName
    $content = Get-Content $filePath -Raw -Encoding UTF8
    
    # Reemplazar el patrón si existe
    if ($content -match [regex]::Escape($oldPattern)) {
        $content = $content -replace [regex]::Escape($oldPattern), $newPattern
        Set-Content $filePath $content -Encoding UTF8
        Write-Host "Actualizado: $($_.Name) en $($_.Directory.Name)"
    }
}

Write-Host "Simplificación del menú de áreas completada en todos los módulos."
