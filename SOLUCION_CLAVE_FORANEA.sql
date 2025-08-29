-- EJECUTAR PASO A PASO EN phpMyAdmin
-- Solución para error #1833 - Cannot change column 'idpa': used in a foreign key constraint

USE citas_medicas;

-- PASO 1: Eliminar la clave foránea que bloquea el cambio
ALTER TABLE events DROP FOREIGN KEY events_ibfk_1;

-- PASO 2: Modificar columna idpa en tabla patients
ALTER TABLE patients MODIFY idpa BIGINT(20) NOT NULL AUTO_INCREMENT;

-- PASO 3: Modificar columna idpa en tabla events
ALTER TABLE events MODIFY idpa BIGINT(20) NOT NULL;

-- PASO 4: Recrear la clave foránea
ALTER TABLE events ADD CONSTRAINT events_ibfk_1 
FOREIGN KEY (idpa) REFERENCES patients(idpa) ON DELETE CASCADE ON UPDATE CASCADE;

-- PASO 5: Resetear contador
ALTER TABLE patients AUTO_INCREMENT = 1;
