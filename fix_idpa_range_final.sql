-- Script para solucionar el error SQLSTATE[22003]: Numeric value out of range
-- Este error ocurre cuando el valor de idpa excede el rango permitido

USE citas_medicas;

-- 1. Verificar la estructura actual de la tabla patients
DESCRIBE patients;

-- 2. Verificar el rango actual de valores en idpa
SELECT MIN(idpa) as min_idpa, MAX(idpa) as max_idpa, COUNT(*) as total_pacientes FROM patients;

-- 3. Verificar el AUTO_INCREMENT actual
SELECT AUTO_INCREMENT FROM information_schema.tables 
WHERE table_name = 'patients' AND table_schema = 'citas_medicas';

-- 4. Modificar la columna idpa para asegurar que sea BIGINT (rango más amplio)
ALTER TABLE `patients` MODIFY `idpa` BIGINT(20) NOT NULL AUTO_INCREMENT;

-- 5. También modificar la columna idpa en la tabla events para mantener consistencia
ALTER TABLE `events` MODIFY `idpa` BIGINT(20) NOT NULL;

-- 6. Resetear el AUTO_INCREMENT a un valor seguro si es necesario
-- ALTER TABLE `patients` AUTO_INCREMENT = 1;

-- 7. Verificar que los cambios se aplicaron correctamente
DESCRIBE patients;
DESCRIBE events;

-- 8. Mostrar el nuevo AUTO_INCREMENT
SELECT AUTO_INCREMENT FROM information_schema.tables 
WHERE table_name = 'patients' AND table_schema = 'citas_medicas';
