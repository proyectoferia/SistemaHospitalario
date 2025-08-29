-- Script para corregir el problema de rango en la columna idpa
-- Este script asegura que la columna idpa tenga el tipo de datos correcto

-- 1. Verificar la estructura actual de la tabla patients
DESCRIBE patients;

-- 2. Modificar la columna idpa para asegurar que sea INT(11) con AUTO_INCREMENT
ALTER TABLE `patients` MODIFY `idpa` INT(11) NOT NULL AUTO_INCREMENT;

-- 3. Verificar el valor actual del AUTO_INCREMENT
SELECT AUTO_INCREMENT FROM information_schema.tables 
WHERE table_name = 'patients' AND table_schema = DATABASE();

-- 4. Si es necesario, resetear el AUTO_INCREMENT a un valor seguro
-- ALTER TABLE `patients` AUTO_INCREMENT = 1;

-- 5. Verificar que no haya valores duplicados o problemáticos
SELECT idpa, COUNT(*) as count FROM patients GROUP BY idpa HAVING count > 1;

-- 6. Verificar los valores máximos actuales
SELECT MAX(idpa) as max_idpa FROM patients;
