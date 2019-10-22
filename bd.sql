CREATE TABLE producto (
    id  SERIAL  PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio FLOAT NOT NULL,
    valoracion FLOAT NOT NULL
);