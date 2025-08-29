-- Script para crear usuarios para los médicos existentes
-- Ejecutar este script en la base de datos citas_medicas

-- Crear usuario para Roberto (si existe como médico)
INSERT INTO `users` (`username`, `name`, `email`, `password`, `rol`, `created_at`) VALUES
('medicoroberto', 'Dr. Roberto', 'roberto@hospital.com', MD5('roberto123'), '3', NOW());

-- Crear usuario para Benito Cabrera (ya existe como médico ID 11)
INSERT INTO `users` (`username`, `name`, `email`, `password`, `rol`, `created_at`) VALUES
('medicobento', 'Dr. Benito Cabrera', 'benito.cabrera@hospital.com', MD5('benito123'), '3', NOW());

-- Crear usuario para Ramon Rulei (ya existe como médico ID 10, pero actualizar su info)
-- Primero verificar si ya tiene usuario, si no, crearlo
INSERT INTO `users` (`username`, `name`, `email`, `password`, `rol`, `created_at`) VALUES
('medicoramon', 'Dr. Ramon Rulei', 'ramon.rulei@hospital.com', MD5('ramon123'), '3', NOW());

-- Actualizar la tabla doctor para vincular los usuarios
-- Para Benito Cabrera
UPDATE `doctor` SET 
    `username` = 'medicobento',
    `password` = MD5('benito123'),
    `rol` = '3'
WHERE `idodc` = 11;

-- Para Ramon Rulei (si necesita actualización)
UPDATE `doctor` SET 
    `username` = 'medicoramon',
    `password` = MD5('ramon123'),
    `rol` = '3'
WHERE `idodc` = 10;

-- Agregar médico Roberto si no existe
INSERT INTO `doctor` (`ceddoc`, `nodoc`, `apdoc`, `nomesp`, `direcd`, `sexd`, `phd`, `nacd`, `corr`, `username`, `password`, `rol`, `state`, `fere`) VALUES
('12345678', 'Roberto', 'García Mendez', 'Medicina General', 'Calle Principal 123', 'Masculino', '+504 98765432', '1985-06-15', 'roberto@hospital.com', 'medicoroberto', MD5('roberto123'), '3', '1', NOW());

-- Verificar los usuarios creados
-- SELECT * FROM users WHERE rol = '3';
-- SELECT * FROM doctor WHERE username IS NOT NULL AND username != '';
