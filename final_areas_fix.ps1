# Script final para eliminar todos los submenús de áreas hospitalarias
$frontendPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend"

Get-ChildItem -Path $frontendPath -Recurse -Include "*.php" | ForEach-Object {
    $file = $_.FullName
    $content = Get-Content $file -Raw -Encoding UTF8
    $originalContent = $content
    
    # Eliminar cualquier menú desplegable de Áreas Hospitalarias
    # Patrón más amplio que capture cualquier variación
    $content = $content -replace '(?s)<li>\s*<a href="#"><i class=''bx bx[^'']*'' ></i>\s*Áreas Hospitalarias\s*<i class=''bx bx-chevron-right[^'']*'' ></i></a>\s*<ul class="side-dropdown">.*?</ul>\s*</li>', '<li>
                <a href="../areas/mostrar.php"><i class=''bx bxs-buildings icon'' ></i> Áreas Hospitalarias</a>
            </li>'
    
    if ($content -ne $originalContent) {
        Set-Content $file $content -Encoding UTF8
        Write-Host "Actualizado: $($_.Name)"
    }
}

Write-Host "Eliminación completa de submenús de áreas finalizada."
