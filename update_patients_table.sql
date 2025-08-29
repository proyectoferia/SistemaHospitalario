-- Script para actualizar la estructura de la tabla patients
-- Solucionando el problema de campos y longitudes

-- 1. Aumentar la longitud del campo numhs de 8 a 20 caracteres para DNI/documentos
ALTER TABLE `patients` MODIFY `numhs` varchar(20) COLLATE utf8_unicode_ci NOT NULL;

-- 2. Agregar campo para número de paciente (ID único del hospital)
ALTER TABLE `patients` ADD COLUMN `patient_number` varchar(15) COLLATE utf8_unicode_ci AFTER `idpa`;

-- 3. Generar números de paciente automáticamente para registros existentes
UPDATE `patients` SET `patient_number` = CONCAT('P', LPAD(idpa, 6, '0')) WHERE `patient_number` IS NULL;

-- 4. Hacer el campo patient_number obligatorio después de llenar los datos
ALTER TABLE `patients` MODIFY `patient_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL;

-- 5. Crear índice único para el número de paciente
ALTER TABLE `patients` ADD UNIQUE KEY `unique_patient_number` (`patient_number`);

-- Comentarios sobre los campos:
-- idpa: ID primario auto-increment (interno del sistema)
-- patient_number: Número de paciente visible (P000001, P000002, etc.)
-- numhs: DNI/Documento de identidad (ahora hasta 20 caracteres)
