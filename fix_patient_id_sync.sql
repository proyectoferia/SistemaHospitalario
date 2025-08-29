-- Script para sincronizar IDs de pacientes editados con sus citas existentes
-- Este problema ocurre cuando se edita un paciente y las citas no reconocen el nuevo ID

-- Paso 1: Verificar citas huérfanas (sin paciente válido)
SELECT e.id, e.title, e.idpa, p.nompa, p.apepa 
FROM events e 
LEFT JOIN patients p ON e.idpa = p.idpa 
WHERE p.idpa IS NULL;

-- Paso 2: Mostrar todos los pacientes y sus citas
SELECT p.idpa, p.nompa, p.apepa, 
       COUNT(e.id) as total_citas,
       GROUP_CONCAT(e.title SEPARATOR ', ') as citas
FROM patients p 
LEFT JOIN events e ON p.idpa = e.idpa 
GROUP BY p.idpa, p.nompa, p.apepa
ORDER BY p.idpa;

-- Paso 3: Si hay citas huérfanas, necesitamos identificar a qué paciente pertenecen
-- Esto se debe hacer manualmente comparando nombres o datos del paciente

-- Ejemplo de corrección (ajustar según los datos reales):
-- Si el paciente con ID 3 tiene citas asignadas al ID 1 (que ya no existe)
-- UPDATE events SET idpa = 3 WHERE idpa = 1 AND title LIKE '%NOMBRE_PACIENTE%';

-- Paso 4: Verificar que todas las citas tengan un paciente válido
SELECT 'Citas sin paciente válido:' as status, COUNT(*) as cantidad
FROM events e 
LEFT JOIN patients p ON e.idpa = p.idpa 
WHERE p.idpa IS NULL

UNION ALL

SELECT 'Total de citas:' as status, COUNT(*) as cantidad
FROM events;

-- Paso 5: Script de limpieza para eliminar citas huérfanas (USAR CON CUIDADO)
-- DELETE FROM events WHERE idpa NOT IN (SELECT idpa FROM patients);
