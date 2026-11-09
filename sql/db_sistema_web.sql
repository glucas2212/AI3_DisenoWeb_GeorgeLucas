/*
  db_sistema_web - Mesa de ayuda: registro de incidencias de soporte técnico
  Compatible con MySQL 8 y MariaDB 10.4+ (XAMPP).
  Importar desde phpMyAdmin > Importar, o por consola:
      mysql -u root -p < sql/db_sistema_web.sql
*/
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS db_sistema_web
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_spanish_ci;

USE db_sistema_web;

/* Catálogo de áreas de la institución: se separa para no repetir el nombre en cada incidencia. */
CREATE TABLE IF NOT EXISTS areas (
    id_area SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre  VARCHAR(60)       NOT NULL,
    CONSTRAINT pk_areas PRIMARY KEY (id_area),
    CONSTRAINT uq_areas_nombre UNIQUE (nombre)
) ENGINE = InnoDB;

/* Tabla principal: cada fila es un reporte de soporte técnico. */
CREATE TABLE IF NOT EXISTS incidencias (
    id_incidencia       INT UNSIGNED      NOT NULL AUTO_INCREMENT,
    solicitante         VARCHAR(80)       NOT NULL,
    correo              VARCHAR(120)      NOT NULL,
    id_area             SMALLINT UNSIGNED NOT NULL,
    tipo                ENUM('Hardware', 'Software', 'Red', 'Impresora', 'Accesos') NOT NULL,
    prioridad           ENUM('Baja', 'Media', 'Alta', 'Crítica') NOT NULL DEFAULT 'Media',
    descripcion         VARCHAR(500)      NOT NULL,
    estado              ENUM('Abierta', 'En proceso', 'Resuelta') NOT NULL DEFAULT 'Abierta',
    fecha_creacion      TIMESTAMP         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP         NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_incidencias PRIMARY KEY (id_incidencia),
    CONSTRAINT fk_incidencias_area FOREIGN KEY (id_area)
        REFERENCES areas (id_area) ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX ix_incidencias_estado (estado),
    INDEX ix_incidencias_fecha (fecha_creacion)
) ENGINE = InnoDB;

INSERT IGNORE INTO areas (nombre) VALUES
    ('Atención Ciudadana'),
    ('Contabilidad'),
    ('Secretaría General'),
    ('Talento Humano'),
    ('Tesorería');
