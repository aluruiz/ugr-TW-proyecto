DROP TABLE IF EXISTS Log;
DROP TABLE IF EXISTS Comentarios;
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS RelClaveIncidencia;
DROP TABLE IF EXISTS PalabrasClave;
DROP TABLE IF EXISTS Valoracion;
DROP TABLE IF EXISTS Incidencias;
DROP TABLE IF EXISTS Usuarios;

CREATE TABLE Usuarios(
  identificador INT AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  familia VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  direccion VARCHAR(100),
  telefono VARCHAR(15),
  password VARCHAR(255) NOT NULL,
  rango ENUM('Administrador','Colaborador') NOT NULL,
  estado ENUM('Inactivo','Activo') NOT NULL,
  PRIMARY KEY(identificador)
);

INSERT INTO Usuarios (nombre,familia,email,password,rango,estado) VALUES ('admin','admin','admin@admin.com','admin','Administrador','Activo');
INSERT INTO Usuarios (nombre,familia,email,password,rango,estado) VALUES ('colab','colab','colab@colab.com','colab','Colaborador','Activo');

CREATE TABLE Incidencias(
  identificador INT AUTO_INCREMENT,
  titulo VARCHAR(50) NOT NULL,
  lugar VARCHAR(50) NOT NULL,
  descripcion VARCHAR(300),
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 ON UPDATE CURRENT_TIMESTAMP,
  positivas INT DEFAULT 0,
  negativas INT DEFAULT 0,
  estado ENUM('Pendiente','Comprobada','Tramitada','Irresoluble','Resuelta') NOT NULL,
  usuario INT NOT NULL,
  PRIMARY KEY(identificador),
  FOREIGN KEY(usuario) REFERENCES Usuarios(identificador)
);

INSERT INTO Incidencias(titulo,lugar,descripcion,estado,usuario) VALUES ('Incidencia de prueba','En un rincon de la mancha', 'texto de ejemplo', 'Resuelta',1);
INSERT INTO Incidencias(titulo,lugar,descripcion,estado,usuario) VALUES ('Prueba mi Prueba','De cuyo nombre no quiero acordarme', 'texto de ejemplo', 'Pendiente',1);

CREATE TABLE Imagenes(
  identificador INT AUTO_INCREMENT,
  incidencia INT NOT NULL,
  PRIMARY KEY(identificador),
  FOREIGN KEY(incidencia) REFERENCES Incidencias(identificador)
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
  valoracion ENUM('Positiva','Negativa') NOT NULL,
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

INSERT INTO Comentarios(usuario,incidencia,comentario) VALUES(1,2,'Comentario de prueba');

CREATE TABLE Log(
  identificador INT AUTO_INCREMENT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 ON UPDATE CURRENT_TIMESTAMP,
  descripcion VARCHAR(100),
  PRIMARY KEY(identificador)
);
