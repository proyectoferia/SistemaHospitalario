-- SOLUCIÓN: Error #1833 - Cannot change column 'idpa': used in a foreign key constraint
-- Ejecutar paso a paso en phpMyAdmin

USE citas_medicas;

-- Paso 1: Verificar las claves foráneas existentes
SHOW CREATE TABLE events;

-- Paso 2: Eliminar la clave foránea que impide el cambio
ALTER TABLE events DROP FOREIGN KEY events_ibfk_1;

-- Paso 3: Ahora modificar la columna idpa en patients
ALTER TABLE patients MODIFY idpa BIGINT(20) NOT NULL AUTO_INCREMENT;

-- Paso 4: Modificar la columna idpa en events para mantener consistencia
ALTER TABLE events MODIFY idpa BIGINT(20) NOT NULL;

-- Paso 5: Recrear la clave foránea con el nuevo tipo de dato
ALTER TABLE events ADD CONSTRAINT events_ibfk_1 
FOREIGN KEY (idpa) REFERENCES patients(idpa) ON DELETE CASCADE ON UPDATE CASCADE;

-- Paso 6: Verificar que todo esté correcto
SHOW CREATE TABLE patients;
SHOW CREATE TABLE events;

-- Paso 7: Opcional - Resetear AUTO_INCREMENT si es necesario
ALTER TABLE patients AUTO_INCREMENT = 1;
