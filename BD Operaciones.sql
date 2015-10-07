-- Procedimientos y Funciones Almacenadas
use gestion_municipal;
delimiter $$
DROP FUNCTION IF EXISTS `calcularEdad` $$
CREATE FUNCTION `calcularEdad` (codPersona INT) RETURNS INT
BEGIN
  DECLARE edad INT;
  SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(fecha_nacimiento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(fecha_nacimiento, '00-%m-%d')) INTO edad FROM persona WHERE codigo = codPersona;
  RETURN edad;
END $$
delimiter ;
