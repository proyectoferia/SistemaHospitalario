-- Script simplificado para resolver el error 121 "Duplicate key"
-- Ejecutar paso a paso en phpMyAdmin

-- Paso 1: Crear tabla medical_areas si no existe
CREATE TABLE IF NOT EXISTS `medical_areas` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci,
  `estado` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_area`),
  UNIQUE KEY `nombre_area` (`nombre_area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Paso 2: Insertar áreas médicas
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

-- Paso 3: Agregar columna id_area a doctor (si no existe)
ALTER TABLE `doctor` ADD COLUMN IF NOT EXISTS `id_area` int(11) DEFAULT NULL;

-- Paso 4: Agregar columna id_area a events (si no existe)  
ALTER TABLE `events` ADD COLUMN IF NOT EXISTS `id_area` int(11) DEFAULT NULL;

-- Paso 5: Actualizar médicos con su área
UPDATE `doctor` d 
INNER JOIN `medical_areas` ma ON d.nomesp = ma.nombre_area 
SET d.id_area = ma.id_area;

-- Paso 6: Actualizar citas con área del médico
UPDATE `events` e 
INNER JOIN `doctor` d ON e.idodc = d.idodc 
SET e.id_area = d.id_area;
