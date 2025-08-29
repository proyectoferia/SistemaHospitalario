-- SOLUCIÓN URGENTE: Corregir error SQLSTATE[22003] 
-- Ejecutar INMEDIATAMENTE en phpMyAdmin o cliente MySQL

USE citas_medicas;

-- Paso 1: Cambiar tipo de dato de idpa a BIGINT en tabla patients
ALTER TABLE `patients` MODIFY `idpa` BIGINT(20) NOT NULL AUTO_INCREMENT;

-- Paso 2: Cambiar tipo de dato de idpa a BIGINT en tabla events  
ALTER TABLE `events` MODIFY `idpa` BIGINT(20) NOT NULL;

-- Paso 3: Verificar que los cambios se aplicaron
SHOW CREATE TABLE patients;
SHOW CREATE TABLE events;

-- Paso 4: Resetear AUTO_INCREMENT si es necesario
ALTER TABLE `patients` AUTO_INCREMENT = 1;

-- MENSAJE: Después de ejecutar este script, el error debería desaparecer
