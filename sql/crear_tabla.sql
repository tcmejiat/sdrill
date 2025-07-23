
CREATE TABLE inec_transporte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_proceso VARCHAR(100),
    razon_social VARCHAR(255),
    fecha_adjudicacion DATE,
    monto_adjudicado DECIMAL(12,2),
    zona_urbana VARCHAR(10)
);
