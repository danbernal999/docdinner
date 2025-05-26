
DROP DATABASE IF EXISTS control_gastos;
CREATE DATABASE control_gastos;
USE control_gastos;

/* Tabla de usuarios */
CREATE TABLE usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  ultimo_login DATETIME DEFAULT NULL,
  reset_token VARCHAR(255) NULL,
  reset_expires DATETIME NULL,
  foto VARCHAR(255) NULL,
  PRIMARY KEY (id)
);

/* Tabla de gastos fijos */
CREATE TABLE gastos_fijos (
  id INT(11) NOT NULL AUTO_INCREMENT,
  usuario_id INT(11) NOT NULL,
  nombre_gasto VARCHAR(100) NOT NULL,
  monto DECIMAL(10,2) NOT NULL,
  fecha DATE DEFAULT NULL,
  categoria VARCHAR(50) DEFAULT NULL,
  descripcion TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

/* Tabla de metas de ahorro */
CREATE TABLE metas_ahorro (
  id INT(11) NOT NULL AUTO_INCREMENT,
  usuario_id INT(11) NOT NULL,
  nombre_meta VARCHAR(255) NOT NULL,
  cantidad_meta DECIMAL(20,2) NOT NULL,
  fecha_limite DATE NOT NULL,
  descripcion TEXT DEFAULT NULL,
  creada_en TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  cumplida TINYINT(1) DEFAULT 0,
  ahorrado DECIMAL(20,2) DEFAULT 0.00,
  PRIMARY KEY (id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

/* Tabla de historial de ahorros */
CREATE TABLE historial_ahorros (
  id INT(11) NOT NULL AUTO_INCREMENT,
  meta_id INT(11) NOT NULL,
  cantidad DECIMAL(10,2) NOT NULL,
  fecha TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  descripcion1 TEXT DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (meta_id) REFERENCES metas_ahorro(id) ON DELETE CASCADE
);
