/*
    IMPORTANTE: Dado que no se necesitan para el ejercicio asumo que las tablas destinos, clientes y conceptos existen
*/

-- ========= CREO LAS TABLAS ===========
CREATE TABLE viajes (
  id INTEGER PRIMARY KEY,
  destino_id INTEGER NOT NULL,
  cliente_id INTEGER NOT NULL
);

CREATE TABLE paquetes (
  id INTEGER PRIMARY KEY,
  viaje_id INTEGER NOT NULL,
  peso FLOAT NOT NULL
);

CREATE TABLE tarifas (
  id INTEGER PRIMARY KEY,
  viaje_id INTEGER NOT NULL,
  concepto_id INTEGER NOT NULL,
  subtotal FLOAT NOT NULL
);

-- ========= INSERTO VALORES ===========

-- Viaje 1
INSERT INTO viajes VALUES (1, 1, 1);
INSERT INTO paquetes VALUES(1, 1, 300.50);
INSERT INTO paquetes VALUES(2, 1, 150.20);
INSERT INTO paquetes VALUES(3, 1, 150.20);
INSERT INTO tarifas VALUES(1, 1, 8, 2500);
INSERT INTO tarifas VALUES(2, 1, 9, 803);

-- Viaje 2
INSERT INTO viajes VALUES (2, 2, 2);
INSERT INTO paquetes VALUES(4, 2, 145);
INSERT INTO paquetes VALUES(5, 2, 177);
INSERT INTO tarifas VALUES(3, 2, 8, 1876);
INSERT INTO tarifas VALUES(4, 2, 9, 452);
INSERT INTO tarifas VALUES(5, 2, 2, 139);

-- Viaje 3
INSERT INTO viajes VALUES (3, 3, 3);
INSERT INTO paquetes VALUES(6, 3, 80);
INSERT INTO paquetes VALUES(7, 3, 80);
INSERT INTO paquetes VALUES(8, 3, 80);
INSERT INTO paquetes VALUES(9, 3, 80);
INSERT INTO tarifas VALUES(6, 3, 8, 4015);
INSERT INTO tarifas VALUES(7, 3, 9, 2630);
INSERT INTO tarifas VALUES(8, 3, 2, 974);

-- ======= ACÁ VA EL QUERY ========

SELECT v.id AS viaje_id, COUNT(p.id) AS cantidad_paquetes, SUM(t.subtotal) AS total_tarifas
FROM viajes v
JOIN paquetes p ON v.id = p.viaje_id
JOIN tarifas t ON v.id = t.viaje_id
GROUP BY v.id
HAVING COUNT(p.id) <= 3
ORDER BY v.id DESC;