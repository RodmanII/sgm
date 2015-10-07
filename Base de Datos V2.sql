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
	`folio_actual` int not null default 2,
	constraint pk_Libro primary key(`codigo`),
	constraint unq_Libro_num_anyo_tipo unique(numero,anyo,tipo)
);
-- Inserción de Registros
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(1,2015,'Nacimiento',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(2,2015,'Nacimiento',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(1,2015,'Defuncion',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(2,2015,'Defuncion',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(1,2015,'Matrimonio',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(2,2015,'Matrimonio',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(1,2015,'Divorcio',0,2);
insert into libro(numero,anyo,tipo,cerrado,folio_actual) values(2,2015,'Divorcio',0,2);

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

create table `tipo_doc_identidad` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_TipoDocIdenti primary key(`codigo`),
	constraint unq_TipoDocIdenti_nombre unique(nombre)
);
insert into tipo_doc_identidad(nombre) values('Carnet de Identificación Personal');
insert into tipo_doc_identidad(nombre) values('Cédula de Identidad');

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

-- Inserción de Registros para Santa Ana
insert into municipio(nombre,cod_departamento) values('Candelaria de la Frontera',3);
insert into municipio(nombre,cod_departamento) values('Chalchuapa',3);
insert into municipio(nombre,cod_departamento) values('Coatepeque',3);
insert into municipio(nombre,cod_departamento) values('El Congo',3);
insert into municipio(nombre,cod_departamento) values('El Porvenir',3);
insert into municipio(nombre,cod_departamento) values('Masahuat',3);
insert into municipio(nombre,cod_departamento) values('Metapán',3);
insert into municipio(nombre,cod_departamento) values('San Antonio Pajonal',3);
insert into municipio(nombre,cod_departamento) values('San Sebastián Salitrillo',3);
insert into municipio(nombre,cod_departamento) values('Santa Ana',3);
insert into municipio(nombre,cod_departamento) values('Santa Rosa Guachipilín',3);
insert into municipio(nombre,cod_departamento) values('Santiago de la Frontera',3);
insert into municipio(nombre,cod_departamento) values('Texistepeque',3);

-- Inserción de Registros para Cabañas
insert into municipio(nombre,cod_departamento) values('Cinquera',4);
insert into municipio(nombre,cod_departamento) values('Dolores',4);
insert into municipio(nombre,cod_departamento) values('Guacotecti',4);
insert into municipio(nombre,cod_departamento) values('Ilobasco',4);
insert into municipio(nombre,cod_departamento) values('Jutiapa',4);
insert into municipio(nombre,cod_departamento) values('San Isidro',4);
insert into municipio(nombre,cod_departamento) values('Sensuntepeque',4);
insert into municipio(nombre,cod_departamento) values('Tejutepeque',4);
insert into municipio(nombre,cod_departamento) values('Victoria',4);

-- Inserción de Registros para Chalatenango
insert into municipio(nombre,cod_departamento) values('Agua Caliente',5);
insert into municipio(nombre,cod_departamento) values('Arcatao',5);
insert into municipio(nombre,cod_departamento) values('Azacualpa',5);
insert into municipio(nombre,cod_departamento) values('Chalatenango',5);
insert into municipio(nombre,cod_departamento) values('Comalapa',5);
insert into municipio(nombre,cod_departamento) values('Citalá',5);
insert into municipio(nombre,cod_departamento) values('Concepción Quezaltepeque',5);
insert into municipio(nombre,cod_departamento) values('Dulce Nombre de María',5);
insert into municipio(nombre,cod_departamento) values('El Carrizal',5);
insert into municipio(nombre,cod_departamento) values('El Paraíso',5);
insert into municipio(nombre,cod_departamento) values('La Laguna',5);
insert into municipio(nombre,cod_departamento) values('La Palma',5);
insert into municipio(nombre,cod_departamento) values('La Reina',5);
insert into municipio(nombre,cod_departamento) values('Las Vueltas',5);
insert into municipio(nombre,cod_departamento) values('Nueva Concepción',5);
insert into municipio(nombre,cod_departamento) values('Nueva Trinidad',5);
insert into municipio(nombre,cod_departamento) values('Nombre de Jesús',5);
insert into municipio(nombre,cod_departamento) values('Ojos de Agua',5);
insert into municipio(nombre,cod_departamento) values('Potonico',5);
insert into municipio(nombre,cod_departamento) values('San Antonio de la Cruz',5);
insert into municipio(nombre,cod_departamento) values('San Antonio Los Ranchos',5);
insert into municipio(nombre,cod_departamento) values('San Fernando',5);
insert into municipio(nombre,cod_departamento) values('San Francisco Lempa',5);
insert into municipio(nombre,cod_departamento) values('San Francisco Morazán',5);
insert into municipio(nombre,cod_departamento) values('San Ignacio',5);
insert into municipio(nombre,cod_departamento) values('San Isidro Labrador',5);
insert into municipio(nombre,cod_departamento) values('San José Cancasque',5);
insert into municipio(nombre,cod_departamento) values('San José Las Flores',5);
insert into municipio(nombre,cod_departamento) values('San Luis del Carmen',5);
insert into municipio(nombre,cod_departamento) values('San Miguel de Mercedes',5);
insert into municipio(nombre,cod_departamento) values('San Rafael',5);
insert into municipio(nombre,cod_departamento) values('Santa Rita',5);
insert into municipio(nombre,cod_departamento) values('Tejutla',5);

-- Inserción de Registros para Cuscatlán
insert into municipio(nombre,cod_departamento) values('Candelaria',6);
insert into municipio(nombre,cod_departamento) values('Cojutepeque',6);
insert into municipio(nombre,cod_departamento) values('El Carmen',6);
insert into municipio(nombre,cod_departamento) values('El Rosario',6);
insert into municipio(nombre,cod_departamento) values('Monte San Juan',6);
insert into municipio(nombre,cod_departamento) values('Oratorio de Concepción',6);
insert into municipio(nombre,cod_departamento) values('San Bartolomé Perulapía',6);
insert into municipio(nombre,cod_departamento) values('San Cristóbal',6);
insert into municipio(nombre,cod_departamento) values('San José Guayabal',6);
insert into municipio(nombre,cod_departamento) values('San Pedro Perulapán',6);
insert into municipio(nombre,cod_departamento) values('San Rafael Cedros',6);
insert into municipio(nombre,cod_departamento) values('San Ramón',6);
insert into municipio(nombre,cod_departamento) values('Santa Cruz Analquito',6);
insert into municipio(nombre,cod_departamento) values('Santa Cruz Michapa',6);
insert into municipio(nombre,cod_departamento) values('Suchitoto',6);
insert into municipio(nombre,cod_departamento) values('Tenancingo',6);

-- Inserción de Registros para La Libertad
insert into municipio(nombre,cod_departamento) values('Antiguo Cuscatlán',7);
insert into municipio(nombre,cod_departamento) values('Chiltiupán',7);
insert into municipio(nombre,cod_departamento) values('Ciudad Arce',7);
insert into municipio(nombre,cod_departamento) values('Colón',7);
insert into municipio(nombre,cod_departamento) values('Comasagua',7);
insert into municipio(nombre,cod_departamento) values('Huizúcar',7);
insert into municipio(nombre,cod_departamento) values('Jayaque',7);
insert into municipio(nombre,cod_departamento) values('Jicalapa',7);
insert into municipio(nombre,cod_departamento) values('La Libertad',7);
insert into municipio(nombre,cod_departamento) values('Santa Tecla',7);
insert into municipio(nombre,cod_departamento) values('Nuevo Cuscatlán',7);
insert into municipio(nombre,cod_departamento) values('San Juan Opico',7);
insert into municipio(nombre,cod_departamento) values('Quezaltepeque',7);
insert into municipio(nombre,cod_departamento) values('Sacacoyo',7);
insert into municipio(nombre,cod_departamento) values('San José Villanueva',7);
insert into municipio(nombre,cod_departamento) values('San Matías',7);
insert into municipio(nombre,cod_departamento) values('San Pablo Tacachico',7);
insert into municipio(nombre,cod_departamento) values('Talnique',7);
insert into municipio(nombre,cod_departamento) values('Tamanique',7);
insert into municipio(nombre,cod_departamento) values('Teotepeque',7);
insert into municipio(nombre,cod_departamento) values('Tepecoyo',7);
insert into municipio(nombre,cod_departamento) values('Zaragoza',7);

-- Inserción de Registros para La Paz
insert into municipio(nombre,cod_departamento) values('Cuyultitán',8);
insert into municipio(nombre,cod_departamento) values('El Rosario',8);
insert into municipio(nombre,cod_departamento) values('Jerusalén',8);
insert into municipio(nombre,cod_departamento) values('Mercedes La Ceiba',8);
insert into municipio(nombre,cod_departamento) values('Olocuilta',8);
insert into municipio(nombre,cod_departamento) values('Paraíso de Osorio',8);
insert into municipio(nombre,cod_departamento) values('San Antonio Masahuat',8);
insert into municipio(nombre,cod_departamento) values('San Emigdio',8);
insert into municipio(nombre,cod_departamento) values('San Francisco Chinameca',8);
insert into municipio(nombre,cod_departamento) values('San Juan Nonualco',8);
insert into municipio(nombre,cod_departamento) values('San Juan Talpa',8);
insert into municipio(nombre,cod_departamento) values('San Juan Tepezontes',8);
insert into municipio(nombre,cod_departamento) values('San Luis Talpa',8);
insert into municipio(nombre,cod_departamento) values('San Luis La Herradura',8);
insert into municipio(nombre,cod_departamento) values('San Miguel Tepezontes',8);
insert into municipio(nombre,cod_departamento) values('San Pedro Masahuat',8);
insert into municipio(nombre,cod_departamento) values('San Pedro Nonualco',8);
insert into municipio(nombre,cod_departamento) values('San Rafael Obrajuelo',8);
insert into municipio(nombre,cod_departamento) values('Santa María Ostuma',8);
insert into municipio(nombre,cod_departamento) values('Santiago Nonualco',8);
insert into municipio(nombre,cod_departamento) values('Tapalhuaca',8);
insert into municipio(nombre,cod_departamento) values('Zacatecoluca',8);

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

-- Inserción de Registros para San Vicente
insert into municipio(nombre,cod_departamento) values('Apastepeque',10);
insert into municipio(nombre,cod_departamento) values('Guadalupe',10);
insert into municipio(nombre,cod_departamento) values('San Cayetano Istepeque',10);
insert into municipio(nombre,cod_departamento) values('San Esteban Catarina',10);
insert into municipio(nombre,cod_departamento) values('San Ildefonso',10);
insert into municipio(nombre,cod_departamento) values('San Lorenzo',10);
insert into municipio(nombre,cod_departamento) values('San Sebastián',10);
insert into municipio(nombre,cod_departamento) values('San Vicente',10);
insert into municipio(nombre,cod_departamento) values('Santa Clara',10);
insert into municipio(nombre,cod_departamento) values('Santo Domingo',10);
insert into municipio(nombre,cod_departamento) values('Tecoluca',10);
insert into municipio(nombre,cod_departamento) values('Tepetitán',10);
insert into municipio(nombre,cod_departamento) values('Verapaz',10);

-- Inserción de Registros para Morazán
insert into municipio(nombre,cod_departamento) values('Arambala',11);
insert into municipio(nombre,cod_departamento) values('Cacaopera',11);
insert into municipio(nombre,cod_departamento) values('Chilanga',11);
insert into municipio(nombre,cod_departamento) values('Corinto',11);
insert into municipio(nombre,cod_departamento) values('Delicias de Concepción',11);
insert into municipio(nombre,cod_departamento) values('El Divisadero',11);
insert into municipio(nombre,cod_departamento) values('El Rosario',11);
insert into municipio(nombre,cod_departamento) values('Gualococti',11);
insert into municipio(nombre,cod_departamento) values('Guatajiagua',11);
insert into municipio(nombre,cod_departamento) values('Joateca',11);
insert into municipio(nombre,cod_departamento) values('Jocoaitique',11);
insert into municipio(nombre,cod_departamento) values('Jocoro',11);
insert into municipio(nombre,cod_departamento) values('Lolotiquillo',11);
insert into municipio(nombre,cod_departamento) values('Meanguera',11);
insert into municipio(nombre,cod_departamento) values('Osicala',11);
insert into municipio(nombre,cod_departamento) values('Perquín',11);
insert into municipio(nombre,cod_departamento) values('San Carlos',11);
insert into municipio(nombre,cod_departamento) values('San Fernando',11);
insert into municipio(nombre,cod_departamento) values('San Francisco Gotera',11);
insert into municipio(nombre,cod_departamento) values('San Isidro',11);
insert into municipio(nombre,cod_departamento) values('San Simón',11);
insert into municipio(nombre,cod_departamento) values('Sensembra',11);
insert into municipio(nombre,cod_departamento) values('Sociedad',11);
insert into municipio(nombre,cod_departamento) values('Torola',11);
insert into municipio(nombre,cod_departamento) values('Yamabal',11);
insert into municipio(nombre,cod_departamento) values('Yoloaiquín',11);

-- Inserción de Registros para San Miguel
insert into municipio(nombre,cod_departamento) values('Carolina',12);
insert into municipio(nombre,cod_departamento) values('Chapeltique',12);
insert into municipio(nombre,cod_departamento) values('Chinameca',12);
insert into municipio(nombre,cod_departamento) values('Chirilagua',12);
insert into municipio(nombre,cod_departamento) values('Ciudad Barrios',12);
insert into municipio(nombre,cod_departamento) values('Comacarán',12);
insert into municipio(nombre,cod_departamento) values('El Tránsito',12);
insert into municipio(nombre,cod_departamento) values('Lolotique',12);
insert into municipio(nombre,cod_departamento) values('Moncagua',12);
insert into municipio(nombre,cod_departamento) values('Nueva Guadalupe',12);
insert into municipio(nombre,cod_departamento) values('Nuevo Edén de San Juan',12);
insert into municipio(nombre,cod_departamento) values('Quelepa',12);
insert into municipio(nombre,cod_departamento) values('San Antonio del Mosco',12);
insert into municipio(nombre,cod_departamento) values('San Gerardo',12);
insert into municipio(nombre,cod_departamento) values('San Jorge',12);
insert into municipio(nombre,cod_departamento) values('San Luis de la Reina',12);
insert into municipio(nombre,cod_departamento) values('San Miguel',12);
insert into municipio(nombre,cod_departamento) values('San Rafael Oriente',12);
insert into municipio(nombre,cod_departamento) values('Sesori',12);
insert into municipio(nombre,cod_departamento) values('Uluazapa',12);

-- Inserción de Registros para Usulután
insert into municipio(nombre,cod_departamento) values('Alegría',13);
insert into municipio(nombre,cod_departamento) values('Berlín',13);
insert into municipio(nombre,cod_departamento) values('California',13);
insert into municipio(nombre,cod_departamento) values('Concepción Batres',13);
insert into municipio(nombre,cod_departamento) values('El Triunfo',13);
insert into municipio(nombre,cod_departamento) values('Ereguayquín',13);
insert into municipio(nombre,cod_departamento) values('Estanzuelas',13);
insert into municipio(nombre,cod_departamento) values('Jiquilisco',13);
insert into municipio(nombre,cod_departamento) values('Jucuapa',13);
insert into municipio(nombre,cod_departamento) values('Jucuarán',13);
insert into municipio(nombre,cod_departamento) values('Mercedes Umaña',13);
insert into municipio(nombre,cod_departamento) values('Nueva Granada',13);
insert into municipio(nombre,cod_departamento) values('Ozatlán',13);
insert into municipio(nombre,cod_departamento) values('Puerto El Triunfo',13);
insert into municipio(nombre,cod_departamento) values('San Agustín',13);
insert into municipio(nombre,cod_departamento) values('San Buenaventura',13);
insert into municipio(nombre,cod_departamento) values('San Dionisio',13);
insert into municipio(nombre,cod_departamento) values('San Francisco Javier',13);
insert into municipio(nombre,cod_departamento) values('Santa Elena',13);
insert into municipio(nombre,cod_departamento) values('Santa María',13);
insert into municipio(nombre,cod_departamento) values('Santiago de María',13);
insert into municipio(nombre,cod_departamento) values('Tecapán',13);
insert into municipio(nombre,cod_departamento) values('Usulután',13);

-- Inserción de Registros para La Unión
insert into municipio(nombre,cod_departamento) values('Anamorós',14);
insert into municipio(nombre,cod_departamento) values('Bolivar',14);
insert into municipio(nombre,cod_departamento) values('Concepción de Oriente',14);
insert into municipio(nombre,cod_departamento) values('Conchagua',14);
insert into municipio(nombre,cod_departamento) values('El Carmen',14);
insert into municipio(nombre,cod_departamento) values('El Sauce',14);
insert into municipio(nombre,cod_departamento) values('Intipucá',14);
insert into municipio(nombre,cod_departamento) values('La Unión',14);
insert into municipio(nombre,cod_departamento) values('Lislique',14);
insert into municipio(nombre,cod_departamento) values('Meanguera del Golfo',14);
insert into municipio(nombre,cod_departamento) values('Nueva Esparta',14);
insert into municipio(nombre,cod_departamento) values('Pasaquina',14);
insert into municipio(nombre,cod_departamento) values('Polorós',14);
insert into municipio(nombre,cod_departamento) values('San Alejo',14);
insert into municipio(nombre,cod_departamento) values('San José',14);
insert into municipio(nombre,cod_departamento) values('Santa Rosa de Lima',14);
insert into municipio(nombre,cod_departamento) values('Yayantique',14);
insert into municipio(nombre,cod_departamento) values('Yucuaiquín',14);

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
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional Especializado "Rosales"','San Salvador',158);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Juan José Fernández"','Zacamil',158);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional de la Mujer','San Salvador',158);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional Especializado de Niños "Benjamín Bloom"','San Salvador',158);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General y de Psiquiatría "Doctor José Molina Martínez"','Soyapango', 158);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Neumología y Medicina Familiar "Doctor José Antonio Saldaña"','San Salvador',158);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Enfermera Angélica Vidal de Najarro"','San Bartolo', 151);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional Regional "San Juan de Dios"','Santa Ana',38);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Chalchuapa','Santa Ana',38);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Arturo Morales"','Metapán',38);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Francisco Menéndez"','Ahuachapán',1);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Jorge Mazzini Villacorta"','Sonsonate',27);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "San Rafael"','Santa Tecla',109);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Luis Edmundo Vásquez"','Chalatenango',54);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Nueva Concepción','Chalatenango',54);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Cojutepeque','Cuscatlán',100);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Suchitoto','Cuscatlán',100);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Santa Teresa"','Zacatecoluca',143);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Sensuntepeque','Sensuntepeque',48);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor José Luís Saca"','Ilobasco',45);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Santa Gertrudis"','San Vicente',170);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Jiquilisco','Usulután',244);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "San Pedro"','Usulután',244);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Jorge Arturo Mena"','Santiago de María',244);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Nueva Guadalupe','San Miguel',218);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Monseñor Oscar Arnulfo Romero y Galdámez"','Ciudad Barrios',218);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General "Doctor Héctor Antonio Hernández Flores"','San Francisco Gotera',194);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de La Unión','La Unión',252);
insert into hospital(nombre,ubicacion,cod_municipio) values('Hospital Nacional General de Santa Rosa de Lima','La Unión',252);

create table `unidad` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	constraint pk_Unidad primary key(`codigo`),
	constraint unq_Unidad_nombre unique(nombre)
);
-- Inserción de Registros para Unidad
insert into unidad(nombre) values('Registro del Estado Familiar');
insert into unidad(nombre) values('Recolección de Desechos Sólidos');
insert into unidad(nombre) values('Registro Tributario');
insert into unidad(nombre) values('Desarrollo Urbano y Rural');
insert into unidad(nombre) values('Desarrollo Ciudadano Municipal');

create table `informante` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`tipo_documento` varchar(50) not null,
	`numero_documento` varchar(100) not null,
	`genero` varchar(50) not null,
	constraint pk_Informante primary key(`codigo`),
	constraint unq_Informante_nombre unique(nombre),
	constraint unq_Informante_numero_documento unique(numero_documento)
);
insert into informante(nombre,tipo_documento,numero_documento,genero) values('Fabián Ernesto Clavico Fútil','Documento Único de Identidad','cero cuatro nueve cinco cinco cuatro nueve siete-tres','Masculino');
insert into informante(nombre,tipo_documento,numero_documento,genero) values('Sandra Valentina Rios Luna','Documento Único de Identidad','cero cuatro ocho tres dos cuatro cero siete-siete','Femenino');
insert into informante(nombre,tipo_documento,numero_documento,genero) values('Leonardo Ernesto Fernández Gunter','Documento Nacional de Identidad','uno tres cero tres dos nueve cero siete-cinco','Masculino');
insert into informante(nombre,tipo_documento,numero_documento,genero) values('James Howlet','Pasaporte','e i dos cinco siete nueve nueve tres e','Femenino');
insert into informante(nombre,tipo_documento,numero_documento,genero) values('Thomas David Blaskowitz','Pasaporte','a o uno cuatro seis nueve tres','Masculino');

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
insert into rol(nombre) values('Usuario');

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
insert into usuario(nombre,contrasenya,salt,cod_rol) values ('rodrigo','50116cb87536c9c9a414f13093fc3a7073d05bb22e68b5249546729d8caea87479ea11ba79cb9c7c5d9f6ca27d21d442a35bbce1dc657b36510b873b2c2e2890','KCma6npWyLQ',4);
insert into usuario(nombre,contrasenya,salt,cod_rol) values ('verdugo','cdea91f725d0023cecf95eb2dc352bb09ff174bea76ff9d94e3c71e1708a2501419576172f8e50c96de26f8738e618a7e3feab3981db921cc1df26c8c96cd053','YoSpMe9bwFk',4);

create table `persona` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`apellido` varchar(50) not null,
	`dui` char(9) null,
	`nit` char(14) null,
	`otro_doc` varchar(80) null,
	`fecha_nacimiento` date not null,
	`genero` varchar(50) not null,
	`direccion` varchar(200) not null,
	`profesion` varchar(50) null,
	`estado` varchar(50) not null default 'Activo',
	`cod_municipio` int not null,
	`cod_nacionalidad` int not null,
	`cod_estado_civil` int not null,
	`nombre_usuario` varchar(50) null,
	constraint pk_Persona primary key(`codigo`),
	constraint unq_Persona_dui unique(dui),
	constraint unq_Persona_nit unique(nit),
	constraint unq_Persona_nombre_usuario unique(nombre_usuario)
);
alter table `persona` add constraint `fk_persona_usuario_nombre_usuario` foreign key (`nombre_usuario`) references `usuario`(`nombre`) on delete no action on update cascade;
alter table `persona` add constraint `fk_persona_estado_civil_cod_estado_civil` foreign key (`cod_estado_civil`) references `estado_civil`(`codigo`) on delete no action on update cascade;
alter table `persona` add constraint `fk_persona_nacionalidad_cod_nacionalidad` foreign key (`cod_nacionalidad`) references `nacionalidad`(`codigo`) on delete no action on update cascade;
alter table `persona` add constraint `fk_persona_municipio_cod_municipio` foreign key (`cod_municipio`) references `municipio`(`codigo`) on delete no action on update cascade;
-- Inserción de Registros para Persona
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Alicia Guadalupe', 'López', '048501627', '05151032645014', '1971-02-25', 'Femenino', 'Santa Tecla, Departamento de La Libertad', 'Profesora', 158, 1, 2, 'garflax');
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Rodrigo Osvaldo', 'Grijalva López', '0484019150023', '0515103145', '1993-09-14', 'Masculino', 'Ilopango, Departamento de San Salvador', 'Estudiante', 154, 1, 4, 'girflax');
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Hugo Ernesto', 'Grijalva Pérez', '014501627', '05171032641145', '1967-10-09', 'Masculino', 'San Sebastián, Departamento de Chalatenango', 'Administrativo', 64, 3, 1, 'gorflax');
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Claudia Maribel', 'Flores Valle', '562101627', '62301032647801', '1995-10-09', 'Femenino', 'San Marcos, Departamento de San Salvador', 'Secretaria', 74, 5, 3, 'verdugo');
insert into persona(nombre, apellido, dui, nit, fecha_nacimiento, genero, direccion, profesion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Carla Maria', 'Castillo Navarrete', '565171647', '62321027642304', '1992-03-17', 'Femenino', 'Ciudad Valdez, Departamento de Santa Ana', 'Inactivo', 62, 6, 5, 'gerflax');
-- Menos de 18 que van a figurar como padres
insert into persona(nombre, apellido, otro_doc, fecha_nacimiento, genero, direccion, profesion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('William Eduardo', 'Castro Paz', 'Carnet de BoyScoutt:45126320', '1995-07-22', 'Masculino', 'Loc Muine, Departamento de Temeria', 'Mecánico Soldador', 'Activo', 101, 2, 3, null);
insert into persona(nombre, apellido, otro_doc, fecha_nacimiento, genero, direccion, profesion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Cristina Angelica', 'Gomez Garcia', 'Tarjeta de Afiliación a CENAR:00845145', '1997-01-14', 'Femenino', 'Tor Lara, Departamento de Aedir', 'Asistente de oficina', 'Activo', 36, 1, 1, null);
insert into persona(nombre, apellido, otro_doc, fecha_nacimiento, genero, direccion, profesion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil,nombre_usuario)
values('Daniel Ortega', 'Gomez Gaspan', 'Carnet de EUPRIDES:7741301', '1996-08-16', 'Masculino', 'Teirgel, Departamento de Kaer Morhen', 'Técnico de Hardware', 'Activo', 51, 4, 1, null);
-- Menores de 1 que van a figurar como asentados
insert into persona(nombre, apellido, fecha_nacimiento, genero, direccion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Ernesto Augusto', 'Flores Miran','2015-02-22', 'Masculino', 'Yelmo de Piedra, Departamento de Kwaeden', 'Activo', 22, 1, 1);
insert into persona(nombre, apellido, fecha_nacimiento, genero, direccion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Sonia Germinia', 'Gonzales Cortez','2015-04-27', 'Femenino', 'Paramo de Hierro, Departamento de Kovir', 'Activo', 62, 1, 1);
insert into persona(nombre, apellido, fecha_nacimiento, genero, direccion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Lourdes Anastasia', 'Gonzales Peña','2015-07-09', 'Femenino', 'Mahakan, Departamento de Temeria', 'Activo', 77, 1, 1);
insert into persona(nombre, apellido, fecha_nacimiento, genero, direccion, estado, cod_municipio, cod_nacionalidad, cod_estado_civil)
values('Maria José', 'Jurado Carmona','2014-12-15', 'Femenino', 'Rivendel, Departamento de Tierra Media', 'Activo', 11, 1, 1);

create table `empleado` (
	`codigo` int auto_increment,
	`cargo` varchar(50) not null,
	`cod_unidad` int not null,
	`cod_persona` int not null,
	constraint pk_Empleado primary key(`codigo`),
	constraint unq_Empleado_cod_persona unique(cod_persona)
);
alter table `empleado` add constraint `fk_empleado_unidad_cod_unidad` foreign key (`cod_unidad`) references `unidad`(`codigo`) on delete cascade on update cascade;
alter table `empleado` add constraint `fk_empleado_persona_cod_persona` foreign key (`cod_persona`) references `persona`(`codigo`) on delete cascade on update cascade;
-- Inserción de Registros para Empleado
insert into empleado(cargo,cod_unidad,cod_persona) values('Encargado de Inscripciones de Nacimiento',1,1);
insert into empleado(cargo,cod_unidad,cod_persona) values('Encargado de Inscripciones de Defunción',1,2);
insert into empleado(cargo,cod_unidad,cod_persona) values('Supervisor del Registro Familiar',1,3);
insert into empleado(cargo,cod_unidad,cod_persona) values('Supervisor de Cuadrillas de Recolección',2,4);
insert into empleado(cargo,cod_unidad,cod_persona) values('Miembro de Cuadrilla de Recolección',2,5);

create table `solicitud` (
	`codigo` int auto_increment,
	`fecha_emitida` date not null,
	`tipo_partida` varchar(50) not null,
	`nombre_inscrito` varchar(100) not null,
	`fecha_suceso` date not null,
	`nombre_padre` varchar(100) null,
	`nombre_madre` varchar(100) null,
	`estado` varchar(50) not null,
	`cod_persona` int not null,
	`cod_empleado` int null,
	`fecha_procesada` date null,
	`fecha_entregada` date null,
	constraint pk_Solicitud primary key(`codigo`)
);
alter table `solicitud` add constraint `fk_solicitud_persona_cod_persona` foreign key (`cod_persona`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `solicitud` add constraint `fk_solicitud_empleado_cod_empleado` foreign key (`cod_empleado`) references `empleado`(`codigo`) on delete cascade on update cascade;
-- Inserción de Registros para Solicitud
insert into solicitud(fecha_emitida,tipo_partida,nombre_inscrito,fecha_suceso,nombre_padre,nombre_madre,estado,cod_persona,cod_empleado,fecha_procesada,fecha_entregada)
values('2015-04-21','Nacimiento','Juan Ernesto Pérez Cruz','1986-07-11','Carlos Augusto Pérez Cruz','Alicia Magdalena Campos de Pérez','Finalizada',1,1,'2015-10-6','2015-10-12');
insert into solicitud(fecha_emitida,tipo_partida,nombre_inscrito,fecha_suceso,nombre_padre,nombre_madre,estado,cod_persona,cod_empleado,fecha_procesada,fecha_entregada)
values('2015-01-08','Defuncion','Debora Roxana Beltrán Pineda','2011-11-17',null,null,'Procesada',1,2,'2015-11-2',null);
insert into solicitud(fecha_emitida,tipo_partida,nombre_inscrito,fecha_suceso,nombre_padre,nombre_madre,estado,cod_persona,cod_empleado,fecha_procesada,fecha_entregada)
values('2015-05-14','Divorcio','Maria Anastasia Leiva Chacon','2004-01-27',null,null,'Finalizada',4,1,'2015-10-11','2015-10-16');
insert into solicitud(fecha_emitida,tipo_partida,nombre_inscrito,fecha_suceso,nombre_padre,nombre_madre,estado,cod_persona,cod_empleado,fecha_procesada,fecha_entregada)
values('2015-04-28','Matrimonio','William Adalberto Mejia Prieto','1998-03-05',null,null,'Pendiente',2,3,null,null);
insert into solicitud(fecha_emitida,tipo_partida,nombre_inscrito,fecha_suceso,nombre_padre,nombre_madre,estado,cod_persona,cod_empleado,fecha_procesada,fecha_entregada)
values('2013-08-06','Nacimiento','Francisco Rodrigo Minero Monje','2002-09-10','Carlos Javier Minero Monje','Claudia Guadalupe Sanchez de Monje','Procesada',5,1,'2015-10-6',null);

create table `vehiculo` (
	`numero` int auto_increment,
	`num_placa` varchar(10) not null,
	`fecha_compra` date not null,
	`estado` varchar(50) not null,
	`marca` varchar(50) not null,
	`modelo` varchar(50) null,
	`anyo` year null,
	`capacidad` int not null,
	`cod_conductor` int not null,
	constraint pk_Vehiculo primary key(`numero`),
	constraint unq_Vehiculo_cod_conductor unique(cod_conductor),
	constraint unq_Vehiculo_num_placa unique(num_placa)
);
alter table `vehiculo` add constraint `fk_vehiculo_empleado_cod_conductor` foreign key (`cod_conductor`) references `empleado`(`codigo`) on delete no action on update cascade;

create table `partida` (
		`codigo` int auto_increment,
		`folio` int not null,
		`fecha_emision` date not null,
		`fecha_suceso` date not null,
		`hora_suceso` time not null,
		`lugar_suceso` varchar(100) null,
		`cod_empleado` int not null,
		`cod_municipio` int not null,-- Municipio del suceso
		`cod_informante` int null,
		`cod_libro` int not null,
		constraint pk_Partida primary key(`codigo`),
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
	`cod_partida` int not null,
	`rel_informante` varchar(50) not null,
	constraint pk_Nacimiento primary key(`codigo`),
	constraint unq_Nacimiento_cod_asentado unique(cod_asentado),
	constraint unq_Nacimiento_cod_partida unique(cod_partida)
);
alter table `nacimiento` add constraint `fk_nacimiento_persona_cod_asentado` foreign key (`cod_asentado`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_persona_cod_padre` foreign key (`cod_padre`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_persona_cod_madre` foreign key (`cod_madre`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_hospital_cod_hospital` foreign key (`cod_hospital`) references `hospital`(`codigo`) on delete no action on update cascade;
alter table `nacimiento` add constraint `fk_nacimiento_partida_cod_partida` foreign key (`cod_partida`) references `partida`(`codigo`) on delete cascade on update cascade;

create table `matrimonio` (
	`codigo` int auto_increment,
	`notario` varchar(50) not null,
	`testigos` varchar(300) not null,
	`padre_contrayente_h` varchar(50) null,
	`madre_contrayente_h` varchar(50) null,
	`padre_contrayente_m` varchar(50) null,
	`madre_contrayente_m` varchar(50) null,
	`cod_reg_patrimonial` int not null,
	`cod_partida` int not null,
	`num_etr_publica` int not null,
	constraint pk_Matrimonio primary key(`codigo`),
	constraint unq_Matrimonio_cod_partida unique(cod_partida)
);
alter table `matrimonio` add constraint `fk_matrimonio_regimen_patrimonial_cod_reg_patrimonial` foreign key (`cod_reg_patrimonial`) references `regimen_patrimonial`(`codigo`) on delete no action on update cascade;
alter table `matrimonio` add constraint `fk_matrimonio_partida_cod_partida` foreign key (`cod_partida`) references `partida`(`codigo`) on delete cascade on update cascade;

create table `defuncion` (
	`codigo` int auto_increment,
	`determino_causa` varchar(100) not null,
	`familiares` varchar(300) not null,
	`cod_difunto` int not null,
	`cod_causa` int not null,
	`cod_partida` int not null,
	constraint pk_Defuncion primary key(`codigo`),
	constraint unq_Defuncion_cod_difunto unique(cod_difunto),
	constraint unq_Defuncion_cod_partida unique(cod_partida)
);
alter table `defuncion` add constraint `fk_defuncion_persona_cod_difunto` foreign key (`cod_difunto`) references `persona`(`codigo`) on delete cascade on update cascade;
alter table `defuncion` add constraint `fk_defuncion_partida_cod_partida` foreign key (`cod_partida`) references `partida`(`codigo`) on delete cascade on update cascade;
alter table `defuncion` add constraint `fk_defuncion_causa_cod_causa` foreign key (`cod_causa`) references `causa_defuncion`(`codigo`) on delete no action on update cascade;

create table `divorcio` (
	`codigo` int auto_increment,
	`juez` varchar(50) not null,
	`fecha_ejecucion` date not null,
	`detalle` varchar(300) null,
	`cod_partida` int not null,
	`cod_mod_divorcio` int not null,
	`cod_matrimonio` int not null,
	constraint pk_Divorcio primary key(`codigo`),
	constraint unq_Divorcio_cod_partida unique(cod_partida),
	constraint unq_Divorcio_cod_matrimonio unique(cod_matrimonio)
);
alter table `divorcio` add constraint `fk_divorcio_partida_cod_partida` foreign key (`cod_partida`) references `partida`(`codigo`) on delete cascade on update cascade;
alter table `divorcio` add constraint `fk_divorcio_matrimonio_cod_matrimonio` foreign key (`cod_matrimonio`) references `matrimonio`(`codigo`) on delete cascade on update cascade;
alter table `divorcio` add constraint `fk_divorcio_modalidad_divorcio_cod_mod_divorcio` foreign key (`cod_mod_divorcio`) references `modalidad_divorcio`(`codigo`) on delete no action on update cascade;

create table `recoleccion` (
	`codigo` int auto_increment,
	`fecha` date not null,
	`hora_salida` time not null,
	`hora_inicio_ruta` time null,
	`hora_regreso` time null,
	`kilometraje_entrada` int null,
	`kilometraje_salida` int not null,
	`kilometraje_recorrido` int null,
	`observaciones` varchar(300) null,
	`total_recoleccion` decimal(12,2) null,
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

-- Tabla de Auditoria
create table `auditoria` (
	`codigo` int auto_increment,
	`fecha` datetime not null,
	`accion` varchar(50) not null,
	`tabla` varchar(80) not null,
	`campos_afectados` text not null,
	`valor_anterior` text not null,
	`valor_nuevo` text not null,
	`nombre_usuario` varchar(50) not null,
	constraint pk_Auditoria primary key(`codigo`)
);
alter table `auditoria` add constraint `fk_auditoria_usuario_nombre_usuario` foreign key (`nombre_usuario`) references `usuario`(`nombre`) on delete no action on update cascade;

-- Tablas de Registro Histórico
create table `persona_historico` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`apellido` varchar(50) not null,
	`dui` char(9) null,
	`nit` char(14) null,
	`fecha_nacimiento` date not null,
	`genero` varchar(50) not null,
	`direccion` varchar(200) not null,
	`profesion` varchar(50) null,
	`estado` varchar(50) not null default 'Activo',
	`cod_municipio` int not null,
	`cod_nacionalidad` int not null,
	`cod_estado_civil` int not null,
	`nombre_usuario` varchar(50) null,
	constraint pk_PersonaHistorico primary key(`codigo`),
	constraint unq_PersonaHistorico_dui unique(dui),
	constraint unq_PersonaHistorico_nit unique(nit),
	constraint unq_PersonaHistorico_nombre_usuario unique(nombre_usuario)
);
alter table `persona_historico` add constraint `fk_persona_his_usuario_nombre_usuario` foreign key (`nombre_usuario`) references `usuario`(`nombre`) on delete no action on update cascade;
alter table `persona_historico` add constraint `fk_persona_his_estado_civil_cod_estado_civil` foreign key (`cod_estado_civil`) references `estado_civil`(`codigo`) on delete no action on update cascade;
alter table `persona_historico` add constraint `fk_persona_his_nacionalidad_cod_nacionalidad` foreign key (`cod_nacionalidad`) references `nacionalidad`(`codigo`) on delete no action on update cascade;
alter table `persona_historico` add constraint `fk_persona_his_municipio_cod_municipio` foreign key (`cod_municipio`) references `municipio`(`codigo`) on delete no action on update cascade;

create table `solicitud_historico` (
	`codigo` int auto_increment,
	`fecha_emitida` date not null,
	`tipo_partida` varchar(50) not null,
	`nombre_inscrito` varchar(100) not null,
	`fecha_suceso` date not null,
	`nombre_padre` varchar(100) null,
	`nombre_madre` varchar(100) null,
	`estado` varchar(50) not null,
	`cod_persona` int not null,
	`cod_empleado` int null,
	`fecha_procesada` date null,
	`fecha_entregada` date null,
	constraint pk_SolicitudHistorico primary key(`codigo`)
);
alter table `solicitud_historico` add constraint `fk_solicitud_his_persona_his_cod_persona` foreign key (`cod_persona`) references `persona_historico`(`codigo`) on delete cascade on update cascade;
alter table `solicitud_historico` add constraint `fk_solicitud_his_empleado_cod_empleado` foreign key (`cod_empleado`) references `empleado`(`codigo`) on delete cascade on update cascade;

create table `informante_historico` (
	`codigo` int auto_increment,
	`nombre` varchar(50) not null,
	`tipo_documento` varchar(50) not null,
	`numero_documento` varchar(100) not null,
	`genero` varchar(50) not null,
	constraint pk_InformanteHistorico primary key(`codigo`),
	constraint unq_InformanteHistorico_nombre unique(nombre),
	constraint unq_InformanteHistorico_numero_documento unique(numero_documento)
);

create table `partida_historico` (
		`codigo` int auto_increment,
		`folio` int not null,
		`fecha_emision` date not null,
		`fecha_suceso` date not null,
		`hora_suceso` time not null,
		`lugar_suceso` varchar(100) null,
		`cod_empleado` int not null,
		`cod_municipio` int not null,-- Municipio del suceso
		`cod_informante` int null,
		`cod_libro` int not null,
		constraint pk_PartidaHistorico primary key(`codigo`),
		constraint unq_PartidaHistorico_folio_cod_libro unique(folio,cod_libro)
);
alter table `partida_historico` add constraint `fk_partida_his_empleado_cod_empleado` foreign key (`cod_empleado`) references `empleado`(`codigo`) on delete no action on update cascade;
alter table `partida_historico` add constraint `fk_partida_his_municipio_cod_municipio` foreign key (`cod_municipio`) references `municipio`(`codigo`) on delete no action on update cascade;
alter table `partida_historico` add constraint `fk_partida_his_informante_his_cod_informante` foreign key (`cod_informante`) references `informante_historico`(`codigo`) on delete no action on update cascade;
alter table `partida_historico` add constraint `fk_partida_his_libro_cod_libro` foreign key (`cod_libro`) references `libro`(`codigo`) on delete no action on update cascade;

create table `matrimonio_historico` (
	`codigo` int auto_increment,
	`notario` varchar(50) not null,
	`testigos` varchar(300) not null,
	`padre_contrayente_h` varchar(50) null,
	`madre_contrayente_h` varchar(50) null,
	`padre_contrayente_m` varchar(50) null,
	`madre_contrayente_m` varchar(50) null,
	`cod_reg_patrimonial` int not null,
	`cod_partida` int not null,
	`num_etr_publica` int not null,
	constraint pk_MatrimonioHistorico primary key(`codigo`),
	constraint unq_MatrimonioHistorico_cod_partida unique(cod_partida)
);
alter table `matrimonio_historico` add constraint `fk_matrimonio_his_regimen_patrimonial_cod_reg_patrimonial` foreign key (`cod_reg_patrimonial`) references `regimen_patrimonial`(`codigo`) on delete no action on update cascade;
alter table `matrimonio_historico` add constraint `fk_matrimonio_his_partida_his_cod_partida` foreign key (`cod_partida`) references `partida_historico`(`codigo`) on delete cascade on update cascade;

create table `matrimonio_persona_historico` (
	`codigo` int auto_increment,
	`cod_persona` int not null,
	`cod_matrimonio` int not null,
	constraint pk_MatrimonioPersonaHistorico primary key(`codigo`),
	constraint unq_MatrimonioPersonaHistorico_cod_persona_cod_matrimonio unique(cod_persona,cod_matrimonio)
);
alter table `matrimonio_persona_historico` add constraint `fk_matrimonio_persona_his_persona_his_cod_persona` foreign key (`cod_persona`) references `persona_historico`(`codigo`) on delete cascade on update cascade;
alter table `matrimonio_persona_historico` add constraint `fk_matrimonio_persona_his_matrimonio_his_cod_matrimonio` foreign key (`cod_matrimonio`) references `matrimonio_historico`(`codigo`) on delete cascade on update cascade;

create table `nacimiento_historico` (
	`codigo` int auto_increment,
	`cod_padre` int null,
	`cod_madre` int null,
	`cod_asentado` int not null,
	`cod_hospital` int not null,
	`cod_partida` int not null,
	`rel_informante` varchar(50) not null,
	constraint pk_NacimientoHistorico primary key(`codigo`),
	constraint unq_NacimientoHistorico_cod_asentado unique(cod_asentado),
	constraint unq_NacimientoHistorico_cod_partida unique(cod_partida)
);
alter table `nacimiento_historico` add constraint `fk_nacimiento_his_persona_his_cod_asentado` foreign key (`cod_asentado`) references `persona_historico`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento_historico` add constraint `fk_nacimiento_his_persona_his_cod_padre` foreign key (`cod_padre`) references `persona_historico`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento_historico` add constraint `fk_nacimiento_his_persona_his_cod_madre` foreign key (`cod_madre`) references `persona_historico`(`codigo`) on delete cascade on update cascade;
alter table `nacimiento_historico` add constraint `fk_nacimiento_his_hospital_cod_hospital` foreign key (`cod_hospital`) references `hospital`(`codigo`) on delete no action on update cascade;
alter table `nacimiento_historico` add constraint `fk_nacimiento_his_partida_his_cod_partida` foreign key (`cod_partida`) references `partida_historico`(`codigo`) on delete cascade on update cascade;

create table `defuncion_historico` (
	`codigo` int auto_increment,
	`determino_causa` varchar(100) not null,
	`familiares` varchar(300) not null,
	`cod_difunto` int not null,
	`cod_causa` int not null,
	`cod_partida` int not null,
	constraint pk_DefuncionHistorico primary key(`codigo`),
	constraint unq_DefuncionHistorico_cod_difunto unique(cod_difunto),
	constraint unq_DefuncionHistorico_cod_partida unique(cod_partida)
);
alter table `defuncion_historico` add constraint `fk_defuncion_his_persona_his_cod_difunto` foreign key (`cod_difunto`) references `persona_historico`(`codigo`) on delete cascade on update cascade;
alter table `defuncion_historico` add constraint `fk_defuncion_his_partida_his_cod_partida` foreign key (`cod_partida`) references `partida_historico`(`codigo`) on delete cascade on update cascade;
alter table `defuncion_historico` add constraint `fk_defuncion_his_causa_cod_causa` foreign key (`cod_causa`) references `causa_defuncion`(`codigo`) on delete no action on update cascade;

create table `divorcio_historico` (
	`codigo` int auto_increment,
	`juez` varchar(50) not null,
	`fecha_ejecucion` date not null,
	`detalle` varchar(300) null,
	`cod_partida` int not null,
	`cod_mod_divorcio` int not null,
	`cod_matrimonio` int not null,
	constraint pk_DivorcioHistorico primary key(`codigo`),
	constraint unq_DivorcioHistorico_cod_partida unique(cod_partida),
	constraint unq_DivorcioHistorico_cod_matrimonio unique(cod_matrimonio)
);
alter table `divorcio_historico` add constraint `fk_divorcio_his_partida_his_cod_partida` foreign key (`cod_partida`) references `partida_historico`(`codigo`) on delete cascade on update cascade;
alter table `divorcio_historico` add constraint `fk_divorcio_his_matrimonio_his_cod_matrimonio` foreign key (`cod_matrimonio`) references `matrimonio_historico`(`codigo`) on delete cascade on update cascade;
alter table `divorcio_historico` add constraint `fk_divorcio_his_modalidad_divorcio_cod_mod_divorcio` foreign key (`cod_mod_divorcio`) references `modalidad_divorcio`(`codigo`) on delete no action on update cascade;

create table `recarga_historico` (
	`codigo` int auto_increment,
	`fecha` date not null,
	`hora` time not null,
	`galones_suministrados` decimal(8,2) not null,
	`valor` decimal(12,2) not null,
	`num_vehiculo` int not null,
	constraint pk_RecargaHistorico primary key(`codigo`)
);
alter table `recarga_historico` add constraint `fk_recarga_his_vehiculo_num_vehiculo` foreign key (`num_vehiculo`) references `vehiculo`(`numero`) on delete cascade on update cascade;

create table `recoleccion_historico` (
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
	constraint pk_RecoleccionHistorico primary key(`codigo`)
);
alter table `recoleccion_historico` add constraint `fk_recoleccion_his_vehiculo_num_vehiculo` foreign key (`num_vehiculo`) references `vehiculo`(`numero`) on delete cascade on update cascade;

create table `recoleccion_ruta_historico` (
	`codigo` int auto_increment,
	`estado_ruta` varchar(50) not null,
	`detalle` varchar(300) null,
	`cod_ruta` int not null,
	`cod_recoleccion` int not null,
	constraint pk_RecoleccionRutaHistorico primary key(`codigo`),
	constraint unq_RecoleccionRutaHistorico_cod_ruta_cod_recoleccion unique(cod_ruta,cod_recoleccion)
);
alter table `recoleccion_ruta_historico` add constraint `fk_recoleccion_ruta_his_ruta_cod_ruta` foreign key (`cod_ruta`) references `ruta`(`codigo`) on delete cascade on update cascade;
alter table `recoleccion_ruta_historico` add constraint `fk_recoleccion_ruta_his_recoleccion_his_cod_recoleccion` foreign key (`cod_recoleccion`) references `recoleccion_historico`(`codigo`) on delete cascade on update cascade;
