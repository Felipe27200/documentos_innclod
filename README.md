# +----------------------+
# | INSTRUCCIONES DE USO |
# +----------------------+

Proyecto contruido en PHP puro, sql, mysql y jquery.

Corre sobre el servidoR Xampp, usando la base de datos, 
  se puede establecer el host en conexión.php para que esta apunte correctamente, 
  así mismo se puede definir el usuario y la contraseña de la base de datos.

Se corre con los siguientes link (Esto desde mi equipo o desde el host localhost):
  - http://localhost/registro_docs/views/sesion.php
  - http://localhost/registro_docs/views/documento/documento-view.php
  - http://localhost/registro_docs/views/tipo-docs/tipodocs-view.php
  - http://localhost/registro_docs/views/procesos/proceso-view.php

Dentro del aplicativo exiten anchor elements para redireccionar a cada una de ellas.

# Usuario y Contraseña
  
  USUARIO =>    usuario1
  CONTRASEÑA => usuario123
  
# Especificaciones del sistema

  - Gestor Base de Datos => MySQL
  - PHP version: 8.2.0
  - jQuery v3.6.3
  - DataTables 1.13.3
  - Bootstrap v5.1.3
  
# Creación Base de Datos

/*
 +--------------------------------------+
 | ESTRUCTURA DE LA BASE DE DATOS (DDL) |
 +--------------------------------------+
*/

-- CREAR LA BASE DE DATOS
CREATE DATABASE registro_docs;
USE registro_docs;

-- TABLA PRO_PROCESO

CREATE TABLE `pro_proceso` (
  `pro_id` int(11) NOT NULL,
  `pro_prefijo` varchar(20) NOT NULL,
  `pro_nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ESTABLECER PRIMARY KEY PARA TABLA PRO_PROCESO
-- ESTABLECER UNIQUE INDEX PARA TABLA PRO_PROCESO
ALTER TABLE `pro_proceso`
  ADD PRIMARY KEY (`pro_id`),
  ADD UNIQUE KEY `pro_nombre` (`pro_nombre`),
  ADD UNIQUE KEY `pro_prefijo` (`pro_prefijo`);

--
-- AUTO_INCREMENT for table `pro_proceso`
--
ALTER TABLE `pro_proceso`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


-- TABLA TIP_TIPO_DOC

CREATE TABLE `tip_tipo_doc` (
  `tip_id` int(11) NOT NULL,
  `tip_nombre` varchar(60) NOT NULL,
  `tip_prefijo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for table `tip_tipo_doc`
--
ALTER TABLE `tip_tipo_doc`
  ADD PRIMARY KEY (`tip_id`),
  ADD UNIQUE KEY `tip_nombre` (`tip_nombre`),
  ADD UNIQUE KEY `tip_prefijo` (`tip_prefijo`);

--
-- AUTO_INCREMENT for table `tip_tipo_doc`
--
ALTER TABLE `tip_tipo_doc`
  MODIFY `tip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


-- TABLA DOC_DOCUMENTO 

CREATE TABLE `doc_documento` (
  `doc_id` int(11) NOT NULL,
  `doc_nombre` varchar(60) NOT NULL,
  `doc_codigo` int(11) NOT NULL,
  `doc_contenido` text NOT NULL,
  `doc_id_tipo` int(11) NOT NULL,
  `doc_id_proceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for table `doc_documento`
--
ALTER TABLE `doc_documento`
  ADD PRIMARY KEY (`doc_id`),
  ADD UNIQUE KEY `codigo` (`doc_codigo`,`doc_id_tipo`,`doc_id_proceso`);

--
-- AUTO_INCREMENT for table `doc_documento`
--
ALTER TABLE `doc_documento`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for table `doc_documento`
--
ALTER TABLE `doc_documento`
  ADD CONSTRAINT `doc_documento_ibfk_1` FOREIGN KEY (`doc_id_tipo`) REFERENCES `tip_tipo_doc` (`tip_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `doc_documento_ibfk_2` FOREIGN KEY (`doc_id_proceso`) REFERENCES `pro_proceso` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

-- --------------------------------------------------------

/*
  +-----------------------+
  | DML -> INSERTAR DATOS |
  +-----------------------+

  Datos precargados
*/

INSERT INTO `tip_tipo_doc` (`tip_id`, `tip_nombre`, `tip_prefijo`) VALUES
(1, 'Instructivo', 'INS'),
(2, 'Manual Usuario', 'MANU'),
(3, 'Gestión', 'GES'),
(4, 'Informe', 'INF'),
(5, 'Normatividad', 'NOR');

INSERT INTO `pro_proceso` (`pro_id`, `pro_prefijo`, `pro_nombre`) VALUES
(1, 'ING', 'Ingeniería'),
(2, 'ABD', 'Administración BD'),
(3, 'RH', 'Recursos Humano'),
(4, 'RED', 'Redes'),
(5, 'ASE', 'Asesoría');

INSERT INTO `doc_documento` (`doc_id`, `doc_nombre`, `doc_codigo`, `doc_contenido`, `doc_id_tipo`, `doc_id_proceso`) VALUES
(1, 'INSTRUCTIVO DE DESARROLLO', 1, 'Texto del Documento', 1, 1),
(2, 'Informe de Prueba', 2, 'Texto del documento de pruebas', 5, 1),
(3, 'Gestión del Personal', 1, 'Texto del documento', 3, 3),
(4, 'Pruebas Caja Negra', 1, 'Resultado de Pruebas', 4, 1);

