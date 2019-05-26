DROP DATABASE IF EXISTS proyectofinal_tw;
CREATE DATABASE proyectofinal_tw;
USE proyectofinal_tw;

DROP TABLE IF EXISTS Incidencias;
DROP TABLE IF EXISTS Usuarios;
DROP TABLE IF EXISTS Valoracion;
DROP TABLE IF EXISTS PalabrasClave;
DROP TABLE IF EXISTS RelClaveIncidencia;
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS Comentarios;
DROP TABLE IF EXISTS Log;

CREATE TABLE Usuarios(
  identificador INT AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  familia VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  direccion VARCHAR(100),
  telefono VARCHAR(15),
  password VARCHAR(15) NOT NULL,
  rango ENUM('Administrador','Colaborador') NOT NULL,
  estado ENUM('Inactivo','Activo'),
  PRIMARY KEY(identificador),
  UNIQUE (email)
);

CREATE TABLE Incidencias(
  identificador INT AUTO_INCREMENT,
  titulo VARCHAR(50) NOT NULL,
  descripcion VARCHAR(300),
  fecha DATETIME,
  estado ENUM('Pendiente','Comprobada','Tramitada','Irresoluble','Resuelta') NOT NULL,
  usuario INT NOT NULL,
  PRIMARY KEY(identificador),
  FOREIGN KEY(usuario) REFERENCES Usuarios(identificador)
);

CREATE TABLE PalabrasClave(
  clave VARCHAR(30),
  PRIMARY KEY(clave)
);

CREATE TABLE RelClaveIncidencia(
  clave VARCHAR(30),
  incidencia INT,
  FOREIGN KEY(clave) REFERENCES PalabrasClave(clave),
  FOREIGN KEY(incidencia) REFERENCES Incidencias(identificador),
  PRIMARY KEY(clave,incidencia)
);

CREATE TABLE Valoracion(
  usuario INT,
  incidencia INT,
  positiva BIT NOT NULL,
  negativa BIT NOT NULL,
  FOREIGN KEY(usuario) REFERENCES Usuarios(identificador),
  FOREIGN KEY(incidencia) REFERENCES Incidencias(identificador),
  PRIMARY KEY(usuario,incidencia)
);

CREATE TABLE Comentarios(
  identificador INT AUTO_INCREMENT,
  usuario INT,
  incidencia INT,
  comentario VARCHAR(300),
  FOREIGN KEY(usuario) REFERENCES Usuarios(identificador),
  FOREIGN KEY(incidencia) REFERENCES Incidencias(identificador),
  PRIMARY KEY(identificador)
);

CREATE TABLE Log(
  identificador INT AUTO_INCREMENT,
  fecha DATETIME NOT NULL,
  descripcion VARCHAR(100),
  PRIMARY KEY(identificador)
);
