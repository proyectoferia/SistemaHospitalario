-- Script para diagnosticar y corregir el error de rango en idpa
-- SQLSTATE[22003]: Numeric value out of range: 167 Out of range value for column 'idpa'

-- 1. Verificar la estructura actual de la tabla patients
SHOW CREATE TABLE patients;

-- 2. Verificar el tipo de datos de la columna idpa
SELECT 
    COLUMN_NAME, 
    DATA_TYPE, 
    COLUMN_TYPE, 
    IS_NULLABLE, 
    COLUMN_DEFAULT,
    EXTRA
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'patients' AND COLUMN_NAME = 'idpa';

-- 3. Verificar los valores actuales en la tabla
SELECT MIN(idpa) as min_idpa, MAX(idpa) as max_idpa, COUNT(*) as total_records FROM patients;

-- 4. Verificar el valor del AUTO_INCREMENT
SELECT AUTO_INCREMENT FROM information_schema.tables 
WHERE table_name = 'patients' AND table_schema = DATABASE();

-- 5. Corregir la columna idpa para asegurar que sea INT(11) con AUTO_INCREMENT
ALTER TABLE `patients` MODIFY `idpa` INT(11) NOT NULL AUTO_INCREMENT;

-- 6. Si hay problemas con el AUTO_INCREMENT, resetear a un valor seguro
-- Uncomment the next line if needed:
-- ALTER TABLE `patients` AUTO_INCREMENT = 1;

-- 7. Verificar que la corrección funcionó
SHOW CREATE TABLE patients;
