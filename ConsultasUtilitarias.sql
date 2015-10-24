select emp.nombre_usuario,emp.cargo,per.nombre,per.apellido,per.dui from empleado emp inner join persona per on emp.cod_persona = per.codigo;
select concat(per.nombre,' ',per.apellido) as nombre from persona per
				inner join empleado emp on emp.cod_persona = per.codigo
                inner join usuario usr on usr.nombre = emp.nombre_usuario and usr.nombre = 'gorflax';

select d.nombre, m.nombre from municipio m inner join departamento d on m.cod_departamento = d.codigo where m.codigo = 11;
select * from libro where tipo = 'nacimiento' and cerrado = 0 and anyo = year(curdate());
select codigo, concat(nombre,' ',apellido) as nombre from persona p left join nacimiento n on p.codigo = n.cod_asentado;
select codigo from nacimiento order by codigo desc limit 1;
select * from rol;
select usr.nombre, rol.nombre from usuario usr inner join rol on usr.cod_rol = rol.codigo;
select *, calcularedad(codigo) from persona;
select * from departamento;

select * from hospital where codigo = 19;
select * from municipio where codigo = 60;

select * from libro;
select * from partida;
select * from nacimiento;

select * from libro;
select * from partida;
select * from defuncion;
select * from persona;

select * from libro;
select * from partida;
select * from matrimonio;
select * from matrimonio_persona;
select * from persona where nombre like '%daniel%' or nombre like '%sonia elena%';

select * from libro;
select * from partida;
select * from divorcio;
select * from persona where nombre like '%daniel%' or nombre like '%sonia elena%';

select  *
from    matrimonio
where   not exists
        (
        select  null
        from    divorcio
        where   divorcio.cod_matrimonio = matrimonio.codigo
        )
