-- PsiCalendar: primera migración del modelo de seguimiento profesional.
-- Motor objetivo: MySQL 8 / MariaDB compatible con InnoDB.
-- IMPORTANTE: revisar y ejecutar primero en una copia de desarrollo de la BD.
-- Esta migración NO elimina ni modifica los registros emocionales existentes.
-- Las cuentas existentes se clasifican como pacientes por defecto; la promoción
-- de una cuenta a psicólogo debe hacerse manualmente tras verificar su identidad.

ALTER TABLE usuarios
    ADD COLUMN rol ENUM('paciente', 'psicologo', 'administrador')
        NOT NULL DEFAULT 'paciente' AFTER password;

CREATE TABLE perfiles_profesionales (
    usuario_id INT(11) NOT NULL,
    nombre_publico VARCHAR(150) NOT NULL,
    numero_registro_profesional VARCHAR(100) NULL,
    pais VARCHAR(2) NOT NULL DEFAULT 'EC',
    activo TINYINT(1) NOT NULL DEFAULT 0,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id),
    CONSTRAINT fk_perfiles_profesionales_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE relaciones_terapeuticas (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    psicologo_id INT(11) NOT NULL,
    paciente_id INT(11) NOT NULL,
    estado ENUM('pendiente', 'activa', 'pausada', 'finalizada')
        NOT NULL DEFAULT 'pendiente',
    puede_ver_registros TINYINT(1) NOT NULL DEFAULT 0,
    creada_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    aceptada_en TIMESTAMP NULL DEFAULT NULL,
    finalizada_en TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_relacion_psicologo_paciente (psicologo_id, paciente_id),
    KEY idx_relaciones_paciente_estado (paciente_id, estado),
    KEY idx_relaciones_psicologo_estado (psicologo_id, estado),
    CONSTRAINT chk_relacion_usuarios_distintos CHECK (psicologo_id <> paciente_id),
    CONSTRAINT fk_relaciones_psicologo
        FOREIGN KEY (psicologo_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_relaciones_paciente
        FOREIGN KEY (paciente_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE consentimientos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    relacion_id BIGINT UNSIGNED NOT NULL,
    paciente_id INT(11) NOT NULL,
    alcance ENUM('seguimiento_emocional') NOT NULL,
    version_politica VARCHAR(30) NOT NULL,
    concedido_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    revocado_en TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    KEY idx_consentimientos_relacion (relacion_id, concedido_en),
    KEY idx_consentimientos_paciente (paciente_id, revocado_en),
    CONSTRAINT fk_consentimientos_relacion
        FOREIGN KEY (relacion_id) REFERENCES relaciones_terapeuticas(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_consentimientos_paciente
        FOREIGN KEY (paciente_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE notas_clinicas (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    relacion_id BIGINT UNSIGNED NOT NULL,
    paciente_id INT(11) NOT NULL,
    autor_psicologo_id INT(11) NOT NULL,
    contenido TEXT NOT NULL,
    creada_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizada_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_notas_relacion_fecha (relacion_id, creada_en),
    KEY idx_notas_paciente (paciente_id),
    KEY idx_notas_autor (autor_psicologo_id),
    CONSTRAINT fk_notas_relacion
        FOREIGN KEY (relacion_id) REFERENCES relaciones_terapeuticas(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_notas_paciente
        FOREIGN KEY (paciente_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_notas_autor
        FOREIGN KEY (autor_psicologo_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE auditoria_seguridad (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    actor_usuario_id INT(11) NULL,
    usuario_afectado_id INT(11) NULL,
    evento VARCHAR(80) NOT NULL,
    tipo_recurso VARCHAR(50) NULL,
    recurso_id VARCHAR(80) NULL,
    resultado ENUM('permitido', 'denegado', 'fallido') NOT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_auditoria_actor_fecha (actor_usuario_id, creado_en),
    KEY idx_auditoria_afectado_fecha (usuario_afectado_id, creado_en),
    KEY idx_auditoria_evento_fecha (evento, creado_en),
    CONSTRAINT fk_auditoria_actor
        FOREIGN KEY (actor_usuario_id) REFERENCES usuarios(id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_auditoria_afectado
        FOREIGN KEY (usuario_afectado_id) REFERENCES usuarios(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- No se concede acceso a diarios ni se crea ninguna relación automáticamente.
-- El backend deberá comprobar en cada petición:
-- 1. sesión autenticada y rol adecuado;
-- 2. relación activa entre psicólogo y paciente;
-- 3. consentimiento vigente y puede_ver_registros = 1 para leer registros;
-- 4. autor_psicologo_id = usuario autenticado para leer/editar notas clínicas.
