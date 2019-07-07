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
  extImagen VARCHAR(10),
  PRIMARY KEY(identificador)
);

INSERT INTO Usuarios (nombre,familia,email,direccion,telefono,password,rango,estado,extImagen) VALUES ('Growlithe', 'Growlithe', 'growlithe@admin.com', '22222', '999 222222', '$2y$10$j0CEuY9o3Rbkp2jt8LWlmOQej3Pd7aSvT207CB966c3RQPf.iJyve', 'Administrador', 'Activo', 'png');
INSERT INTO Usuarios (nombre,familia,email,direccion,telefono,password,rango,estado,extImagen) VALUES ('Pikachu', 'Pichu', 'pikapi@gmail.com', '11111', '999 111111', '$2y$10$Yhxr2x0S1VRLJ2HwFezqQeCxUPTu3/hBAVfP7Vw2HFabrx/yGPYXK', 'Colaborador', 'Activo', 'png');
INSERT INTO Usuarios (nombre,familia,email,direccion,telefono,password,rango,estado,extImagen) VALUES ('Skitty', 'Delcatty', 'lindoskitty@gmail.com', '23023', '999 232323', '$2y$10$sL1Hk3WEEviS1ns/VyOpMu0R85PqkqOSJG9q3FHbvmhQlG4vJs5se', 'Colaborador', 'Inactivo', 'png');
INSERT INTO Usuarios (nombre,familia,email,direccion,telefono,password,rango,estado,extImagen) VALUES ('Eevee', 'Eevee', 'eeveelucion@correo.com', '33333', '999 333333', '$2y$10$RovDxzZNjumRceRJ5U7qmu7Vx8GaIxWCeSAW0GHot7PMaJAG8/PkG', 'Colaborador', 'Activo', 'png');

CREATE TABLE Incidencias(
  identificador INT AUTO_INCREMENT,
  titulo VARCHAR(50) NOT NULL,
  lugar VARCHAR(50) NOT NULL,
  descripcion VARCHAR(500),
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 ON UPDATE CURRENT_TIMESTAMP,
  positivas INT DEFAULT 0,
  negativas INT DEFAULT 0,
  estado ENUM('Pendiente','Comprobada','Tramitada','Irresoluble','Resuelta') NOT NULL,
  usuario INT NOT NULL,
  PRIMARY KEY(identificador),
  FOREIGN KEY(usuario) REFERENCES Usuarios(identificador)
);

CREATE TABLE Imagenes(
  identificador INT AUTO_INCREMENT,
  incidencia INT NOT NULL,
  extension VARCHAR(10) NOT NULL,
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

CREATE TABLE Log(
  identificador INT AUTO_INCREMENT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 ON UPDATE CURRENT_TIMESTAMP,
  descripcion VARCHAR(100),
  PRIMARY KEY(identificador)
);
