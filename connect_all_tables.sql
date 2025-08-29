-- Script para conectar correctamente las tablas de pacientes, médicos, áreas y citas
-- Esto asegura la integridad referencial entre todas las entidades del sistema

-- Paso 1: Crear tabla de áreas médicas/especialidades si no existe
CREATE TABLE IF NOT EXISTS `medical_areas` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci,
  `estado` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_area`),
  UNIQUE KEY `nombre_area` (`nombre_area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Paso 2: Insertar las áreas médicas disponibles
INSERT IGNORE INTO `medical_areas` (`nombre_area`, `descripcion`) VALUES
('Cardiología', 'Especialidad médica que se encarga del estudio, diagnóstico y tratamiento de las enfermedades del corazón'),
('Neurología', 'Especialidad médica que trata los trastornos del sistema nervioso'),
('Traumatología', 'Especialidad médica que se dedica al estudio de las lesiones del aparato locomotor'),
('Pediatría', 'Especialidad médica que estudia al niño y sus enfermedades'),
('Ginecología', 'Especialidad médica que trata las enfermedades del sistema reproductor femenino'),
('Medicina General', 'Atención médica integral y continuada para toda la familia'),
('Dermatología', 'Especialidad médica que se dedica al estudio de la estructura y función de la piel'),
('Oftalmología', 'Especialidad médica que estudia las enfermedades de los ojos'),
('Endocrinología', 'Especialidad médica que estudia las hormonas y las glándulas que las producen'),
('Medicina Interna', 'Especialidad médica que se dedica a la atención integral del adulto enfermo');

-- Paso 3: Agregar columna id_area a la tabla doctor si no existe
ALTER TABLE `doctor` ADD COLUMN IF NOT EXISTS `id_area` int(11) DEFAULT NULL AFTER `nomesp`;

-- Paso 4: Actualizar los médicos existentes con su área correspondiente
UPDATE `doctor` d 
INNER JOIN `medical_areas` ma ON d.nomesp = ma.nombre_area 
SET d.id_area = ma.id_area;

-- Paso 5: Agregar columna id_area a la tabla events si no existe
ALTER TABLE `events` ADD COLUMN IF NOT EXISTS `id_area` int(11) DEFAULT NULL AFTER `idodc`;

-- Paso 6: Actualizar las citas existentes con el área del médico
UPDATE `events` e 
INNER JOIN `doctor` d ON e.idodc = d.idodc 
SET e.id_area = d.id_area;

-- Paso 7: Eliminar foreign keys existentes para recrearlas correctamente
-- Primero verificar qué foreign keys existen
SET @sql = (SELECT CONCAT('ALTER TABLE `events` DROP FOREIGN KEY `', CONSTRAINT_NAME, '`;')
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'events' 
            AND CONSTRAINT_NAME != 'PRIMARY'
            AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1);

-- Ejecutar solo si existe
SET @sql = IFNULL(@sql, 'SELECT "No foreign keys to drop" as status;');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Repetir para todas las foreign keys
SET @sql = (SELECT GROUP_CONCAT(CONCAT('ALTER TABLE `events` DROP FOREIGN KEY `', CONSTRAINT_NAME, '`') SEPARATOR '; ')
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'events' 
            AND CONSTRAINT_NAME != 'PRIMARY'
            AND REFERENCED_TABLE_NAME IS NOT NULL);

-- Limpiar también doctor
SET @sql2 = (SELECT GROUP_CONCAT(CONCAT('ALTER TABLE `doctor` DROP FOREIGN KEY `', CONSTRAINT_NAME, '`') SEPARATOR '; ')
             FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
             WHERE TABLE_SCHEMA = DATABASE() 
             AND TABLE_NAME = 'doctor' 
             AND CONSTRAINT_NAME != 'PRIMARY'
             AND REFERENCED_TABLE_NAME IS NOT NULL);

-- Paso 8: Crear todas las foreign keys necesarias
-- Relación events -> patients
ALTER TABLE `events` 
ADD CONSTRAINT `fk_events_patients` 
FOREIGN KEY (`idpa`) REFERENCES `patients` (`idpa`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Relación events -> doctor
ALTER TABLE `events` 
ADD CONSTRAINT `fk_events_doctor` 
FOREIGN KEY (`idodc`) REFERENCES `doctor` (`idodc`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Relación events -> medical_areas
ALTER TABLE `events` 
ADD CONSTRAINT `fk_events_areas` 
FOREIGN KEY (`id_area`) REFERENCES `medical_areas` (`id_area`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Relación doctor -> medical_areas
ALTER TABLE `doctor` 
ADD CONSTRAINT `fk_doctor_areas` 
FOREIGN KEY (`id_area`) REFERENCES `medical_areas` (`id_area`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Relación events -> laboratory (mantener existente)
ALTER TABLE `events` 
ADD CONSTRAINT `fk_events_laboratory` 
FOREIGN KEY (`idlab`) REFERENCES `laboratory` (`idlab`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Paso 9: Crear índices para mejorar rendimiento
CREATE INDEX IF NOT EXISTS `idx_doctor_area` ON `doctor` (`id_area`);
CREATE INDEX IF NOT EXISTS `idx_events_area` ON `events` (`id_area`);
CREATE INDEX IF NOT EXISTS `idx_events_patient` ON `events` (`idpa`);
CREATE INDEX IF NOT EXISTS `idx_events_doctor` ON `events` (`idodc`);

-- Paso 10: Verificar las conexiones creadas
SELECT 'Verificación de conexiones:' as status;

-- Mostrar médicos con sus áreas
SELECT d.idodc, d.nodoc, d.apdoc, d.nomesp, ma.nombre_area, ma.id_area
FROM doctor d 
LEFT JOIN medical_areas ma ON d.id_area = ma.id_area
ORDER BY ma.nombre_area;

-- Mostrar citas con paciente, médico y área
SELECT e.id, e.title, 
       CONCAT(p.nompa, ' ', p.apepa) as paciente,
       CONCAT(d.nodoc, ' ', d.apdoc) as medico,
       ma.nombre_area as area,
       e.start as fecha_cita
FROM events e
LEFT JOIN patients p ON e.idpa = p.idpa
LEFT JOIN doctor d ON e.idodc = d.idodc  
LEFT JOIN medical_areas ma ON e.id_area = ma.id_area
ORDER BY e.start;

-- Mostrar estadísticas de conexiones
SELECT 
    (SELECT COUNT(*) FROM patients) as total_pacientes,
    (SELECT COUNT(*) FROM doctor) as total_medicos,
    (SELECT COUNT(*) FROM medical_areas) as total_areas,
    (SELECT COUNT(*) FROM events) as total_citas,
    (SELECT COUNT(*) FROM events WHERE idpa IS NOT NULL AND idodc IS NOT NULL) as citas_conectadas;
