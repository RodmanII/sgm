#  database management system: mysql/mariadb
#  diagram: Sistema de Gestión Municipal
#  author: Rodrigo Grijalva

drop database if exists gestion_municipal;
create database gestion_municipal character set utf8 collate utf8_general_ci;
use gestion_municipal;
# generating tables
create table `libro` (
	`codigo` int auto_increment,
	`numero` int not null,
	`anyo` year not null,
	`tipo` varchar(50) not null,-- Nacimiento,Defuncion,Matrimonio,Divorcio
	`cerrado` tinyint(1) not null default 0,
	constraint pk_Libro primary key(`codigo`),
	constraint unq_Libro_num_anyo_tipo unique(numero,anyo,tipo)
);
-- Inserción de Registros
insert into libro(numero,anyo,tipo,cerrado) values(1,2015,'Nacimiento',0);
insert into libro(numero,anyo,tipo,cerrado) values(2,2015,'Nacimiento',0);
insert into libro(numero,anyo,tipo,cerrado) values(1,2015,'Defuncion',0);
insert into libro(numero,anyo,tipo,cerrado) values(2,2015,'Defuncion',0);
insert into libro(numero,anyo,tipo,cerrado) values(1,2015,'Matrimonio',0);
insert into libro(numero,anyo,tipo,cerrado) values(2,2015,'Matrimonio',0);
insert into libro(numero,anyo,tipo,cerrado) values(1,2015,'Divorcio',0);
insert into libro(numero,anyo,tipo,cerrado) values(2,2015,'Divorcio',0);

create table `departamento` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_Departamento primary key(`codigo`),
	constraint unq_Departamento_nombre unique(nombre)
);
-- Inserción de Registros
insert into departamento(nombre) values('Ahuachapán');-- 1
insert into departamento(nombre) values('Sonsonate');-- 2
insert into departamento(nombre) values('Santa Ana');-- 3
insert into departamento(nombre) values('Cabañas');-- 4
insert into departamento(nombre) values('Chalatenango');-- 5
insert into departamento(nombre) values('Cuscatlán');-- 6
insert into departamento(nombre) values('La Libertad');-- 7
insert into departamento(nombre) values('La Paz');-- 8
insert into departamento(nombre) values('San Salvador');-- 9
insert into departamento(nombre) values('San Vicente');-- 10
insert into departamento(nombre) values('Morazán');-- 11
insert into departamento(nombre) values('San Miguel');-- 12
insert into departamento(nombre) values('Usulután');-- 13
insert into departamento(nombre) values('La Unión');-- 14

create table `municipio` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`cod_departamento` int not null,
	constraint pk_Municipio primary key(`codigo`),
	constraint unq_Municipio_nombre_cod_departamento unique(nombre,cod_departamento)
);
alter table `municipio` add constraint `fk_municipio_departamento_cod_departamento` foreign key (`cod_departamento`) references `departamento`(`codigo`) on delete cascade on update cascade;
-- Inserción de Registros para Ahuachapán
insert into municipio(nombre,cod_departamento) values('Ahuachapán',1);
insert into municipio(nombre,cod_departamento) values('Apaneca',1);
insert into municipio(nombre,cod_departamento) values('Atiquizaya',1);
insert into municipio(nombre,cod_departamento) values('Concepción de Ataco',1);
insert into municipio(nombre,cod_departamento) values('El Refugio',1);
insert into municipio(nombre,cod_departamento) values('Guaymango',1);
insert into municipio(nombre,cod_departamento) values('Jujutla',1);
insert into municipio(nombre,cod_departamento) values('San Francisco Menéndez',1);
insert into municipio(nombre,cod_departamento) values('San Lorenzo',1);
insert into municipio(nombre,cod_departamento) values('San Pedro Puxtla',1);
insert into municipio(nombre,cod_departamento) values('Tacuba',1);
insert into municipio(nombre,cod_departamento) values('Turín',1);

-- Inserción de Registros para Sonsonate
insert into municipio(nombre,cod_departamento) values('Acajutla',2);
insert into municipio(nombre,cod_departamento) values('Armenia',2);
insert into municipio(nombre,cod_departamento) values('Caluco',2);
insert into municipio(nombre,cod_departamento) values('Cuisnahuat',2);
insert into municipio(nombre,cod_departamento) values('Izalco',2);
insert into municipio(nombre,cod_departamento) values('Juayúa',2);
insert into municipio(nombre,cod_departamento) values('Nahuizalco',2);
insert into municipio(nombre,cod_departamento) values('Nahulingo',2);
insert into municipio(nombre,cod_departamento) values('Salcoatitán',2);
insert into municipio(nombre,cod_departamento) values('San Antonio del Monte',2);
insert into municipio(nombre,cod_departamento) values('San Julián',2);
insert into municipio(nombre,cod_departamento) values('Santa Catarina Masahuat',2);
insert into municipio(nombre,cod_departamento) values('Santa Isabel Ishuatán',2);
insert into municipio(nombre,cod_departamento) values('Santo Domingo Guzmán',2);
insert into municipio(nombre,cod_departamento) values('Sonsonate',2);
insert into municipio(nombre,cod_departamento) values('Sonzacate',2);

-- Inserción de Registros para San Salvador
insert into municipio(nombre,cod_departamento) values('Aguilares',9);
insert into municipio(nombre,cod_departamento) values('Apopa',9);
insert into municipio(nombre,cod_departamento) values('Ayutuxtepeque',9);
insert into municipio(nombre,cod_departamento) values('Cuscatancingo',9);
insert into municipio(nombre,cod_departamento) values('Ciudad Delgado',9);
insert into municipio(nombre,cod_departamento) values('El Paisnal',9);
insert into municipio(nombre,cod_departamento) values('Guazapa',9);
insert into municipio(nombre,cod_departamento) values('Ilopango',9);
insert into municipio(nombre,cod_departamento) values('Mejicanos',9);
insert into municipio(nombre,cod_departamento) values('Nejapa',9);
insert into municipio(nombre,cod_departamento) values('Panchimalco',9);
insert into municipio(nombre,cod_departamento) values('Rosario de Mora',9);
insert into municipio(nombre,cod_departamento) values('San Marcos',9);
insert into municipio(nombre,cod_departamento) values('San Martín',9);
insert into municipio(nombre,cod_departamento) values('San Salvador',9);
insert into municipio(nombre,cod_departamento) values('Santiago Texacuangos',9);
insert into municipio(nombre,cod_departamento) values('Santo Tomás',9);
insert into municipio(nombre,cod_departamento) values('Soyapango',9);
insert into municipio(nombre,cod_departamento) values('Tonacatepeque',9);

create table `hospital` (
	`codigo` int auto_increment,
	`nombre` varchar(100) not null,
	`ubicacion` varchar(50) not null,
	`cod_municipio` int not null,
	constraint pk_Hospital primary key(`codigo`),
	constraint unq_Hospital_nombre unique(nombre)
);
alter table `hospital` add constraint `fk_hospital_municipio_cod_municipio` foreign key (`cod_municipio`) references `municipio`(`codigo`) on delete no action on update cascade;
-- Inserción de Registros para Hospital
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital del Divino Salvador del Mundo','Santo Tomás',1);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional "Enfermera Angélica Vidal de Najarro"','San Bartolo',1);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional "Cabo Antonio Marcos Eusebio Galvez"','San Rodrigo',1);

create table `unidad` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_Unidad primary key(`codigo`),
	constraint unq_Unidad_nombre unique(nombre)
);
-- Inserción de Registros para Unidad
insert into unidad(nombre) values('Registro del Estado Familiar');
insert into unidad(nombre) values('Recolección de Desechos Sólidos');

create table `informante` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`tipo_documento` varchar(50) not null,
	`numero_documento` varchar(100) not null,
	constraint pk_Informante primary key(`codigo`),
	constraint unq_Informante_nombre unique(nombre),
	constraint unq_Informante_numero_documento unique(numero_documento)
);
insert into informante(nombre,tipo_documento,numero_documento) values('Fabián Ernesto Clavico Fútil','Documento Único de Identidad','cero cuatro nueve cinco cinco cuatro nueve siete-tres');
insert into informante(nombre,tipo_documento,numero_documento) values('Sarina Valentina Rios Luna','Documento Único de Identidad','cero cuatro ocho tres dos cuatro cero siete-tres');

create table `modalidad_divorcio` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_ModalidadDivorcio primary key(`codigo`),
	constraint unq_ModalidadDivorcio_nombre unique(nombre)
);
-- Inserción de Registros para Modalidad de Divorcio
insert into modalidad_divorcio(nombre) values('Mutuo Consentimiento');
insert into modalidad_divorcio(nombre) values('Separación de más de un año');
insert into modalidad_divorcio(nombre) values('Vida Intolerable');

create table `estado_civil` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_EstadoCivil primary key(`codigo`),
	constraint unq_EstadoCivil_nombre unique(nombre)
);
-- Inserción de Registros para Estado Civil
insert into estado_civil(nombre) values('Soltero');
insert into estado_civil(nombre) values('Casado');
insert into estado_civil(nombre) values('Divorciado');
insert into estado_civil(nombre) values('Viudo');
insert into estado_civil(nombre) values('Acompañado');

create table `regimen_patrimonial` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`descripcion` varchar(300) null,
	constraint pk_RegimenPatrimonial primary key(`codigo`),
	constraint unq_RegimenPatrimonial_nombre unique(nombre)
);
-- Inserción de Registros para Regimen Patrimonial
insert into regimen_patrimonial(nombre,descripcion) values('Separación de Bienes','Cada persona se reserva la propiedad, la administración, y la libre disposición de sus bienes obtenidos antes y después del matrimonio. Los bienes son separados completamente.');
insert into regimen_patrimonial(nombre,descripcion) values('Partición de Ganancias','Al comenzar el matrimonio, los bienes adquiridos dentro de este, son de los dos. La excepción es la herencia, que aunque se adquiera dentro del matrimonio, no se comparte entre los dos, si no que exclusivamente es de su propietario. El resto de los bienes y todo lo que se obtenga será de los dos.');
insert into regimen_patrimonial(nombre,descripcion) values('Comunidad Diferida','Todo lo existente dentro y fuera del matrimonio pertenece a ambos, y se distribuirá por mitad en caso de disolverse el vínculo.');

create table `nacionalidad` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`pais` varchar(50) not null,
	constraint pk_Nacionalidad primary key(`codigo`),
	constraint unq_Nacionalidad_nombre unique(nombre),
	constraint unq_Nacionalidad_pais unique(pais)
);
-- Inserción de Registros para Nacionalidad
insert into nacionalidad(nombre,pais) values('Salvadoreña','El Salvador');
insert into nacionalidad(nombre,pais) values('Guatemalteca','Guatemala');
insert into nacionalidad(nombre,pais) values('Hondureña','Honduras');
insert into nacionalidad(nombre,pais) values('Nicaragüense','Nicaragua');
insert into nacionalidad(nombre,pais) values('Costarricense','Costa Rica');
insert into nacionalidad(nombre,pais) values('Beliceña','Belice');
insert into nacionalidad(nombre,pais) values('Panameña','Panamá');

create table `causa_defuncion` (
	`codigo` int auto_increment,
	`nombre` varchar(100) not null,
	constraint pk_CausaDefuncion primary key(`codigo`),
	constraint unq_CausaDefuncion_nombre unique(nombre)
);
-- Inserción de Registros para Causas de Defunción
insert into causa_defuncion(nombre) values('Paro cardíaco');
insert into causa_defuncion(nombre) values('Neumonía');
insert into causa_defuncion(nombre) values('Insuficiencia cardíaca');
insert into causa_defuncion(nombre) values('Tuberculosis');
insert into causa_defuncion(nombre) values('Hepatitis vírica');
insert into causa_defuncion(nombre) values('Leucemia');

create table `rol` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_Rol primary key(`codigo`),
	constraint unq_Rol_nombre unique(nombre)
);
-- Inserción de Registros para Rol
insert into rol(nombre) values('Administrador');
insert into rol(nombre) values('EmpleadoRF');
insert into rol(nombre) values('EmpleadoRD');

create table `persona` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`apellido` varchar(50) not null,
	`dui` char(9) null,
	`nit` char(10) null,
	`fecha_nacimiento` date not null,
	`genero` varchar(50) not null,
	`direccion` varchar(200) not null,
	`profesion` varchar(50) null,
	`estado` varchar(50) not null default 'Activo',
	`cod_municipio` int not null,
	`cod_nacionalidad` int not null,
	`cod_estado_civil` int not null,
	constraint pk_Persona primary key(`codigo`),
	constraint unq_Persona_dui unique(dui),
	constraint unq_Persona_nit unique(nit)
);
alter table `persona` add constraint `fk_persona_estado_civil_cod_estado_civil` foreign key (`cod_estado_civil`) references `estado_civil`(`codigo`) on delete no action on update cascade;
alter table `persona` add constraint `fk_persona_nacionalidad_cod_nacionalidad` foreign key (`cod_nacionalidad`) references `nacionalidad`(`codigo`) on delete no action on update cascade;
alter table `persona` add constraint `fk_persona_municipio_cod_municipio` foreign key (`cod_municipio`) references `municipio`(`codigo`) on delete no action on update cascade;
-- Inserción de Registros para Persona
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Alicia Guadalupe', 'López', '048501627', '0515103264', '1971-02-25', 'Femenino', 'Direccion del empleado #1', 'Profesora', 1,1,2);
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Rodrigo Osvaldo', 'Grijalva López', '048401915', '0515103145', '1993-09-14', 'Masculino', 'Direccion del empleado #2', 'Estudiante', 2,1,4);
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Hugo Ernesto', 'Grijalva Pérez', '014501627', '0517103264', '1967-10-09', 'Masculino', 'Direccion del empleado #3', 'Administrativo', 3,3,1);
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Claudia Maribel', 'Flores Valle', '562101627', '6230103264', '1995-10-09', 'Femenino', 'Direccion del empleado #4', 'Secretaria', 4,5,3);
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Carla Maria', 'Castillo Navarrete', '565171647', '6232102764', '1992-03-17', 'Femenino', 'Direccion del empleado #5', 'Secretaria', 'Inactivo', 16,6,5);

create table `usuario` (
	`nombre` varchar(50),
	`contrasenya` char(128) not null,
	`salt` char(11) not null,
	`cod_rol` int not null,
	constraint pk_Usuario primary key(`nombre`)
);
alter table `usuario` add constraint `fk_usuario_rol_cod_rol` foreign key (`cod_rol`) references `rol`(`codigo`) on delete cascade on update cascade;
-- Inserción de Registros para Usuario
insert into usuario(nombre,contrasenya,salt,cod_rol) values('garflax','3a49a9d103f346d633a64faa4aeae1111d756bab18e161d37960b0ba3d98e7a4865967c516614d6a0a5bbfd6e73113c41f6ad4169dc97b69568debaf369005ad','Exi6IEI1RbH',1);
insert into usuario(nombre,contrasenya,salt,cod_rol) values('gorflax','7496d87ddb26fad967e510613ce111e65acd250605c370d7e3e0a4916540bb73b4de8a56921131ce772a491e7450a55f0c58d0965e8f9702c19f9b3f70c59e4d','pFd0U%BY=eJ',2);
insert into usuario(nombre,contrasenya,salt,cod_rol) values('girflax','2d6d11f82f408802b03bbedf0e37f16aac5db44d429ded35abecf955807de22bf3dbc0b66353baef5eba0ce1cb7eaf8922cbc34adafd567dcaa9f115d587a688','+4i0|0HIiUq',2);
insert into usuario(nombre,contrasenya,salt,cod_rol) values('gurflax','b205d37324dcb0f41cb118082dade54766d0a89f6134110597f9d279b4285da6ad80017d861161c65094ac574cacdf50655bf882dab98ef54434a4df2f8aee0f','c8yAVuCB|iq',3);
insert into usuario(nombre,contrasenya,salt,cod_rol) values('gerflax','8436f145294b4539068d6f73a7c626aa6f62c33c4911af63194ef86415f3f9b1ca229305257ce5fb53c5273132b5f38df22bc731e7026f623e4f2a16cc77bef5','2_Qc7k0rKRb',3);
insert into `usuario` (`nombre`,`contrasenya`,`salt`,`cod_rol`) values ('rodrigo','50116cb87536c9c9a414f13093fc3a7073d05bb22e68b5249546729d8caea87479ea11ba79cb9c7c5d9f6ca27d21d442a35bbce1dc657b36510b873b2c2e2890','KCma6npWyLQ',1);
insert into `usuario` (`nombre`,`contrasenya`,`salt`,`cod_rol`) values ('verdugo','cdea91f725d0023cecf95eb2dc352bb09ff174bea76ff9d94e3c71e1708a2501419576172f8e50c96de26f8738e618a7e3feab3981db921cc1df26c8c96cd053','YoSpMe9bwFk',3);

create table `empleado` (
	`codigo` int auto_increment,
	`cargo` varchar(50) not null,
	`cod_unidad` int not null,
	`cod_persona` int not null,
	`nombre_usuario` varchar(50) null,
	constraint pk_Empleado primary key(`codigo`),
	constraint unq_Empleado_cod_persona unique(cod_persona),
	constraint unq_Empleado_nombre_usuario unique(nombre_usuario)
);
alter table `empleado` add constraint `fk_empleado_usuario_nombre_usuario` foreign key (`nombre_usuario`) references `usuario`(`nombre`) on delete no action on update cascade;
alter table `empleado` add constraint `fk_empleado_unidad_cod_unidad` foreign key (`cod_unidad`) references `unidad`(`codigo`) on delete cascade on update cascade;
alter table `empleado` add constraint `fk_empleado_persona_cod_persona` foreign key (`cod_persona`) references `persona`(`codigo`) on delete cascade on update cascade;
-- Inserción de Registros para Empleado
insert into empleado(cargo,cod_unidad,cod_persona,nombre_usuario) values('Emisor de Partidas',1,1,'girflax');
insert into empleado(cargo,cod_unidad,cod_persona,nombre_usuario) values('Emisor de Certificadas',1,2,'gorflax');
insert into empleado(cargo,cod_unidad,cod_persona,nombre_usuario) values('Supervisor del Registro Familiar',2,3,'garflax');
insert into empleado(cargo,cod_unidad,cod_persona,nombre_usuario) values('Supervisor de Cuadrillas de Recolección',2,4,'gerflax');
insert into empleado(cargo,cod_unidad,cod_persona,nombre_usuario) values('Ordo Hereticus',2,5,'verdugo');

create table `vehiculo` (
	`numero` int auto_increment,
	`matricula` varchar(10) not null,
	`fecha_compra` date not null,
	`estado` varchar(50) not null,
	`marca` varchar(50) not null,
	`modelo` varchar(50) null,
	`anyo` year null,
	`capacidad` int not null,
	`cod_conductor` int not null,
	constraint pk_Vehiculo primary key(`numero`),
	constraint unq_Vehiculo_cod_conductor unique(cod_conductor),
	constraint unq_Vehiculo_matricula unique(matricula)
);
alter table `vehiculo` add constraint `fk_vehiculo_empleado_cod_conductor` foreign key (`cod_conductor`) references `empleado`(`codigo`) on delete no action on update cascade;

create table `partida` (
		`numero` int auto_increment,
		`folio` int not null,
		`fecha_emision` date not null,
		`fecha_suceso` date not null,
		`hora_suceso` time not null,
		`lugar_suceso` varchar(100) not null,
		`cod_empleado` int not null,
		`cod_municipio` int not null,-- Municipio del suceso
		`cod_informante` int not null,
		`cod_libro` int not null,
		constraint pk_Partida primary key(`numero`),
		constraint unq_Partida_folio_cod_libro unique(folio,cod_libro)
);
alter table `partida` add constraint `fk_partida_empleado_cod_empleado` foreign key (`cod_empleado`) references `empleado`(`codigo`) on delete no action on update cascade;
alter table `partida` add constraint `fk_partida_municipio_cod_municipio` foreign key (`cod_municipio`) references `municipio`(`codigo`) on delete no action on update cascade;
alter table `partida` add constraint `fk_partida_informante_cod_informante` foreign key (`cod_informante`) references `informante`(`codigo`) on delete no action on update cascade;
alter table `partida` add constraint `fk_partida_libro_cod_libro` foreign key (`cod_libro`) references `libro`(`codigo`) on delete no action on update cascade;

create table `nacimiento` (
	`codigo` int auto_increment,
	`cod_padre` int null,
	`cod_madre` int null,
	`cod_asentado` int not null,
	`cod_hospital` int not null,
	`num_partida` int not null,
	constraint pk_Nacimiento primary key(`codigo`),
	constraint unq_Nacimiento_cod_asentado unique(cod_asentado),
	constraint unq_Nacimiento_num_partida unique(num_partida)
);
alter table `nacimiento` add constraint `fk_nacimiento_persona_cod_asentado` foreign key (`cod_asentado`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_persona_cod_padre` foreign key (`cod_padre`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_persona_cod_madre` foreign key (`cod_madre`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_hospital_cod_hospital` foreign key (`cod_hospital`) references `hospital`(`codigo`) on delete no action on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_partida_num_partida` foreign key (`num_partida`) references `partida`(`numero`) on delete cascade on update cascade;

create table `matrimonio` (
	`codigo` int auto_increment,
	`notario` varchar(50) not null,
	`testigos` varchar(300) not null,
	`padre_contrayente_h` varchar(50) null,
	`madre_contrayente_h` varchar(50) null,
	`padre_contrayente_m` varchar(50) null,
	`madre_contrayente_m` varchar(50) null,
	`cod_reg_patrimonial` int not null,
	`num_partida` int not null,
	constraint pk_Matrimonio primary key(`codigo`),
	constraint unq_Matrimonio_num_partida unique(num_partida)
);
alter table `matrimonio` add constraint `fk_matrimonio_regimen_patrimonial_cod_reg_patrimonial` foreign key (`cod_reg_patrimonial`) references `regimen_patrimonial`(`codigo`) on delete no action on update cascade;
alter table `matrimonio` add constraint `fk_matrimonio_partida_num_partida` foreign key (`num_partida`) references `partida`(`numero`) on delete cascade on update cascade;

create table `defuncion` (
	`codigo` int auto_increment,
	`determino_causa` varchar(100) not null,
	`familiares` varchar(300) not null,
	`cod_difunto` int not null,
	`cod_causa` int not null,
	`num_partida` int not null,
	constraint pk_Defuncion primary key(`codigo`),
	constraint unq_Defuncion_cod_difunto unique(cod_difunto),
	constraint unq_Defuncion_num_partida unique(num_partida)
);
alter table `defuncion` add constraint `fk_defuncion_persona_cod_difunto` foreign key (`cod_difunto`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `defuncion` add constraint `fk_defuncion_partida_num_partida` foreign key (`num_partida`) references `partida`(`numero`) on delete cascade on update cascade;
alter table `defuncion` add constraint `fk_defuncion_causa_cod_causa` foreign key (`cod_causa`) references `causa_defuncion`(`codigo`) on delete no action on update cascade;

create table `divorcio` (
	`codigo` int auto_increment,
	`juez` varchar(50) not null,
	`fecha_ejecucion` date not null,
	`detalle` varchar(300) null,
	`num_partida` int not null,
	`cod_mod_divorcio` int not null,
	`cod_matrimonio` int not null,
	constraint pk_Divorcio primary key(`codigo`),
	constraint unq_Divorcio_num_partida unique(num_partida),
	constraint unq_Divorcio_cod_matrimonio unique(cod_matrimonio)
);
alter table `divorcio` add constraint `fk_divorcio_partida_num_partida` foreign key (`num_partida`) references `partida`(`numero`) on delete cascade on update cascade;
alter table `divorcio` add constraint `fk_divorcio_matrimonio_cod_matrimonio` foreign key (`cod_matrimonio`) references `matrimonio`(`codigo`) on delete cascade on update cascade;
alter table `divorcio` add constraint `fk_divorcio_modalidad_divorcio_cod_mod_divorcio` foreign key (`cod_mod_divorcio`) references `modalidad_divorcio`(`codigo`) on delete no action on update cascade;

create table `recoleccion` (
	`codigo` int auto_increment,
	`fecha` date not null,
	`hora_salida` time not null,
	`hora_inicio_ruta` time not null,
	`hora_regreso` time not null,
	`kilometraje_entrada` int not null,
	`kilometraje_salida` int not null,
	`kilometraje_recorrido` int not null,
	`observaciones` varchar(300) null,
	`total_recoleccion` decimal(12,2) not null,
	`num_vehiculo` int not null,
	constraint pk_Recoleccion primary key(`codigo`)
);
alter table `recoleccion` add constraint `fk_recoleccion_vehiculo_num_vehiculo` foreign key (`num_vehiculo`) references `vehiculo`(`numero`) on delete cascade on update cascade;

create table `turno` (
	`codigo` int auto_increment,
	`tipo` varchar(50) not null,
	`hora_inicio` time not null,
	`hora_fin` time not null,
	constraint pk_Turno primary key(`codigo`),
	constraint unq_Turno_tipo unique(tipo),
	constraint unq_Turno_hora_inicio_hora_fin unique(hora_inicio,hora_fin)
);

create table `ruta` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`cod_turno` int not null,
	constraint pk_Ruta primary key(`codigo`),
	constraint unq_Ruta_cod_turno unique(cod_turno)
);
alter table `ruta` add constraint `fk_ruta_turno_cod_turno` foreign key (`cod_turno`) references `turno`(`codigo`) on delete cascade on update cascade;

create table `cuadrilla` (
	`codigo` int auto_increment,
	`num_vehiculo` int not null,
	`cod_empleado` int not null,
	constraint pk_Cuadrilla primary key(`codigo`),
	constraint unq_Cuadrilla_num_vehiculo_cod_empleado unique(num_vehiculo,cod_empleado)
);
alter table `cuadrilla` add constraint `fk_cuadrilla_vehiculo_num_vehiculo` foreign key (`num_vehiculo`) references `vehiculo`(`numero`) on delete cascade on update cascade;
alter table `cuadrilla` add constraint `fk_cuadrilla_empleado_cod_empleado` foreign key (`cod_empleado`) references `empleado`(`codigo`) on delete cascade on update cascade;

create table `recoleccion_ruta` (
	`codigo` int auto_increment,
	`estado_ruta` varchar(50) not null,
	`detalle` varchar(300) null,
	`cod_ruta` int not null,
	`cod_recoleccion` int not null,
	constraint pk_RecoleccionRuta primary key(`codigo`),
	constraint unq_RecoleccionRuta_cod_ruta_cod_recoleccion unique(cod_ruta,cod_recoleccion)
);
alter table `recoleccion_ruta` add constraint `fk_recoleccion_ruta_ruta_cod_ruta` foreign key (`cod_ruta`) references `ruta`(`codigo`) on delete cascade on update cascade;
alter table `recoleccion_ruta` add constraint `fk_recoleccion_ruta_recoleccion_cod_recoleccion` foreign key (`cod_recoleccion`) references `recoleccion`(`codigo`) on delete cascade on update cascade;

create table `dia` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_Dia primary key(`codigo`),
	constraint unq_Dia_nombre unique(nombre)
);

create table `lugar` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`latitud` decimal(8,6) not null,
	`longitud` decimal(8,6) not null,
	constraint pk_Lugar primary key(`codigo`),
	constraint unq_Lugar_nombre unique(nombre)
);

create table `ruta_dia` (
	`codigo` int auto_increment,
	`cod_dia` int not null,
	`cod_ruta` int not null,
	constraint pk_RutaDia primary key(`codigo`),
	constraint unq_RutaDia_cod_dia_cod_ruta unique(cod_dia,cod_ruta)
);
alter table `ruta_dia` add constraint `fk_ruta_dia_ruta_cod_ruta` foreign key (`cod_ruta`) references `ruta`(`codigo`) on delete cascade on update cascade;
alter table `ruta_dia` add constraint `fk_ruta_dia_dia_cod_dia` foreign key (`cod_dia`) references `dia`(`codigo`) on delete cascade on update cascade;

create table `ruta_lugar` (
	`codigo` int auto_increment,
	`cod_lugar` int not null,
	`cod_ruta` int not null,
	constraint pk_RutaLugar primary key(`codigo`),
	constraint unq_RutaLugar_cod_lugar_cod_ruta unique(cod_ruta,cod_lugar)
);
alter table `ruta_lugar` add constraint `fk_ruta_lugar_ruta_cod_ruta` foreign key (`cod_ruta`) references `ruta`(`codigo`) on delete cascade on update cascade;
alter table `ruta_lugar` add constraint `fk_ruta_lugar_lugar_cod_lugar` foreign key (`cod_lugar`) references `lugar`(`codigo`) on delete cascade on update cascade;

create table `recarga` (
	`codigo` int auto_increment,
	`fecha` date not null,
	`hora` time not null,
	`galones_suministrados` decimal(8,2) not null,
	`valor` decimal(12,2) not null,
	`num_vehiculo` int not null,
	constraint pk_Recarga primary key(`codigo`)
);
alter table `recarga` add constraint `fk_recarga_vehiculo_num_vehiculo` foreign key (`num_vehiculo`) references `vehiculo`(`numero`) on delete cascade on update cascade;

create table `averia` (
	`codigo` int auto_increment,
	`fecha` date not null,
	`hora` time not null,
	`descripcion` varchar(300) not null,
	`gravedad` varchar(50) not null,
	`num_vehiculo` int not null,
	constraint pk_Averia primary key(`codigo`)
);
alter table `averia` add constraint `fk_averia_vehiculo_num_vehiculo` foreign key (`num_vehiculo`) references `vehiculo`(`numero`) on delete cascade on update cascade;

create table `matrimonio_persona` (
	`codigo` int auto_increment,
	`cod_persona` int not null,
	`cod_matrimonio` int not null,
	constraint pk_MatrimonioPersona primary key(`codigo`),
	constraint unq_MatrimonioPersona_cod_persona_cod_matrimonio unique(cod_persona,cod_matrimonio)
);
alter table `matrimonio_persona` add constraint `fk_matrimonio_persona_persona_cod_persona` foreign key (`cod_persona`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `matrimonio_persona` add constraint `fk_matrimonio_persona_matrimonio_cod_matrimonio` foreign key (`cod_matrimonio`) references `matrimonio`(`codigo`) on delete cascade on update cascade;

create table `carnet_minoridad` (
	`codigo` int auto_increment,
	`fecha_emision` date not null,
	`fecha_expiracion` date null,
	`fotografia` varchar(200) not null,
	`cod_empleado` int not null,
	`cod_persona` int not null,
	constraint pk_CarnetMinoridad primary key(`codigo`),
	constraint unq_CarnetMinoridad_fotografia unique(fotografia)
);
alter table `carnet_minoridad` add constraint `fk_carnet_minoridad_empleado_cod_empleado` foreign key (`cod_empleado`) references `empleado`(`codigo`) on delete no action on update cascade;
alter table `carnet_minoridad` add constraint `fk_carnet_minoridad_persona_cod_persona` foreign key (`cod_persona`) references `persona`(`codigo`) on delete cascade on update cascade;
