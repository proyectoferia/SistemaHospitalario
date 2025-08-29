-- EMERGENCIA: Solución inmediata para error de rango
-- Ejecutar línea por línea en phpMyAdmin

-- 1. Seleccionar base de datos
USE citas_medicas;

-- 2. Ver estructura actual (para confirmar el problema)
DESCRIBE patients;

-- 3. Modificar columna idpa en patients
ALTER TABLE patients MODIFY idpa BIGINT(20) NOT NULL AUTO_INCREMENT;

-- 4. Modificar columna idpa en events para consistencia
ALTER TABLE events MODIFY idpa BIGINT(20) NOT NULL;

-- 5. Confirmar cambios
DESCRIBE patients;
DESCRIBE events;

-- 6. Opcional: Resetear contador si es necesario
-- ALTER TABLE patients AUTO_INCREMENT = 1;
