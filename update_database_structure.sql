-- Script para actualizar la estructura de la base de datos
-- para soportar DNIs hondureños de 13 dígitos

USE citas_medicas;

-- Modificar el campo numhs para soportar DNIs hondureños (13 dígitos)
ALTER TABLE `patients` MODIFY `numhs` VARCHAR(20) NOT NULL;

-- Agregar índice para mejorar la búsqueda por DNI
ALTER TABLE `patients` ADD INDEX `idx_numhs` (`numhs`);

-- Insertar datos de prueba con DNI hondureño (sin especificar idpa para que use AUTO_INCREMENT)
INSERT INTO `patients` (`numhs`, `nompa`, `apepa`, `direc`, `sex`, `grup`, `phon`, `cump`, `state`, `fere`) VALUES
('0101200900358', 'Juan Carlos', 'López García', 'Col. Kennedy, Tegucigalpa', 'Masculino', 'O+', '+504 2234-5678', '2009-01-01', '1', NOW());

-- Verificar la inserción
SELECT * FROM `patients` WHERE `numhs` = '0101200900358';
