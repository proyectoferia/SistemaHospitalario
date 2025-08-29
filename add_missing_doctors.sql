-- Script para agregar médicos faltantes para las especialidades sin doctores
-- Esto sincronizará las áreas médicas del formulario de citas con los doctores disponibles

-- Insertar médicos para las especialidades faltantes
INSERT INTO `doctor` (`ceddoc`, `nodoc`, `apdoc`, `nomesp`, `direcd`, `sexd`, `phd`, `nacd`, `corr`, `username`, `password`, `rol`, `state`, `fere`) VALUES
-- Neurología
('15432167', 'María Elena', 'Rodríguez López', 'Neurología', 'Av. Neurológica 456', 'Femenino', '+504 87654321', '1980-03-22', 'maria.neurologia@hospital.com', 'neurologa01', MD5('neuro123'), '3', '1', NOW()),

-- Traumatología  
('23456789', 'Carlos Alberto', 'Mendoza Ruiz', 'Traumatología', 'Calle Traumatología 789', 'Masculino', '+504 76543210', '1978-11-15', 'carlos.trauma@hospital.com', 'traumatologo01', MD5('trauma123'), '3', '1', NOW()),

-- Pediatría
('34567890', 'Ana Sofía', 'Hernández Castro', 'Pediatría', 'Av. Infantil 321', 'Femenino', '+504 65432109', '1985-07-08', 'ana.pediatra@hospital.com', 'pediatra01', MD5('pediatra123'), '3', '1', NOW()),

-- Ginecología
('45678901', 'Patricia Isabel', 'Morales Vega', 'Ginecología', 'Calle Ginecológica 654', 'Femenino', '+504 54321098', '1982-09-12', 'patricia.gineco@hospital.com', 'ginecologa01', MD5('gineco123'), '3', '1', NOW()),

-- Dermatología
('56789012', 'Luis Fernando', 'Jiménez Soto', 'Dermatología', 'Av. Dermatológica 987', 'Masculino', '+504 43210987', '1979-05-25', 'luis.dermato@hospital.com', 'dermatologo01', MD5('dermato123'), '3', '1', NOW()),

-- Oftalmología
('67890123', 'Carmen Lucía', 'Vargas Peña', 'Oftalmología', 'Calle Oftálmica 147', 'Femenino', '+504 32109876', '1983-12-03', 'carmen.oftalmo@hospital.com', 'oftalmologa01', MD5('oftalmo123'), '3', '1', NOW()),

-- Medicina Interna
('78901234', 'Diego Alejandro', 'Ramírez Torres', 'Medicina Interna', 'Av. Medicina Interna 258', 'Masculino', '+504 21098765', '1981-04-18', 'diego.interna@hospital.com', 'internista01', MD5('interna123'), '3', '1', NOW());

-- Crear usuarios correspondientes en la tabla users
INSERT INTO `users` (`username`, `password`, `rol`) VALUES
('neurologa01', MD5('neuro123'), '3'),
('traumatologo01', MD5('trauma123'), '3'),
('pediatra01', MD5('pediatra123'), '3'),
('ginecologa01', MD5('gineco123'), '3'),
('dermatologo01', MD5('dermato123'), '3'),
('oftalmologa01', MD5('oftalmo123'), '3'),
('internista01', MD5('interna123'), '3');

-- Verificar los médicos insertados
SELECT idodc, nodoc, apdoc, nomesp, username FROM doctor ORDER BY nomesp;
