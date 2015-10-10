SELECT emp.nombre_usuario,emp.cargo,per.nombre,per.apellido,per.dui from empleado emp inner join persona per on emp.cod_persona = per.codigo;
SELECT CONCAT(per.nombre,' ',per.apellido) as Nombre FROM persona per
				INNER JOIN empleado emp on emp.cod_persona = per.codigo
                INNER JOIN usuario usr on usr.nombre = emp.nombre_usuario AND usr.nombre = 'gorflax';

SELECT * FROM libro WHERE tipo = 'Nacimiento' AND cerrado = 0 AND anyo = YEAR(CURDATE());
SELECT codigo, concat(nombre,' ',apellido) as nombre from persona p LEFT JOIN nacimiento n ON p.codigo = n.cod_asentado;
SELECT codigo from nacimiento ORDER BY codigo DESC LIMIT 1;
SELECT * FROM rol;
SELECT usr.nombre, rol.nombre FROM usuario usr INNER JOIN rol on usr.cod_rol = rol.codigo;
SELECT *, calcularEdad(codigo) FROM persona;
select * from departamento;

select * from hospital where codigo = 19;
select * from municipio where codigo = 60;

SELECT * FROM libro;
select * from partida;
select * from nacimiento;

SELECT * FROM libro;
select * from partida;
select * from defuncion;
select * from persona;

SELECT * FROM libro;
select * from partida;
select * from matrimonio;
select * from matrimonio_persona;
select * from persona;
