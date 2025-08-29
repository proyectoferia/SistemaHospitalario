# Script para simplificar menús de áreas en todos los módulos
$frontendPath = "c:\Users\genes\OneDrive\Desktop\citas medica\frontend"

# Lista de archivos a procesar basada en la búsqueda
$filesToUpdate = @(
    "recursos\laboratorios_nuevo.php",
    "recursos\laboratorios_info.php", 
    "recursos\laboratorios_editar.php",
    "recursos\laboratiorios.php",
    "recursos\enfermera_nuevo.php",
    "recursos\enfermera_info.php",
    "recursos\enfermera_editar.php",
    "recursos\enfermera.php",
    "profile\mostrar.php",
    "pacientes\password.php",
    "pacientes\pago.php",
    "pacientes\nuevo.php",
    "pacientes\mostrar.php",
    "pacientes\info.php",
    "pacientes\historial.php",
    "pacientes\editar.php",
    "pacientes\documentos_nuevo.php",
    "pacientes\historia.php",
    "pacientes\documentos.php",
    "pacientes\crear.php",
    "pacientes\pagos.php",
    "inventario\stock.php",
    "inventario\nuevo.php",
    "inventario\mostrar.php",
    "inventario\info.php",
    "inventario\eliminar.php",
    "inventario\editar.php",
    "inventario\documento.php",
    "inventario\checkout.php",
    "inventario\categoria_nuevo.php",
    "inventario\categoria_info.php",
    "inventario\categoria_editar.php",
    "inventario\categoria.php",
    "inventario\cart.php",
    "citas\ticket.php",
    "citas\nuevo.php",
    "citas\mostrar.php",
    "citas\money.php",
    "citas\info.php",
    "citas\documento.php",
    "citas\calendario.php",
    "citas\buscar_paciente.php",
    "admin\escritorio.php",
    "ajustes\mostrar.php",
    "ajustes\idioma.php",
    "ajustes\base.php"
)

foreach ($file in $filesToUpdate) {
    $fullPath = Join-Path $frontendPath $file
    
    if (Test-Path $fullPath) {
        $content = Get-Content $fullPath -Raw -Encoding UTF8
        
        # Patrón 1: Menú completo con todas las áreas (icono bxs-buildings)
        $pattern1 = '(?s)<li>\s*<a href="#"><i class=''bx bxs-buildings icon'' ></i> Áreas Hospitalarias <i class=''bx bx-chevron-right icon-right'' ></i></a>\s*<ul class="side-dropdown">.*?</ul>\s*</li>'
        $replacement1 = '<li>
                <a href="../areas/mostrar.php"><i class=''bx bxs-buildings icon'' ></i> Áreas Hospitalarias</a>
            </li>'
        
        # Patrón 2: Menú completo con todas las áreas (icono bxs-building-house)
        $pattern2 = '(?s)<li>\s*<a href="#"><i class=''bx bxs-building-house icon'' ></i> Áreas Hospitalarias <i class=''bx bx-chevron-right icon-right'' ></i></a>\s*<ul class="side-dropdown">.*?</ul>\s*</li>'
        $replacement2 = '<li>
                <a href="../areas/mostrar.php"><i class=''bx bxs-building-house icon'' ></i> Áreas Hospitalarias</a>
            </li>'
        
        $updated = $false
        
        if ($content -match $pattern1) {
            $content = $content -replace $pattern1, $replacement1
            $updated = $true
        }
        
        if ($content -match $pattern2) {
            $content = $content -replace $pattern2, $replacement2
            $updated = $true
        }
        
        if ($updated) {
            Set-Content $fullPath $content -Encoding UTF8
            Write-Host "Actualizado: $file"
        }
    }
}

Write-Host "Actualización de menús completada."
