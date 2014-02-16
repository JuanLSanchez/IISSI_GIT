--Comestibles
insert into comestibles values(id_comestible.nextval, 'Risquetos', 100, 0.30);
insert into comestibles values(id_comestible.nextval, 'Papa delta', 100, 0.30);
insert into comestibles values(id_comestible.nextval, 'Chicles', 700, 0.05);
--Socios
insert into socios values('12345678C', 'Julio', '20-SEP-1980', current_date, 'C/ Arenal Nº/ 16', 'julio@hotmail.com', '654478397', '123123');
insert into socios values('11111111A', 'Maria', '12-JUL-1990', current_date, 'C/ Santiago Nº/ 8', 'maria@gmail.com', 647765432, '123123');
insert into socios values('22222222A', 'Marta', '22-JUL-2000', current_date, 'C/ Santiago Nº/ 8', 'marta@gmail.com', 647465432, '123123');
--Compras
insert into compras values(id_compra.nextval, current_date, '12345678C');
insert into compras values(id_compra.nextval, current_date, '11111111A');
insert into compras values(id_compra.nextval, current_date, '22222222A');
--Lineas compras comestibles
--select nombre, cantidad from comestibles;
insert into lineas_compras_comestibles values(1, 1, 1);
insert into lineas_compras_comestibles values(2, 2, 1);
insert into lineas_compras_comestibles values(10, 3, 2);
insert into lineas_compras_comestibles values(100, 1, 2);
--Peliculas
insert into peliculas values(id_pelicula.nextval, '2 Guns', 16, 'imagen', 'trailer', 'Un agente de la DEA (Denzel Washington) y un oficial de la Marina (Mark Wahlberg) se infiltran en redes mafiosas sin conocer uno la identidad del otro. Comedia de acción del islandés Baltasar Kormákur basada en cómics de Steven Grant.', 2);
insert into relacion_peliculas_calidad values(id_pelicula.currval, 'DVD', 20, 2);

insert into peliculas values(id_pelicula.nextval, '2 Guns', 16, 'imagen', 'trailer', 'Un agente de la DEA (Denzel Washington) y un oficial de la Marina (Mark Wahlberg) se infiltran en redes mafiosas sin conocer uno la identidad del otro. Comedia de acción del islandés Baltasar Kormákur basada en cómics de Steven Grant.', 2);

insert into peliculas values(id_pelicula.nextval, 'Avatar', 7, 'imagen', 'trailer', 'Doce años después de su hiperoscarizada Titanic vuelve James Cameron con un renovador film que fusiona la imagen real con la más avanzada animación motion-capture en 3D. Un ex marine (Sam Worgthington) es transformado en na vi, habitante del planeta Pandora, al que es envíado como espía.', 4);
insert into relacion_peliculas_calidad values(id_pelicula.currval, 'Blu-ray', 40, 2);

insert into peliculas values(id_pelicula.nextval, 'Riddick', 16, 'imagen', 'trailer', 'Llega la 3ª entrega de la serie de acción y ciencia–ficción Las crónicas de Riddick, creada y dirigida por David Twohy y protagonizada/ producida por Vin Diesel. Esta vez con Jordi Mollà en el reparto.', 3);
insert into peliculas values(id_pelicula.nextval, 'Insidious: Capítulo 2','16', 'imagen', 'trailer', 'Patrick Wilson y Rose Byrne retoman sus personajes en esta secuela del taquillero film de terror de Leigh Whannell y James Wan (saga Saw).', 10);

--Lineas compras articulos(id_pelicula, id_compra, cantidad, calidad)
insert into lineas_compras_peliculas values(2, 2, 1, 'Blu-ray');
insert into lineas_compras_peliculas values(1, 2, 1, 'DVD');
insert into lineas_compras_peliculas values(1, 3, 1, 'DVD');
insert into lineas_compras_peliculas values(1, 1, 1, 'DVD');
insert into lineas_compras_peliculas values(3, 1, 1, 'Blu-ray');
--select id_articulo, nombre, cantidad, compra from articulos;
--Alquileres
insert into alquileres values(id_alquiler.nextval, current_date, 1, '22222222A');
insert into alquileres values(id_alquiler.nextval, current_date, 1, '12345678C');
--Ofertas
insert into ofertas values(id_oferta.nextval, 'Este es el precio estandar', '20-OCT-2000', '17-OCT-2020', 0.6);
insert into ofertas values(id_oferta.nextval, 'Oferta 24h a 1€', '14-JUL-2010', '17-OCT-2020', 1.0);
--Lineas alquileres peliculas  ID_LAP, CANTIDAD, ID_OFERTA, ID_ALQUILER	, ID_PELICULA
--select nombre, cantidad from articulos;
insert into lineas_alquileres_peliculas values(id_lap.nextval, 1, 1, 1, 3);
--no tener cantidad suficiente de un articulo
insert into lineas_alquileres_peliculas values(id_lap.nextval, 4, 1, 2, 3);
--edad restrictiva
insert into lineas_alquileres_peliculas values(id_lap.nextval, 1, 1, 1, 1);
--alquileres normales
insert into lineas_alquileres_peliculas values(id_lap.nextval, 1, 2, 2, 1);
insert into lineas_alquileres_peliculas values(id_lap.nextval, 2, 2, 2, 4);
--intentar alquilar mas de 10 articulos
insert into lineas_alquileres_peliculas values(id_lap.nextval, 8, 1, 2, 5);
--Devoluciones
--aqui
insert into devoluciones values(id_devolucion.nextval, current_date, '22222222A');
insert into devoluciones values(id_devolucion.nextval, current_date, '12345678C');
--Lineas devoluciones
--id_ld, cantidad, defectuos, id_articulo, id_devolucion
--devolver articulos que no ha alquilado
insert into lineas_devoluciones values(id_ld.nextval, 2, 0, 3, 1);
--devolucion normal
insert into lineas_devoluciones values(id_ld.nextval, 1, 0, 3, 1);
insert into lineas_devoluciones values(id_ld.nextval, 1, 0, 4, 2);
--devolucion defectuosa
insert into lineas_devoluciones values(id_ld.nextval, 1, 1, 4, 2);
--Reservas
insert into reservas values(1, '11111111A', current_date);
insert into reservas values(4, '11111111A', current_date-120/1440);
--actualizar reservas
execute actualizar_reservas;
--reserva de pelicula no disponible
insert into reservas values(1, '22222222A', current_date);
--intentar reservar con peliculas alquiladas
insert into reservas values(4, '12345678C', current_date);
--Proveedores
insert into proveedores values(id_proveedor.nextval, 'Pelismovies', '674483762');
insert into proveedores values(id_proveedor.nextval, 'Chuchelandia', '673325164');
--Ventas proveedores
insert into ventas_proveedores values (id_vp.nextval, current_date, 1);
insert into ventas_proveedores values (id_vp.nextval, current_date, 2);
--Lineas de ventas proveedores
insert into lineas_ventas_proveedores values(id_lvp.nextval, 30, 1, 1);
insert into lineas_ventas_proveedores values(id_lvp.nextval, 35, 1, 1);
insert into lineas_ventas_proveedores values(id_lvp.nextval, 0.01, 60, 2);
insert into lineas_ventas_proveedores values(id_lvp.nextval, 0.15, 400, 2);
insert into lineas_ventas_proveedores values(id_lvp.nextval, 20, 4, 1);
--Articulos comprados
insert into articulos_comprados values(1,1);
insert into articulos_comprados values(2,3);
insert into articulos_comprados values(5,4);
--Relacion comestibles lvp
insert into relacion_comestibles_lvp values(3, 2);
insert into relacion_comestibles_lvp values(4, 3);
--Peliculas
insert into peliculas values(id_pelicula.nextval,1);
insert into peliculas values(id_pelicula.nextval,2);
insert into peliculas values(id_pelicula.nextval,3);
insert into peliculas values(id_pelicula.nextval,4);
insert into peliculas values(id_pelicula.nextval,5);
--Relación peliculas generos
insert into relacion_peliculas_genero values(1, 'accion');
insert into relacion_peliculas_genero values(1, 'thriller');
insert into relacion_peliculas_genero values(1, 'comedia');
insert into relacion_peliculas_genero values(2, 'accion');
insert into relacion_peliculas_genero values(2, 'thriller');
insert into relacion_peliculas_genero values(2, 'comedia');
insert into relacion_peliculas_genero values(3, 'accion');
insert into relacion_peliculas_genero values(3, 'aventuras');
insert into relacion_peliculas_genero values(3, 'ciencia ficcion');
insert into relacion_peliculas_genero values(3, 'belico');
insert into relacion_peliculas_genero values(3, 'fantastico');
insert into relacion_peliculas_genero values(3, 'romance');
insert into relacion_peliculas_genero values(4, 'accion');
insert into relacion_peliculas_genero values(4, 'ciencia ficcion');
insert into relacion_peliculas_genero values(5, 'terror');
--select nombre from articulos where id_articulo in (select id_articulo from peliculas where id_pelicula in (select id_pelicula from relacion_peliculas_genero where genero='terror'));
--Opiniones
insert into opiniones values(id_opinion.nextval, 'Una película oscura y sangrienta de género que ofrece monstruos, cuchillos y un poco de gore saludable.', current_date, 4, '11111111A');
insert into opiniones values(id_opinion.nextval, 'Una secuela improbable pero muy entretenida que recupera gran parte de la intensidad de Diesel y del director David Twohy de la franquicia "Pitch Black',current_date, 4, '12345678C');
insert into opiniones values(id_opinion.nextval, 'El rey del mundo ha fijado su visión en crear otro nuevo mundo en "Avatar", y es un lugar que merece mucho la pena visitar. Entrega un espectáculo único, paisajes asombrosos, una narración excitante y un mensaje antiimperalista, de vuelta a la naturaleza',current_date, 3, '11111111A');
insert into opiniones values(id_opinion.nextval, 'Kormakur demuestra que conoce bien el mecanismo de las películas de acción mejor que la mayoría, manteniendo un ritmo rápido, unas bromas animadas y las emociones al estilo de la vieja escuela, la mayoría libres de retoques digitales',current_date, 1, '11111111A');
insert into opiniones values(id_opinion.nextval, 'El Sr. Kormakur ajusta y mantiene un ritmo rápido más que frenético, que nunca saca a la película de sus carriles, incluso cuando la historia casi lo hace',current_date, 1, '12345678C');
insert into opiniones values(id_opinion.nextval, 'Un divertimento tan sólido en su producción como en su contagio del buen rollo',current_date, 1, '11111111A');

