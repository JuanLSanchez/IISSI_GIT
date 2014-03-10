
--Creacion de tablas
drop sequence id_alquiler;
drop sequence id_catalogo;
drop sequence id_comestible;
drop sequence id_compra;
drop sequence id_devolucion;
drop sequence id_juego;
drop sequence id_laj;
drop sequence id_lap;
drop sequence id_lcp;
drop sequence id_ldj;
drop sequence id_ldp;
drop sequence id_ljp;
drop sequence id_lpp;
drop sequence id_oferta;
drop sequence id_opinion_juego;
drop sequence id_opinion_pelicula;
drop sequence id_pelicula;
drop sequence id_proveedor;
drop sequence id_vp;
drop sequence id_vsm;

drop table socios cascade constraints;
drop table catalogos cascade constraints;
drop table proveedores cascade constraints;
drop table comestibles cascade constraints;
drop table peliculas cascade constraints;
drop table juegos cascade constraints;
drop table generos_peliculas cascade constraints;
drop table calidad_visual cascade constraints;
drop table relacion_peliculas_genero cascade constraints;
drop table relacion_peliculas_calidad cascade constraints;
drop table generos_juegos cascade constraints;
drop table plataformas cascade constraints;
drop table relacion_juegos_genero cascade constraints;
drop table relacion_juegos_plataforma cascade constraints;
drop table ventas_proveedores cascade constraints;
drop table lineas_juegos_proveedores cascade constraints;
drop table lineas_peliculas_proveedores cascade constraints;
drop table lineas_comestibles_proveedores cascade constraints;
drop table peliculas_favoritos cascade constraints;
drop table juegos_favoritos cascade constraints;
drop table peliculas_pendientes cascade constraints;
drop table juegos_pendientes cascade constraints;
drop table peliculas_vistas cascade constraints;
drop table juegos_vistos cascade constraints;
drop table ofertas cascade constraints;
drop table alquileres cascade constraints;
drop table lineas_alquileres_juegos cascade constraints;
drop table lineas_alquileres_peliculas cascade constraints;
drop table devoluciones cascade constraints;
drop table lineas_devoluciones_juegos cascade constraints;
drop table lineas_devoluciones_peliculas cascade constraints;
drop table ventas_segunda_mano cascade constraints;
drop table lvsmj cascade constraints;
drop table lvsmp cascade constraints;
drop table opiniones_juegos cascade constraints;
drop table opiniones_peliculas cascade constraints;
drop table puntuaciones_juegos cascade constraints;
drop table puntuaciones_peliculas cascade constraints;
drop table amigos cascade constraints;
drop table compras cascade constraints;
drop table lineas_compras_juegos cascade constraints;
drop table lineas_compras_peliculas cascade constraints;
drop table lineas_compras_comestibles cascade constraints;
drop table reservas_juegos cascade constraints;
drop table reservas_peliculas cascade constraints;
drop table relacion_catalogos_peliculas cascade constraints;
drop table relacion_catalogos_juegos cascade constraints;


create table socios(
	dni varchar2(9),
	nombre varchar2(50) not null,
	nacido date not null,
	registrado date not null,
	direccion varchar2(50) not null,
	email varchar2(50),
	telefono number(9,0),
	key varchar2(30),
	primary key(dni),
	check ( regexp_like (dni, '^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]'))
);

create table catalogos(
	id_catalogo number(20,0),
	nombre varchar2(50) not null,
	lanzamiento date,
	primary key(id_catalogo)
);

create table proveedores(
	id_proveedor number(20,0),
	nombre varchar2(50) not null,
	telefono number(9,0),
	primary key(id_proveedor)
);

create table comestibles(
	id_comestible number(20,0),
	nombre varchar2(50),
	cantidad number(4,0),
	precio number(5,2),
	primary key(id_comestible),
	check (cantidad>=0),
	check (precio>0)
);

create table peliculas(
	id_pelicula number(20,0),
	nombre varchar2(50) not null,
	edad_restrictiva number(2,0) not null,
	imagen varchar2(50),
	trailer varchar2(150),
	sinopsis varchar2(3500),
	year date,
	primary key(id_pelicula),
	unique(nombre)
);

create table juegos(
	id_juego number(20,0),
	nombre varchar2(50) not null,
	edad_restrictiva number(2,0) not null,
	imagen varchar2(50),
	trailer varchar2(150),
	sinopsis varchar2(3500),
	year date,
	primary key(id_juego),
	unique(nombre)
);

create table generos_peliculas(
	genero varchar2(20),
	primary key(genero)
);

create table calidad_visual(
	calidad varchar2(20),
	primary key(calidad)
);

create table relacion_peliculas_genero(
	id_pelicula number(20,0),
	genero varchar2(20),	
	primary key(id_pelicula, genero),
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(genero) references generos_peliculas(genero) on delete cascade
);

create table relacion_peliculas_calidad(
	id_pelicula number(20,0),
	calidad varchar2(20),
	precio number(5,2),
	cantidad number(2),
	alquiler number(2,0),
	check (precio>0),
	primary key(id_pelicula, calidad),
	foreign key(calidad) references calidad_visual(calidad) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);

create table generos_juegos(
	genero varchar2(20),
	primary key(genero)
);

create table plataformas(
	plataforma varchar2(20),
	primary key(plataforma)
);

create table relacion_juegos_genero(
	id_juego number(20,0),
	genero varchar2(20),
	primary key(id_juego, genero),
	foreign key(genero) references generos_juegos(genero) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table relacion_juegos_plataforma(
	id_juego number(20,0),
	plataforma varchar2(20),
	precio number(5,2),
	cantidad number(2),
	alquiler number(2,0),
	check (precio>0),
	primary key(plataforma, id_juego),
	foreign key(plataforma) references plataformas(plataforma) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table ventas_proveedores(
	id_vp number(20,0),
	fecha date,
	id_proveedor number(20,0),
	primary key(id_vp),
	foreign key(id_proveedor) references proveedores(id_proveedor) on delete cascade
);


create table lineas_juegos_proveedores(
	id_ljp number(20,0),
	id_juego number(20,0),
	id_vp number(20,0),
	precio number(6,2),
	cantidad number(3,0),
	plataforma varchar2(20),
	primary key(id_ljp),
	foreign key(plataforma) references plataformas(plataforma) on delete cascade,
	foreign key(id_vp) references ventas_proveedores(id_vp) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table lineas_peliculas_proveedores(
	id_lpp number(20,0),
	id_pelicula number(20,0),
	id_vp number(20,0),
	precio number(6,2),
	cantidad number(3,0),
	calidad varchar2(20),
	primary key(id_lpp),
	foreign key(calidad) references calidad_visual(calidad) on delete cascade,
	foreign key(id_vp) references ventas_proveedores(id_vp) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);


create table lineas_comestibles_proveedores(
	id_lcp number(20,0),
	id_comestible number(20,0),
	id_vp number(20,0),
	precio number(6,2),
	cantidad number(3,0),
	primary key(id_lcp),
	foreign key(id_vp) references ventas_proveedores(id_vp) on delete cascade,
	foreign key(id_comestible) references comestibles(id_comestible) on delete cascade
);

create table peliculas_favoritos(
	dni varchar2(9),
	id_pelicula number(20,0),
	primary key(dni, id_pelicula),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);

create table juegos_favoritos(
	dni varchar2(9),
	id_juego number(20,0),
	primary key(dni, id_juego),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table peliculas_pendientes(
	dni varchar2(9),
	id_pelicula number(20,0),
	primary key(dni, id_pelicula),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);

create table juegos_pendientes(
	dni varchar2(9),
	id_juego number(20,0),
	primary key(dni, id_juego),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table peliculas_vistas(
	dni varchar2(9),
	id_pelicula number(20,0),
	primary key(dni, id_pelicula),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);

create table juegos_vistos(
	dni varchar2(9),
	id_juego number(20,0),
	primary key(dni, id_juego),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table ofertas(
	id_oferta number(20,0),
	texto varchar2(200),
	fecha_inicio date,
	fecha_fin date,
	precio number(6,2),
	primary key(id_oferta)
);

create table alquileres(
	id_alquiler number(20,0),
	fecha date not null,
	tiempo number(3,0) not null,
	dni varchar2(9),
	primary key(id_alquiler),
	foreign key(dni) references socios(dni) on delete cascade
);

create table lineas_alquileres_juegos(
	id_laj number(20,0),
	cantidad number(3,0),
	id_oferta number(20,0) not null,
	id_alquiler number(20,0),
	id_juego number(20,0),
	plataforma varchar2(20),
	primary key(id_laj),
	unique(id_alquiler, id_juego, plataforma),
	foreign key(plataforma) references plataformas(plataforma) on delete cascade,
	foreign key(id_oferta) references ofertas(id_oferta) on delete cascade,
	foreign key(id_alquiler) references alquileres(id_alquiler) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table lineas_alquileres_peliculas(
	id_lap number(20,0),
	cantidad number(3,0),
	id_oferta number(20,0) not null,
	id_alquiler number(20,0),
	id_pelicula number(20,0),
	calidad varchar2(20),
	primary key(id_lap),
	unique(id_alquiler, id_pelicula, calidad),
	foreign key(calidad) references calidad_visual(calidad) on delete cascade,
	foreign key(id_oferta) references ofertas(id_oferta) on delete cascade,
	foreign key(id_alquiler) references alquileres(id_alquiler) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);

create table devoluciones(
	id_devolucion number(20,0),
	id_alquiler number(20),
	fecha date,
	dni varchar2(9),
	primary key(id_devolucion),
	foreign key(dni) references socios(dni) on delete cascade
);

create table lineas_devoluciones_juegos(
	id_ldj number(20,0),
	cantidad number(3,0),
	defectuoso number(1,0),
	id_juego number(20,0),
	id_devolucion number(20,0),
	plataforma varchar2(20),
	primary key(id_ldj),
	foreign key(plataforma) references plataformas(plataforma) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade,
	foreign key(id_devolucion) references devoluciones(id_devolucion),
	check (defectuoso=1 or defectuoso=0)
);

create table lineas_devoluciones_peliculas(
	id_ldp number(20,0),
	cantidad number(3,0),
	defectuoso number(1,0),
	id_pelicula number(20,0),
	id_devolucion number(20,0),
	calidad varchar2(20),
	primary key(id_ldp),
	foreign key(calidad) references calidad_visual(calidad) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(id_devolucion) references devoluciones(id_devolucion) on delete cascade,
	check (defectuoso=1 or defectuoso=0)
);

create table ventas_segunda_mano(
	id_vsm number(20,0),
	fecha date,
	dni varchar2(9),
	primary key(id_vsm),
	foreign key(dni) references socios(dni) on delete cascade
);

create table lvsmj(
	id_vsm number(20,0),
	plataforma varchar2(20),
	id_juego number(20,0),
	precio number(5,2),
	cantidad number(2),
	primary key(id_vsm, id_juego, plataforma),
	foreign key(id_vsm) references ventas_segunda_mano(id_vsm) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade,
	foreign key(plataforma) references plataformas(plataforma) on delete cascade
);

create table lvsmp(
	id_vsm number(20,0),
	calidad varchar2(20),
	id_pelicula number(20,0),
	precio number(5,2),
	cantidad number(2),
	primary key(id_vsm, id_pelicula, calidad),
	foreign key(id_vsm) references ventas_segunda_mano(id_vsm) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(calidad) references calidad_visual(calidad) on delete cascade
);

create table opiniones_juegos(
	id_opinion_juego number(20,0),
	texto varchar2(1000),
	fecha date,
	id_juego number(20,0),
	dni varchar2(9),
	primary key(id_opinion_juego),
	foreign key(id_juego) references juegos(id_juego) on delete cascade,
	foreign key(dni) references socios(dni) on delete cascade
);

create table opiniones_peliculas(
	id_opinion_pelicula number(20,0),
	texto varchar2(1000),
	fecha date,
	id_pelicula number(20,0),
	dni varchar2(9),
	primary key(id_opinion_pelicula),
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(dni) references socios(dni) on delete cascade
);

create table puntuaciones_juegos(
	dni varchar2(9),
	id_juego number(20,0),
	estrellas number(1,0),
	primary key(dni, id_juego),
	check ( regexp_like (estrellas, '^[0-5]')),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade
);

create table puntuaciones_peliculas(
	dni varchar2(9),
	id_pelicula number(20,0),
	estrellas number(1,0),
	primary key(dni, id_pelicula),
	check ( regexp_like (estrellas, '^[0-5]')),
	foreign key(dni) references socios(dni) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade
);

create table amigos(
	amigo1 varchar2(9),
	amigo2 varchar2(9),
	primary key(amigo1, amigo2),
	foreign key(amigo1) references socios(dni) on delete cascade,
	foreign key(amigo2) references socios(dni) on delete cascade
);

create table compras(
	id_compra number(20,0),
	fecha date,
	dni varchar2(9),
	primary key(id_compra),
	foreign key(dni) references socios(dni) on delete cascade
);

create table lineas_compras_juegos(
	id_juego number(20,0),
	id_compra number(20,0),
	cantidad number(3,0),
	plataforma varchar2(20),
	primary key(id_juego, id_compra, plataforma),
	foreign key(id_juego) references juegos(id_juego) on delete cascade,
	foreign key(plataforma) references plataformas(plataforma) on delete cascade,
	foreign key(id_compra) references compras(id_compra) on delete cascade
);

create table lineas_compras_peliculas(
	id_pelicula number(20,0),
	id_compra number(20,0),
	cantidad number(3,0),
	calidad varchar2(20),
	primary key(id_pelicula, id_compra, calidad),
	foreign key(calidad) references calidad_visual(calidad) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(id_compra) references compras(id_compra) on delete cascade
);

create table lineas_compras_comestibles(
	cantidad number(3,0),
	id_comestible number(20,0),
	id_compra number(20,0),
	primary key(id_compra, id_comestible),
	foreign key(id_comestible) references comestibles(id_comestible) on delete cascade,
	foreign key(id_compra) references compras(id_compra) on delete cascade
);

create table reservas_juegos(
	id_juego number(20,0),
	dni varchar2(9),
	plataforma varchar2(20),
	fecha date,
	primary key(id_juego, dni, plataforma),
	foreign key(plataforma) references plataformas(plataforma) on delete cascade,
	foreign key(id_juego) references juegos(id_juego) on delete cascade,
	foreign key(dni) references socios(dni) on delete cascade
);

create table reservas_peliculas(
	id_pelicula number(20,0),
	dni varchar2(9),
	calidad varchar2(20),
	fecha date,
	primary key(id_pelicula, dni, calidad),
	foreign key(calidad) references calidad_visual(calidad) on delete cascade,
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(dni) references socios(dni) on delete cascade
);

create table relacion_catalogos_peliculas(
	id_pelicula number(20,0),
	id_catalogo number(20,0),
	primary key(id_pelicula, id_catalogo),
	foreign key(id_pelicula) references peliculas(id_pelicula) on delete cascade,
	foreign key(id_catalogo) references catalogos(id_catalogo) on delete cascade
);

create table relacion_catalogos_juegos(
	id_juego number(20,0),
	id_catalogo number(20,0),
	primary key(id_juego, id_catalogo),
	foreign key(id_juego) references juegos(id_juego) on delete cascade,
	foreign key(id_catalogo) references catalogos(id_catalogo) on delete cascade
);

--Inserts minimos
--Generos peliculas
insert into generos_peliculas values('accion');
insert into generos_peliculas values('animacion');
insert into generos_peliculas values('aventuras');
insert into generos_peliculas values('belico');
insert into generos_peliculas values('ciencia_ficcion');
insert into generos_peliculas values('cine negro');
insert into generos_peliculas values('comedia');
insert into generos_peliculas values('desconocido');
insert into generos_peliculas values('documental');
insert into generos_peliculas values('drama');
insert into generos_peliculas values('fantastico');
insert into generos_peliculas values('infantil');
insert into generos_peliculas values('intriga');
insert into generos_peliculas values('musical');
insert into generos_peliculas values('romance');
insert into generos_peliculas values('series_de_tv');
insert into generos_peliculas values('terror');
insert into generos_peliculas values('thriller');
insert into generos_peliculas values('western');
--Generos juegos
insert into generos_juegos values('agilidad_mental');
insert into generos_juegos values('arcade');
insert into generos_juegos values('aventuras');
insert into generos_juegos values('carreras');
insert into generos_juegos values('construccion');
insert into generos_juegos values('deportes');
insert into generos_juegos values('disparos');
insert into generos_juegos values('educacion');
insert into generos_juegos values('lucha');
insert into generos_juegos values('musica');
insert into generos_juegos values('primera_persona');
insert into generos_juegos values('rol');
insert into generos_juegos values('sigilo');
insert into generos_juegos values('simulacion');
insert into generos_juegos values('tercera_persona');
--Plataformas
insert into plataformas values('android');
insert into plataformas values('pc');
insert into plataformas values('playstation');
insert into plataformas values('ps2');
insert into plataformas values('ps3');
insert into plataformas values('ps4');
insert into plataformas values('xbox');
insert into plataformas values('xbox-360');
insert into plataformas values('xbox-one');
insert into plataformas values('wii-u');
insert into plataformas values('psv');
insert into plataformas values('nintendo-3ds');
insert into plataformas values('ios');
insert into plataformas values('psp');
insert into plataformas values('wii');
insert into plataformas values('game boy');
insert into plataformas values('gamecube');
insert into plataformas values('nintendo-ds');
insert into plataformas values('dreamcast');
insert into plataformas values('nintendo-64');
--Calidad visual
insert into calidad_visual values('CD');
insert into calidad_visual values('DVD');
insert into calidad_visual values('HD-DVD');
insert into calidad_visual values('Blu-ray');
--Creacion de secuencias
create sequence id_alquiler
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_comestible
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_compra
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_devolucion
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_juego
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_catalogo
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_laj
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_lap
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_lcp
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_ldj
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_ldp
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_ljp
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_lpp
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_oferta
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_opinion_juego
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_opinion_pelicula
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_pelicula
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_proveedor
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_vp
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

create sequence id_vsm
	minvalue 0
	maxvalue 999999999999999999
	increment by 1;

--Funciones.
--Funcion que te da el nombre de un dni
create or replace function dni_a_nombre
	(identificador socios.dni%TYPE)
	return varchar2
is
	res socios.nombre%TYPE;
begin
	select nombre into res from socios where dni = identificador;
	return res;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No esta registrado');
end;
/
--Funcion que recibe el id de un comestible y te devuelve la cantidad disponible
create or replace function cantidad_comestible
	(identificador comestibles.id_comestible%TYPE)
	return number
is
	aux1 comestibles.cantidad%TYPE;
begin
	select cantidad into aux1 from comestibles where id_comestible=identificador;
	return aux1;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No tenemos ese producto');
end;
/
--Funcion que te devuelve la cantidad de alquiler disponibles de un juego
create or replace function cantidad_alquiler_juego
	(identificador juegos.id_juego%TYPE, pla plataformas.plataforma%TYPE)
	return number
is
	aux1 relacion_juegos_plataforma.alquiler%TYPE;
begin
	select alquiler into aux1 from relacion_juegos_plataforma where id_juego = identificador and plataforma = pla;
	return aux1;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No disponemos de ese articulo');
end;
/

--Funcion que te devuelve la cantidad de compras disponibles de un juego
create or replace function cantidad_compra_juego
	(identificador juegos.id_juego%TYPE, plat plataformas.plataforma%TYPE)
	return number
is
	aux1 relacion_juegos_plataforma.cantidad%TYPE;
begin
	select cantidad into aux1 from relacion_juegos_plataforma where id_juego = identificador and plataforma=plat;
	return aux1;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No disponemos de ese articulo');
end;
/

--Funcion que te devuelve la cantidad de alquiler disponible de una pelicula
create or replace function cantidad_alquiler_pelicula
	(identificador peliculas.id_pelicula%TYPE, cal calidad_visual.calidad%TYPE)
	return number
is
	aux1 relacion_peliculas_calidad.alquiler%TYPE;
begin
	select alquiler into aux1 from relacion_peliculas_calidad where id_pelicula = identificador and calidad=cal;
	return aux1;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No disponemos de ese articulo');
end;
/

--Funcion que te devuelve la cantidad de compras disponibles de una pelicula
create or replace function cantidad_compra_pelicula
	(identificador peliculas.id_pelicula%TYPE, cal calidad_visual.calidad%TYPE)
	return number
is
	aux1 relacion_peliculas_calidad.cantidad%TYPE;
begin
	select cantidad into aux1 from relacion_peliculas_calidad where id_pelicula = identificador and calidad=cal;
	return aux1;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No disponemos de ese articulo');
end;
/

--Funcion que dice el numero de articulos que le queda por devolver a un socios
create or replace function articulos_para_devolver
	(socio socios.dni%TYPE)
	return number
is
	res1 number(2);
	res2 number(2);
begin
	select nvl(
		(select nvl(sum(cantidad),0) from lineas_alquileres_juegos 
			where id_alquiler in 
				( select id_alquiler from alquileres where dni=socio) 
			group by id_alquiler),
	 0) into res1 from dual;

	select nvl(
		(select nvl(sum(cantidad),0) from lineas_alquileres_peliculas 
			where id_alquiler in 
				( select id_alquiler from alquileres where dni=socio) 
			group by id_alquiler),
	 0) into res2 from dual;
	return res1 + res2;
end;
/

--Funciion que al pasarle el id_alquiler te dice la cantidad de articulos que se han alquilados
create or replace function cantidad_articulos_alquilados
	(identificador alquileres.id_alquiler%TYPE)
	return number
is
	res1 number(2,0);
	res2 number(2,0);
begin
	select nvl((select nvl(sum(cantidad),0) from lineas_alquileres_juegos where id_alquiler = identificador),0) into res1 from dual;
	select nvl((select nvl(sum(cantidad),0) from lineas_alquileres_peliculas where id_alquiler = identificador),0) into res2 from dual;
	return res1+res2;
end;
/

--Funcion que le das el id_juego y te devuelve el nombre
create or replace function id_juego_a_nombre
	(identificador juegos.id_juego%TYPE)
	return varchar2
is
	res juegos.nombre%TYPE;
begin
	select nombre into res from juegos where id_juego = identificador;
	return res;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No disponemos de ese articulo');
end;
/

--Funcion que le das el id_pelicula y te devuelve el nombre
create or replace function id_pelicula_a_nombre
	(identificador peliculas.id_pelicula%TYPE)
	return varchar2
is
	res peliculas.nombre%TYPE;
begin
	select nombre into res from peliculas where id_pelicula = identificador;
	return res;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No disponemos de ese articulo');
end;
/
--Funcion que le das el id_pelicula y te devuelve la puntuacion media
create or replace function id_pelicula_a_puntuacion
	(identificador peliculas.id_pelicula%TYPE)
	return varchar2
is
	res varchar2(4);
begin
  select nvl(to_char(avg(estrellas)),'-') into res from puntuaciones_peliculas 
    where id_pelicula = identificador;
  return res;
end;
/
--Funcion que le das el id_juego y te devuelve la puntuacion media
create or replace function id_juego_a_puntuacion
	(identificador juegos.id_juego%TYPE)
	return varchar2
is
	res varchar2(4);
begin
  select nvl(to_char(avg(estrellas)),'-') into res from puntuaciones_juegos 
    where id_juego = identificador;
  return res;
end;
/
--Funcion que le das el id_juego y te devuelve cuantas veces se ha alquilado
create or replace function id_juego_a_alquileres
	(identificador juegos.id_juego%TYPE)
	return varchar2
is
	res1 number(7);
	res2 number(7);
begin
	select nvl(count(cantidad),0) into res1 from lineas_alquileres_juegos where id_juego = identificador;
	select nvl(count(cantidad),0) into res2 from lineas_devoluciones_juegos where id_juego = identificador;
	return res1+res2;
end;
/
--Funcion que le das el id_pelicula y te devuelve cuantas veces se ha alquilado
create or replace function id_pelicula_a_alquileres
	(identificador peliculas.id_pelicula%TYPE)
	return varchar2
is
	res1 number(7);
	res2 number(7);
begin
	select nvl(count(cantidad),0) into res1 from lineas_alquileres_peliculas where id_pelicula = identificador;
	select nvl(count(cantidad),0) into res2 from lineas_devoluciones_peliculas where id_pelicula = identificador;
	return res1+res2;
end;
/

--Procedimientos
-- Para que se pueda imprimir por pantalla: set serveroutput on
--Este procedimiento elimina las reserva que se hiciero hace mas de dos horas. Tenemos que hacer que el sistema operativo lo ejecute cada cierto tiempo.
create or replace procedure actualizar_reservas
is
begin
	delete from reservas_juegos where fecha<sysdate-120/1440;
	delete from reservas_peliculas where fecha<sysdate-120/1440;
end;
/

--Procedimiento que elimina las reservas de un socio.
create or replace procedure quitar_reservas_socio
	(socio socios.dni%TYPE)
is
begin
	delete from reservas_juegos where dni=socio;
	delete from reservas_peliculas where dni=socio;
end;
/

--Procedimiento que te muestra por pantalla el id_proveedor y el dinero que hemos invertido en el
create or replace procedure mostrar_gastos_por_proveedor
is
	cursor c_datos1 is select id_proveedor as id, sum(precio*cantidad) as suma from ventas_proveedores v, lineas_juegos_proveedores l 
		where v.id_vp=l.id_vp group by id_proveedor;
	cursor c_datos2 is select id_proveedor as id, sum(precio*cantidad) as suma from ventas_proveedores v, lineas_peliculas_proveedores l 
		where v.id_vp=l.id_vp group by id_proveedor;
	cursor c_datos3 is select id_proveedor as id, sum(precio*cantidad) as suma from ventas_proveedores v, lineas_comestibles_proveedores l 
		where v.id_vp=l.id_vp group by id_proveedor;
begin
	dbms_output.put_line('id_proveedor: '||chr(9)||'cantidad');
	for v_datos1 in c_datos1 loop
		dbms_output.put_line(v_datos1.id||': '||chr(9)||chr(9)|| v_datos1.suma);
	end loop;
	for v_datos2 in c_datos2 loop
		dbms_output.put_line(v_datos2.id||': '||chr(9)||chr(9)|| v_datos2.suma);
	end loop;
	for v_datos3 in c_datos3 loop
		dbms_output.put_line(v_datos3.id||': '||chr(9)||chr(9)|| v_datos3.suma);
	end loop;
end;
/

--Procedimiento al que le pasas un genero de peliculas y te imprime por pantalla el nombre de los articulos que pertenecen a ese genero
create or replace procedure peliculas_por_genero
	(gene generos_peliculas.genero%TYPE)
is
	cursor c_datos is 
		select nombre as id from peliculas where 
			id_pelicula in (select id_pelicula from relacion_peliculas_genero where genero=gene);
begin
	for v_datos in c_datos loop
		dbms_output.put_line(v_datos.id);
	end loop;	
end;
/

--Procedimiento al que le pasas un genero de videojuego y te imprime por pantalla el nombre de los articulos que pertenecen a ese genero
create or replace procedure juegos_por_genero
	(gene generos_juegos.genero%TYPE)
is
	cursor c_datos is 
		select nombre as id from juegos where 
			id_juego in (select id_juego from relacion_juegos_genero where genero=gene);
begin
	for v_datos in c_datos loop
		dbms_output.put_line(v_datos.id);
	end loop;	
end;
/


--Triggers
--Evitar que se compren mas comestibles de los que disponemos y actualizar los comestibles tras una compra
create or replace trigger lineas_compras_comestibles
	before insert or update or delete on lineas_compras_comestibles for each row
begin
if inserting then
	if :new.cantidad > cantidad_comestible(:new.id_comestible) then
		raise_application_error (-20600,
		'no se pueden comprar mas comestibles de los disponibles');
	else
		update comestibles set cantidad = cantidad-:new.cantidad where id_comestible=:new.id_comestible;
	end if;
elsif updating then
	if :new.cantidad - :old.cantidad > cantidad_comestible(:new.id_comestible) then
		raise_application_error (-20600,
		'no se pueden comprar mas comestibles de los disponibles');
	else
		update comestibles set cantidad = cantidad-:new.cantidad + :old.cantidad where id_comestible=:new.id_comestible;
	end if;	
elsif deleting then
	update comestibles set cantidad = cantidad+:old.cantidad where id_comestible=:old.id_comestible;
end if;
end;
/

--Evitar que se compren peliculas de alquiler, evitar que se puedan comprar mas peliculas de los disponibles y actualizar los articulos tras una compra
create or replace trigger lineas_compras_peliculas
	before insert or update or delete on lineas_compras_peliculas for each row
begin
if inserting then
	if :new.cantidad > cantidad_compra_pelicula(:new.id_pelicula, :new.calidad) then
		raise_application_error (-20600,
		'no se pueden comprar mas articulos de los disponibles');
	end if;
	update relacion_peliculas_calidad set cantidad = cantidad-:new.cantidad where id_pelicula=:new.id_pelicula and calidad=:new.calidad;
elsif updating then
	if :old.id_pelicula!=:new.id_pelicula then
		raise_application_error (-20600,
		'No puedes cambiar el articulo');
	end if;
	if :new.cantidad-:old.cantidad > cantidad_compra_pelicula(:new.id_pelicula, :new.calidad) then
		raise_application_error (-20600,
		'no se pueden comprar mas articulos de los disponibles');
	end if;
	update relacion_peliculas_calidad set cantidad = cantidad-:new.cantidad+:old.cantidad where id_pelicula=:new.id_pelicula and calidad=:new.calidad;
elsif deleting then
	update relacion_peliculas_calidad set cantidad = cantidad+:old.cantidad where id_pelicula=:old.id_pelicula and calidad=:new.calidad;
end if;
end;
/

--Evitar que se compren articulos de alquiler, evitar que se puedan comprar mas articulos de los disponibles y actualizar los articulos tras una compra
create or replace trigger lineas_compras_juegos
	before insert or update or delete on lineas_compras_juegos for each row
begin
if inserting then
	if :new.cantidad > cantidad_compra_juego(:new.id_juego, :new.plataforma) then
		raise_application_error (-20600,
		'no se pueden comprar mas articulos de los disponibles');
	end if;
	update relacion_juegos_plataforma set cantidad = cantidad-:new.cantidad where id_juego=:new.id_juego and plataforma=:new.plataforma;
elsif updating then
	if :old.id_juego!=:new.id_juego then
		raise_application_error (-20600,
		'No puedes cambiar el articulo');
	end if;
	if :new.cantidad-:old.cantidad > cantidad_compra_juego(:new.id_juego, :new.plataforma) then
		raise_application_error (-20600,
		'no se pueden comprar mas articulos de los disponibles');
	end if;
	update relacion_juegos_plataforma set cantidad = cantidad-:new.cantidad+:old.cantidad where id_juego=:new.id_juego and plataforma=:new.plataforma;
elsif deleting then
	update relacion_juegos_plataforma set cantidad = cantidad+:old.cantidad where id_juego=:old.id_juego and plataforma=:new.plataforma;
end if;
end;
/

--No permitir hacer un alquiler mientras no se devuelva los articulos pendientes, al realizar un alquiler, quita las reservas
create or replace trigger alquileres
	before insert on alquileres for each row
begin
	if  articulos_para_devolver(:new.dni)> 0 then
		raise_application_error
		(-20600,
		'Tienes que devolver todos los articulos antes de poder hacer otro alquiler');
	end if;
	quitar_reservas_socio(:new.dni);
end;
/

--Si se inserta lineas de alquiler: evita alquilar articulos de compras, evita que se alquilen mas articulos de los disponibles, evita que se alquilen mas de 10 articulos y si la linea es correcta descuenta a los articulos la cantidad correspondiente.
--Si se eliminan linas de alquiler: se le suma la cantidad correspondiente a los articulos.
--Si se modifican: evita que se modifiquen los id de los articulos y si la cantidad es diferente, se actualiza la cantidad del articulo
create or replace trigger lineas_alquiler_juegos
	before insert or delete or update on lineas_alquileres_juegos for each row
declare
	socio socios.dni%TYPE;
	edad socios.nacido%TYPE;
	restriccion juegos.edad_restrictiva%TYPE;
	w_cantidad integer;
begin
	if inserting then
		select dni into socio from alquileres where id_alquiler=:new.id_alquiler;
		select nacido into edad from socios where dni=socio;
		select edad_restrictiva into restriccion from juegos where id_juego=:new.id_juego;
		if edad+365*restriccion > current_date then
			raise_application_error
			(-20600,
			'no tienes edad suficiente para este articulo');	
		end if;
		if :new.cantidad > cantidad_alquiler_juego(:new.id_juego, :new.plataforma) then
			raise_application_error
			(-20600,
			'No tenemos tanta cantidad de ese articulo');	
		end if;
		if cantidad_articulos_alquilados(:new.id_alquiler)+:new.cantidad >10 then
			raise_application_error
			(-20600,
			'No se pueden alquilar mas de 10 articulos');
		end if;
		update relacion_juegos_plataforma set alquiler = alquiler-:new.cantidad where id_juego=:new.id_juego and plataforma=:new.plataforma;
	end if;
	if deleting then
		update relacion_juegos_plataforma set alquiler = alquiler+:old.cantidad where id_juego=:old.id_juego and plataforma=:new.plataforma;
	end if;
	if updating then
		select dni into socio from alquileres where id_alquiler=:old.id_alquiler;
		select nacido into edad from socios where dni=socio;
		select edad_restrictiva into restriccion from juegos where id_juego=:old.id_juego;
		if :old.id_juego!=:new.id_juego then
			raise_application_error
			(-20600,
			'No se puede modificar el articulo de una linea de alquiler');
		end if;
		if :new.cantidad-:old.cantidad > cantidad_alquiler_juego(:new.id_juego, :new.plataforma) then
			raise_application_error
			(-20600,
			'No tenemos tanta cantidad de ese articulo');	
		end if;
		if :old.cantidad!=:new.cantidad then
			update relacion_juegos_plataforma set alquiler = alquiler - :new.cantidad + :old.cantidad where id_juego=:new.id_juego and plataforma=:new.plataforma;
		end if;
	end if;
end;
/

--Si se inserta lineas de alquiler: evita alquilar articulos de compras, evita que se alquilen mas articulos de los disponibles, evita que se alquilen mas de 10 articulos y si la linea es correcta descuenta a los articulos la cantidad correspondiente.
--Si se eliminan linas de alquiler: se le suma la cantidad correspondiente a los articulos.
--Si se modifican: evita que se modifiquen los id de los articulos y si la cantidad es diferente, se actualiza la cantidad del articulo
create or replace trigger lineas_alquiler_peliculas
	before insert or delete or update on lineas_alquileres_peliculas for each row
declare
	socio socios.dni%TYPE;
	edad socios.nacido%TYPE;
	restriccion peliculas.edad_restrictiva%TYPE;
	w_cantidad integer;
begin
	if inserting then
		select dni into socio from alquileres where id_alquiler=:new.id_alquiler;
		select nacido into edad from socios where dni=socio;
		select edad_restrictiva into restriccion from peliculas where id_pelicula=:new.id_pelicula;
		if edad+365*restriccion > current_date then
			raise_application_error
			(-20600,
			'no tienes edad suficiente para este articulo');	
		end if;
		if :new.cantidad > cantidad_alquiler_pelicula(:new.id_pelicula, :new.calidad) then
			raise_application_error
			(-20600,
			'No tenemos tanta cantidad de ese articulo');	
		end if;
		if cantidad_articulos_alquilados(:new.id_alquiler)+:new.cantidad >10 then
			raise_application_error
			(-20600,
			'No se pueden alquilar mas de 10 articulos');
		end if;
		update relacion_peliculas_calidad set alquiler = alquiler-:new.cantidad where id_pelicula=:new.id_pelicula and calidad=:new.calidad;
	end if;
	if deleting then
		update relacion_peliculas_calidad set alquiler = alquiler+:old.cantidad where id_pelicula=:old.id_pelicula and calidad=:new.calidad;
	end if;
	if updating then
		select dni into socio from alquileres where id_alquiler=:old.id_alquiler;
		select nacido into edad from socios where dni=socio;
		select edad_restrictiva into restriccion from peliculas where id_pelicula=:old.id_pelicula;
		if :old.id_pelicula!=:new.id_pelicula then
			raise_application_error
			(-20600,
			'No se puede modificar el articulo de una linea de alquiler');
		end if;
		if :new.cantidad-:old.cantidad > cantidad_alquiler_pelicula(:new.id_pelicula, :new.calidad) then
			raise_application_error
			(-20600,
			'No tenemos tanta cantidad de ese articulo');	
		end if;
		if :old.cantidad!=:new.cantidad then
			update relacion_peliculas_calidad set alquiler = alquiler - :new.cantidad + :old.cantidad where id_pelicula=:new.id_pelicula and calidad=:new.calidad;
		end if;
	end if;
end;
/

--Elimina las lineas de alquileres correspondientes con las devoluciones, aumenta los articulos devueltos
create or replace trigger lineas_devoluciones_juegos
	before insert or update on lineas_devoluciones_juegos for each row
declare
	aux1 lineas_alquileres_juegos.cantidad%TYPE;
	aux2 lineas_alquileres_juegos.id_laj%TYPE;
begin
if inserting then
	select cantidad, id_laj into aux1, aux2 from lineas_alquileres_juegos where
		 id_alquiler=(select id_alquiler from devoluciones where id_devolucion=:new.id_devolucion) 
		and id_juego=:new.id_juego and plataforma=:new.plataforma;

	if :new.cantidad = aux1 then
		delete from lineas_alquileres_juegos where id_laj=aux2;
	elsif :new.cantidad < aux1 then
		update lineas_alquileres_juegos set cantidad = cantidad - :new.cantidad where id_laj=aux2;	
	else
		raise_application_error
		(-20600,
		'No se pueden devolver articulos que no has alquilado');
	end if;
	if :new.defectuoso = 1 then
		update relacion_juegos_plataforma set alquiler = alquiler - :new.cantidad where id_juego=:new.id_juego and plataforma=:new.plataforma;
	end if;
elsif updating then
	raise_application_error(-20600,
		'No se puede modificar una linea de devolucion');
end if;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No se pueden devolver articulos que no has alquilado');
end;
/

--Elimina las lineas de alquileres correspondientes con las devoluciones, aumenta los articulos devueltos
create or replace trigger lineas_devoluciones_peliculas
	before insert or update on lineas_devoluciones_peliculas for each row
declare
	aux1 lineas_alquileres_peliculas.cantidad%TYPE;
	aux2 lineas_alquileres_peliculas.id_lap%TYPE;
begin
if inserting then
	select cantidad, id_lap into aux1, aux2 from lineas_alquileres_peliculas where
		 id_alquiler=(select id_alquiler from devoluciones where id_devolucion=:new.id_devolucion) 
		and id_pelicula=:new.id_pelicula and calidad=:new.calidad;

	if :new.cantidad = aux1 then
		delete from lineas_alquileres_peliculas where id_lap=aux2;
	elsif :new.cantidad < aux1 then
		update lineas_alquileres_peliculas set cantidad = cantidad - :new.cantidad where id_lap=aux2;	
	else
		raise_application_error
		(-20600,
		'No se pueden devolver articulos que no has alquilado');
	end if;
	if :new.defectuoso = 1 then
		update relacion_peliculas_calidad set alquiler = alquiler - :new.cantidad where id_pelicula=:new.id_pelicula and calidad=:new.calidad;
	end if;
elsif updating then
	raise_application_error(-20600,
		'No se puede modificar una linea de devolucion');
end if;
exception
	when no_data_found then
		raise_application_error
		(-20600,
		'No se pueden devolver articulos que no has alquilado');
end;
/

--Actualiza los articulos tras comprar un articulo a un socio y nos evita comprar articulos por un precio mayor del de ventas.
create or replace trigger ventas_segunda_mano_juegos
	before insert on lvsmj for each row
declare
	aux1 relacion_juegos_plataforma.precio%TYPE;
begin
if inserting then
	select precio into aux1 from relacion_juegos_plataforma where id_juego = :new.id_juego and plataforma = :new.plataforma;
	if :new.precio > aux1 + 5 then
		raise_application_error
		(-20600,
		'Es demasiado caro para comprarlo');
	end if;
	update relacion_juegos_plataforma set cantidad = cantidad + :new.cantidad where id_juego = :new.id_juego and plataforma = :new.plataforma;
elsif updating then
	if :new.id_juego != :old.id_juego or :new.plataforma != :old.plataforma then
		raise_application_error
		(-20600,
		'No se puede cambiar el juego');
	end if;
	select precio into aux1 from relacion_juegos_plataforma where id_juego = :new.id_juego and plataforma = :new.plataforma;
	if :new.precio > aux1 + 5 then
		raise_application_error
		(-20600,
		'Es demasiado caro para comprarlo');
	end if;
	update relacion_juegos_plataforma set cantidad = cantidad + :new.cantidad - :old.cantidad where id_juego = :new.id_juego and plataforma = :new.plataforma;
elsif deleting then
	update relacion_juegos_plataforma set cantidad = cantidad - :old.cantidad where id_juego = :old.id_juego and plataforma = :old.plataforma;
end if;
exception
	when no_data_found then
		aux1:=0;
end;
/

--Actualiza los articulos tras comprar un articulo a un socio y nos evita comprar articulos por un precio mayor del de ventas.
create or replace trigger ventas_segunda_mano_peliculas
	before insert on lvsmp for each row
declare
	aux1 relacion_peliculas_calidad.precio%TYPE;
begin
if inserting then
	select precio into aux1 from relacion_peliculas_calidad where id_pelicula = :new.id_pelicula and calidad = :new.calidad;
	if :new.precio > aux1 + 5 then
		raise_application_error
		(-20600,
		'Es demasiado caro para comprarlo');
	end if;
	update relacion_peliculas_calidad set cantidad = cantidad + :new.cantidad where id_pelicula = :new.id_pelicula and calidad = :new.calidad;
elsif updating then
	if :new.id_pelicula != :old.id_pelicula or :new.calidad != :old.calidad then
		raise_application_error
		(-20600,
		'No se puede cambiar la pelicula');
	end if;
	select precio into aux1 from relacion_peliculas_calidad where id_pelicula = :new.id_pelicula and calidad = :new.calidad;
	if :new.precio > aux1 + 5 then
		raise_application_error
		(-20600,
		'Es demasiado caro para comprarlo');
	end if;
	update relacion_peliculas_calidad set cantidad = cantidad + :new.cantidad - :old.cantidad where id_pelicula = :new.id_pelicula and calidad = :new.calidad;
elsif deleting then
	update relacion_peliculas_calidad set cantidad = cantidad - :old.cantidad where id_pelicula = :old.id_pelicula and calidad = :old.calidad;
end if;
exception
	when no_data_found then
		aux1:=0;
end;
/

--Descontar articulos cuando son reservados, evitar reservas si tiene peliculas pendientes de devolución o si no esta disponible.
create or replace trigger reservas_juegos
	before insert or update or delete on reservas_juegos for each row
begin
	if inserting then
		if articulos_para_devolver(:new.dni)>0 then
			raise_application_error
			(-20600,
			'Para poder hacer una reserva debe devolver la peliculas alquiladas');
		end if;
		if cantidad_alquiler_juego(:new.id_juego, :new.plataforma)<1 then
			raise_application_error
			(-20600,
			'Actualmente no tenemos disponible ese articulo');
		end if;
		update relacion_juegos_plataforma set alquiler = alquiler - 1 where id_juego = :new.id_juego and plataforma=:new.plataforma;
	elsif deleting then
		update relacion_juegos_plataforma set alquiler = alquiler + 1 where id_juego = :old.id_juego and plataforma=:old.plataforma;
	elsif updating then
		if :old.id_juego != :new.id_juego then
			update relacion_juegos_plataforma set alquiler = alquiler - 1 where id_juego = :new.id_juego and plataforma=:new.plataforma;
			update relacion_juegos_plataforma set alquiler = alquiler + 1 where id_juego = :old.id_juego and plataforma=:new.plataforma;
		end if;
	end if;
end;
/

--Descontar articulos cuando son reservados, evitar reservas si tiene peliculas pendientes de devolución o si no esta disponible.
create or replace trigger reservas_peliculas
	before insert or update or delete on reservas_peliculas for each row
begin
	if inserting then
		if articulos_para_devolver(:new.dni)>0 then
			raise_application_error
			(-20600,
			'Para poder hacer una reserva debe devolver la peliculas alquiladas');
		end if;
		if cantidad_alquiler_pelicula(:new.id_pelicula, :new.calidad)<1 then
			raise_application_error
			(-20600,
			'Actualmente no tenemos disponible ese articulo');
		end if;
		update relacion_peliculas_calidad set alquiler = alquiler - 1 where id_pelicula = :new.id_pelicula and calidad=:new.calidad;
	elsif deleting then
		update relacion_peliculas_calidad set alquiler = alquiler + 1 where id_pelicula = :old.id_pelicula and calidad=:old.calidad;
	elsif updating then
		if :old.id_pelicula != :new.id_pelicula then
			update relacion_peliculas_calidad set alquiler = alquiler - 1 where id_pelicula = :new.id_pelicula and calidad=:new.calidad;
			update relacion_peliculas_calidad set alquiler = alquiler + 1 where id_pelicula = :old.id_pelicula and calidad=:new.calidad;
		end if;
	end if;
end;
/

--Cuando realizamos una compra a un proveedor de comestibles, actaliza los comestibles
create or replace trigger actualizar_lcp
	before insert on lineas_comestibles_proveedores for each row
begin
	update comestibles set cantidad = cantidad + :new.cantidad where id_comestible = :new.id_comestible;
end;
/

--Cuando realizamos una compra a un proveedor de articulos, actualiza los articulos
create or replace trigger actualizar_ljp
	before insert on lineas_juegos_proveedores for each row
begin
	update relacion_juegos_plataforma set alquiler = alquiler + :new.cantidad where id_juego = :new.id_juego and plataforma=:new.plataforma;
end;
/

--Cuando realizamos una compra a un proveedor de articulos, actualiza los articulos
create or replace trigger actualizar_lpp
	before insert on lineas_peliculas_proveedores for each row
begin
	update relacion_peliculas_calidad set alquiler = alquiler + :new.cantidad where id_pelicula = :new.id_pelicula and calidad=:new.calidad;
end;
/
