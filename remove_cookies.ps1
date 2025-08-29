# Script para eliminar código de cookies de todos los archivos PHP
$frontendPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend"

# Buscar todos los archivos PHP
Get-ChildItem -Path $frontendPath -Recurse -Include "*.php" | ForEach-Object {
    $filePath = $_.FullName
    $content = Get-Content $filePath -Raw -Encoding UTF8
    
    # Eliminar código de cookies con múltiples patrones
    $content = $content -replace '(?s)\s*//\s*Cookie management.*?window\.onload.*?};\s*', ''
    $content = $content -replace '(?s)\s*let popUp = document\.getElementById\("cookiePopup"\);.*?checkCookie\(\);\s*}\s*\);\s*};\s*', ''
    $content = $content -replace '(?s)\s*<script type="text/javascript">\s*let popUp = document\.getElementById\("cookiePopup"\);.*?</script>\s*', ''
    $content = $content -replace '(?s)\s*<!-- Cookie Popup Script -->.*?</script>\s*', ''
    
    # Guardar el archivo modificado
    Set-Content $filePath $content -Encoding UTF8
    Write-Host "Procesado: $($_.Name)"
}

Write-Host "Eliminación de código de cookies completada."
