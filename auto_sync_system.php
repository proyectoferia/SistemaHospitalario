<?php
/**
 * Sistema de Sincronización Automática
 * Este archivo inicializa automáticamente las tablas y conexiones necesarias
 * sin necesidad de ejecutar SQL manualmente en la base de datos
 */

require_once 'backend/bd/Conexion.php';

class AutoSyncSystem {
    private $connect;
    
    public function __construct($connection) {
        $this->connect = $connection;
    }
    
    /**
     * Inicializar todo el sistema automáticamente
     */
    public function initializeSystem() {
        try {
            $this->createMedicalAreasTable();
            $this->insertMedicalAreas();
            $this->addAreaColumnsToTables();
            $this->syncExistingData();
            $this->createForeignKeys();
            $this->addMissingDoctors();
            
            return [
                'success' => true,
                'message' => 'Sistema inicializado correctamente. Todas las tablas están conectadas y sincronizadas.'
            ];
            
        } catch(Exception $e) {
            return [
                'success' => false,
                'message' => 'Error inicializando sistema: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Crear tabla de áreas médicas
     */
    private function createMedicalAreasTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `medical_areas` (
            `id_area` int(11) NOT NULL AUTO_INCREMENT,
            `nombre_area` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `descripcion` text COLLATE utf8_unicode_ci,
            `estado` tinyint(1) DEFAULT 1,
            `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id_area`),
            UNIQUE KEY `nombre_area` (`nombre_area`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
        
        $this->connect->exec($sql);
    }
    
    /**
     * Insertar áreas médicas
     */
    private function insertMedicalAreas() {
        $areas = [
            ['Cardiología', 'Especialidad médica que se encarga del estudio, diagnóstico y tratamiento de las enfermedades del corazón'],
            ['Neurología', 'Especialidad médica que trata los trastornos del sistema nervioso'],
            ['Traumatología', 'Especialidad médica que se dedica al estudio de las lesiones del aparato locomotor'],
            ['Pediatría', 'Especialidad médica que estudia al niño y sus enfermedades'],
            ['Ginecología', 'Especialidad médica que trata las enfermedades del sistema reproductor femenino'],
            ['Medicina General', 'Atención médica integral y continuada para toda la familia'],
            ['Dermatología', 'Especialidad médica que se dedica al estudio de la estructura y función de la piel'],
            ['Oftalmología', 'Especialidad médica que estudia las enfermedades de los ojos'],
            ['Endocrinología', 'Especialidad médica que estudia las hormonas y las glándulas que las producen'],
            ['Medicina Interna', 'Especialidad médica que se dedica a la atención integral del adulto enfermo']
        ];
        
        $stmt = $this->connect->prepare("INSERT IGNORE INTO `medical_areas` (`nombre_area`, `descripcion`) VALUES (?, ?)");
        
        foreach($areas as $area) {
            $stmt->execute($area);
        }
    }
    
    /**
     * Agregar columnas de área a las tablas
     */
    private function addAreaColumnsToTables() {
        // Agregar columna id_area a doctor
        try {
            $this->connect->exec("ALTER TABLE `doctor` ADD COLUMN `id_area` int(11) DEFAULT NULL AFTER `nomesp`");
        } catch(PDOException $e) {
            // Columna ya existe, continuar
        }
        
        // Agregar columna id_area a events
        try {
            $this->connect->exec("ALTER TABLE `events` ADD COLUMN `id_area` int(11) DEFAULT NULL AFTER `idodc`");
        } catch(PDOException $e) {
            // Columna ya existe, continuar
        }
    }
    
    /**
     * Sincronizar datos existentes
     */
    private function syncExistingData() {
        // Sincronizar médicos con áreas
        $this->connect->exec("UPDATE `doctor` d 
                             INNER JOIN `medical_areas` ma ON d.nomesp = ma.nombre_area 
                             SET d.id_area = ma.id_area");
        
        // Sincronizar citas con áreas
        $this->connect->exec("UPDATE `events` e 
                             INNER JOIN `doctor` d ON e.idodc = d.idodc 
                             SET e.id_area = d.id_area");
    }
    
    /**
     * Crear foreign keys
     */
    private function createForeignKeys() {
        // Eliminar foreign keys existentes
        try {
            $this->connect->exec("ALTER TABLE `events` DROP FOREIGN KEY `events_ibfk_1`");
        } catch(PDOException $e) {}
        try {
            $this->connect->exec("ALTER TABLE `events` DROP FOREIGN KEY `events_ibfk_2`");
        } catch(PDOException $e) {}
        try {
            $this->connect->exec("ALTER TABLE `events` DROP FOREIGN KEY `events_ibfk_3`");
        } catch(PDOException $e) {}
        
        // Crear nuevas foreign keys
        $this->connect->exec("ALTER TABLE `events` 
                             ADD CONSTRAINT `fk_events_patients` 
                             FOREIGN KEY (`idpa`) REFERENCES `patients` (`idpa`) 
                             ON DELETE CASCADE ON UPDATE CASCADE");
        
        $this->connect->exec("ALTER TABLE `events` 
                             ADD CONSTRAINT `fk_events_doctor` 
                             FOREIGN KEY (`idodc`) REFERENCES `doctor` (`idodc`) 
                             ON DELETE CASCADE ON UPDATE CASCADE");
        
        $this->connect->exec("ALTER TABLE `events` 
                             ADD CONSTRAINT `fk_events_areas` 
                             FOREIGN KEY (`id_area`) REFERENCES `medical_areas` (`id_area`) 
                             ON DELETE SET NULL ON UPDATE CASCADE");
        
        $this->connect->exec("ALTER TABLE `doctor` 
                             ADD CONSTRAINT `fk_doctor_areas` 
                             FOREIGN KEY (`id_area`) REFERENCES `medical_areas` (`id_area`) 
                             ON DELETE SET NULL ON UPDATE CASCADE");
    }
    
    /**
     * Agregar médicos faltantes
     */
    private function addMissingDoctors() {
        $doctors = [
            ['15432167', 'María Elena', 'Rodríguez López', 'Neurología', 'Av. Neurológica 456', 'Femenino', '+504 87654321', '1980-03-22', 'maria.neurologia@hospital.com', 'neurologa01', 'neuro123'],
            ['23456789', 'Carlos Alberto', 'Mendoza Ruiz', 'Traumatología', 'Calle Traumatología 789', 'Masculino', '+504 76543210', '1978-11-15', 'carlos.trauma@hospital.com', 'traumatologo01', 'trauma123'],
            ['34567890', 'Ana Sofía', 'Hernández Castro', 'Pediatría', 'Av. Infantil 321', 'Femenino', '+504 65432109', '1985-07-08', 'ana.pediatra@hospital.com', 'pediatra01', 'pediatra123'],
            ['45678901', 'Patricia Isabel', 'Morales Vega', 'Ginecología', 'Calle Ginecológica 654', 'Femenino', '+504 54321098', '1982-09-12', 'patricia.gineco@hospital.com', 'ginecologa01', 'gineco123'],
            ['56789012', 'Luis Fernando', 'Jiménez Soto', 'Dermatología', 'Av. Dermatológica 987', 'Masculino', '+504 43210987', '1979-05-25', 'luis.dermato@hospital.com', 'dermatologo01', 'dermato123'],
            ['67890123', 'Carmen Lucía', 'Vargas Peña', 'Oftalmología', 'Calle Oftálmica 147', 'Femenino', '+504 32109876', '1983-12-03', 'carmen.oftalmo@hospital.com', 'oftalmologa01', 'oftalmo123'],
            ['78901234', 'Diego Alejandro', 'Ramírez Torres', 'Medicina Interna', 'Av. Medicina Interna 258', 'Masculino', '+504 21098765', '1981-04-18', 'diego.interna@hospital.com', 'internista01', 'interna123']
        ];
        
        $stmt = $this->connect->prepare("INSERT IGNORE INTO `doctor` (`ceddoc`, `nodoc`, `apdoc`, `nomesp`, `direcd`, `sexd`, `phd`, `nacd`, `corr`, `username`, `password`, `rol`, `state`, `fere`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, MD5(?), '3', '1', NOW())");
        
        foreach($doctors as $doctor) {
            $stmt->execute($doctor);
        }
        
        // Crear usuarios para los médicos
        $user_stmt = $this->connect->prepare("INSERT IGNORE INTO `users` (`username`, `password`, `rol`) VALUES (?, MD5(?), '3')");
        
        foreach($doctors as $doctor) {
            $user_stmt->execute([$doctor[9], $doctor[10]]); // username, password
        }
        
        // Sincronizar áreas de los nuevos médicos
        $this->syncExistingData();
    }
    
    /**
     * Verificar estado del sistema
     */
    public function getSystemStatus() {
        try {
            $stats = [];
            
            // Contar registros
            $stats['pacientes'] = $this->connect->query("SELECT COUNT(*) FROM patients")->fetchColumn();
            $stats['medicos'] = $this->connect->query("SELECT COUNT(*) FROM doctor")->fetchColumn();
            $stats['areas'] = $this->connect->query("SELECT COUNT(*) FROM medical_areas")->fetchColumn();
            $stats['citas'] = $this->connect->query("SELECT COUNT(*) FROM events")->fetchColumn();
            
            // Verificar conexiones
            $stats['citas_conectadas'] = $this->connect->query("SELECT COUNT(*) FROM events WHERE idpa IS NOT NULL AND idodc IS NOT NULL AND id_area IS NOT NULL")->fetchColumn();
            
            return $stats;
            
        } catch(Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

// Si se llama directamente, inicializar el sistema
if(basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    $autoSync = new AutoSyncSystem($connect);
    $result = $autoSync->initializeSystem();
    
    if($result['success']) {
        $status = $autoSync->getSystemStatus();
        echo "<script>
            Swal.fire({
                title: '¡Sistema Inicializado!',
                html: 'Pacientes: {$status['pacientes']}<br>Médicos: {$status['medicos']}<br>Áreas: {$status['areas']}<br>Citas: {$status['citas']}<br>Citas Conectadas: {$status['citas_conectadas']}',
                icon: 'success',
                confirmButtonColor: '#00BCD4'
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: '{$result['message']}',
                icon: 'error',
                confirmButtonColor: '#00BCD4'
            });
        </script>";
    }
}
?>
