# Script simplificado para actualizar menús de áreas
$frontendPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend"

Get-ChildItem -Path $frontendPath -Recurse -Include "*.php" | ForEach-Object {
    $file = $_.FullName
    $content = Get-Content $file -Raw -Encoding UTF8
    $updated = $false
    
    # Patrón 1: icono bxs-building-house
    if ($content -match "(?s)<li>\s*<a href=`"#`"><i class='bx bxs-building-house icon' ></i> Áreas Hospitalarias.*?</ul>\s*</li>") {
        $content = $content -replace "(?s)<li>\s*<a href=`"#`"><i class='bx bxs-building-house icon' ></i> Áreas Hospitalarias.*?</ul>\s*</li>", @"
            <li>
                <a href="../areas/mostrar.php"><i class='bx bxs-building-house icon' ></i> Áreas Hospitalarias</a>
            </li>
"@
        $updated = $true
    }
    
    # Patrón 2: icono bxs-buildings
    if ($content -match "(?s)<li>\s*<a href=`"#`"><i class='bx bxs-buildings icon' ></i> Áreas Hospitalarias.*?</ul>\s*</li>") {
        $content = $content -replace "(?s)<li>\s*<a href=`"#`"><i class='bx bxs-buildings icon' ></i> Áreas Hospitalarias.*?</ul>\s*</li>", @"
            <li>
                <a href="../areas/mostrar.php"><i class='bx bxs-buildings icon' ></i> Áreas Hospitalarias</a>
            </li>
"@
        $updated = $true
    }
    
    if ($updated) {
        Set-Content $file $content -Encoding UTF8
        Write-Host "Actualizado: $($_.Name)"
    }
}

Write-Host "Proceso completado."
