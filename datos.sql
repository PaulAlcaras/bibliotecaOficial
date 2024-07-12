-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2024 a las 23:21:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `datos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_usuario` int(50) NOT NULL,
  `id_libro` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_usuario`, `id_libro`, `fecha_inicio`, `fecha_termino`) VALUES
(20, 'bFiREAAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, 'LSzEDwAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, '_c2kEAAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, 'HWn3AAAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, '3DBJEAAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, 'uZDYlfDVYmEC ', '2024-06-18', '2024-06-19'),
(20, 'dkOHEAAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, 'QBwnDwAAQBAJ ', '2024-06-18', '2024-06-19'),
(20, '1wICEAAAQBAJ ', '2024-06-18', '2024-06-19'),
(10, '6yvEDwAAQBAJ ', '2024-06-18', '2024-06-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` varchar(100) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `año_publicacion` int(11) DEFAULT NULL,
  `disponibilidad` varchar(10) DEFAULT NULL,
  `ejemplares` varchar(100) DEFAULT NULL,
  `isbn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `titulo`, `autor`, `genero`, `año_publicacion`, `disponibilidad`, `ejemplares`, `isbn`) VALUES
('1wICEAAAQBAJ ', 'Papelucho en vacaciones', 'Marcela Paz', 'Genero', 2017, 'Disponible', '1', 2147483647),
('3DBJEAAAQBAJ ', 'Karma al instante', 'Marissa Meyer', 'Genero', 2021, 'Disponible', '1', 2147483647),
('6yvEDwAAQBAJ', 'Winter', 'Marissa Meyer', 'Juvenile Fiction', 2015, 'Disponible', '1', 2147483647),
('7IgwjwEACAAJ ', 'Landline. Segundas Oportunidades / Landline: a Novel', 'Rainbow Rowell', 'Genero', 2015, 'Disponible', '1', 2147483647),
('8FCREAAAQBAJ ', 'Fangirl (Spanish Edition)', 'Rainbow Rowell', 'Genero', 2015, 'Disponible', '1', 607113465),
('Bf4BEAAAQBAJ ', 'Papelucho historiador', 'Marcela Paz', 'Genero', 2019, 'Disponible', '1', 2147483647),
('bFiREAAAQBAJ', 'Antes de diciembre / Before December', 'Joana Marcús', 'Young Adult Fiction', 2022, 'Disponible', '1', 2147483647),
('bftNDwAAQBAJ ', 'Harry Potter y el legado maldito', 'J.K. Rowling, Jack Thorne, John Tiffany', 'Genero', 2018, 'Disponible', '1', 1781105294),
('CuCoEIl3XQsC ', 'The DaVinci Legacy', 'Lewis Perdue', 'Genero', 1983, 'Disponible', '1', 523417624),
('CZNWDgAAQBAJ ', 'Cuento de Navidad', 'Guy de Maupassant', 'Genero', 0, 'Disponible', '1', 0),
('dkOHEAAAQBAJ', 'Después de diciembre (edición revisada por la autora) (Meses a tu lado 2)', 'Joana Marcús', 'Young Adult Fiction / Romance / Contemporary, Young Adult Fiction / School & Education / College & U', 2022, 'Disponible', '1', 2147483647),
('dONFEAAAQBAJ', 'Antes de diciembre (edición revisada por la autora) (Meses a tu lado 1)', 'Joana Marcús', 'Young Adult Fiction', 2021, 'Disponible', '1', 2147483647),
('ELMbAgAAQBAJ ', 'Eleanor y Park', 'Rainbow Rowell', 'Genero', 2013, 'Disponible', '1', 2147483647),
('ewBGEAAAQBAJ', 'Float', 'Kate Marchant', 'Young Adult Fiction', 2022, 'Disponible', '1', 2147483647),
('FkbMEAAAQBAJ', 'Harry Potter y la piedra filosofal', 'J.K. Rowling', 'Juvenile Fiction', 2023, 'Disponible', '1', 2147483647),
('g8zlzgEACAAJ', 'Karma al instante', 'Marissa Meyer', 'High school students', 2021, 'Disponible', '1', 2147483647),
('Gc2uEAAAQBAJ', 'Romeo and Julie', 'Gary Owen', 'Drama', 2023, 'Disponible', '1', 2147483647),
('GFRAbwAACAAJ', 'Crepúsculo', 'Stephenie Meyer', 'Juvenile Fiction / Love & Romance', 2006, 'Disponible', '1', 2147483647),
('hDFuDwAAQBAJ', 'Kpop Secret', 'UK Jung', 'Art / Popular Culture, Juvenile Nonfiction / Music / Popular, Performing Arts / Dance / Popular, Art', 2018, '1', '1', 2147483647),
('HWn3AAAAQBAJ ', 'Eleanor y Park', 'Rainbow Rowell', 'Genero', 2013, 'Disponible', '1', 2147483647),
('iiH5pwAACAAJ', 'Crepúsculo (Serie Roja)', 'Stephenie Meyer', 'Juvenile Fiction / Love & Romance', 2011, 'Disponible', '1', 2147483647),
('j4vZEAAAQBAJ', 'Las luces de febrero (Meses a tu lado 4)', 'Joana Marcús', 'Young Adult Fiction', 2023, 'Disponible', '1', 2147483647),
('JUDxEAAAQBAJ', 'Orgullo y prejuicio', 'Jane Austen', 'Art', 2024, 'Disponible', '1', 2147483647),
('l849AwAAQBAJ', 'Danza de dragones (Canción de hielo y fuego 5)', 'George R.R. Martin', 'Fiction', 2014, 'Disponible', '1', 2147483647),
('lRxxDgAAQBAJ', 'Orgullo y Prejuicio – Pride and Prejudice', 'Jane Austen', 'Juvenile Fiction', 2017, 'Disponible', '1', 2147483647),
('LsZeDwAAQBAJ', 'Heartless', 'Marissa Meyer', 'Fiction', 2016, 'Disponible', '1', 2147483647),
('lTRVEAAAQBAJ', 'Luna nueva (Saga Crepúsculo 2)', 'Stephenie Meyer', 'Young Adult Fiction / Romance / Paranormal, Young Adult Fiction / Vampires', 2021, '1', '1', 2147483647),
('mFk2zwEACAAJ', 'R y Julie', 'Isaac Marion', 'No especificado', 2015, 'Disponible', '1', 2147483647),
('NDxlDwAAQBAJ', 'Fuego y Sangre (Canción de hielo y fuego 0)', 'George R.R. Martin', 'Fiction', 2018, 'Disponible', '1', 2147483647),
('nmJrEAAAQBAJ', 'Orgullo y prejuicio (Clásicos de Jane Austen)', 'Jane Austen', 'Fiction', 2019, 'Disponible', '1', 2147483647),
('NMYm0AEACAAJ', 'Trilogía Fuego 3. Ciudades de fuego', 'Desconocido', 'No especificado', 0, 'Disponible', '1', 2147483647),
('nuFUzwEACAAJ', 'Trilogía Fuego 1. Ciudades de humo', 'Desconocido', 'No especificado', 0, 'Disponible', '1', 2147483647),
('p7WHEAAAQBAJ', 'Serendipity', 'Marissa Meyer', 'Juvenile Fiction', 2022, 'Disponible', '1', 2147483647),
('PDi9EAAAQBAJ', 'Festín de cuervos (Canción de hielo y fuego 4)', 'George R.R. Martin', 'Fiction', 2023, 'Disponible', '1', 2147483647),
('PKqQEAAAQBAJ', 'Después de diciembre / After December', 'Joana Marcús', 'Young Adult Fiction', 2023, 'Disponible', '1', 2147483647),
('PKTljwEACAAJ', 'Scarlet', 'Marissa Meyer', 'Young Adult Fiction', 2016, 'Disponible', '1', 2147483647),
('PvndDgAAQBAJ', 'Orgullo y prejuicio', 'Jane Austen', 'Juvenile Fiction', 2017, 'Disponible', '1', 2147483647),
('Q7Im0AEACAAJ', 'Trilogía Fuego 1. Ciudades de humo', 'Desconocido', 'No especificado', 0, 'Disponible', '1', 2147483647),
('Qae8BAAAQBAJ', 'Fangirl', 'Rainbow Rowell', 'Young Adult Fiction / Romance / General', 2014, '1', '1', 2147483647),
('QBwnDwAAQBAJ ', 'Cien años de soledad (edición ilustrada)', 'Gabriel García Márquez, Luisa Rivera', 'Genero', 2017, 'Disponible', '1', 2147483647),
('RS3EDwAAQBAJ ', 'Saga Crónicas Lunares', 'Marissa Meyer', 'Genero', 2015, 'Disponible', '1', 2147483647),
('sQ4DzgEACAAJ', 'A Través de Tu Ventana', 'Meldry Báez', 'No especificado', 2020, 'Disponible', '1', 2147483647),
('sTTrhoJOhrQC ', 'The Da Vinci Code', 'Dan Brown', 'Genero', 2003, 'Disponible', '1', 385504209),
('TplfY0BnQU4C', 'Cinder (Las crónicas lunares 1)', 'Marissa Meyer', 'Young Adult Fiction', 2012, 'Disponible', '1', 2147483647),
('uUOBPgXQtvUC', 'Harry Potter y la Orden del Fénix', 'J.K. Rowling', 'Juvenile Fiction', 2015, 'Disponible', '1', 2147483647),
('uZDYlfDVYmEC ', 'Harry Potter y el misterio del príncipe', 'J.K. Rowling', 'Genero', 2015, 'Disponible', '1', 1781101361),
('vjovPQAACAAJ', 'Julie and Ro', 'Ruroanik Publishers', 'No especificado', 1996, 'Disponible', '1', 1889361054),
('wQICEAAAQBAJ ', 'Papelucho casi huérfano', 'Marcela Paz', 'Genero', 2019, 'Disponible', '1', 2147483647),
('XFXtmgEACAAJ', 'Juego de tronos 2', 'George R. R. Martin', 'No especificado', 2012, 'Disponible', '1', 2147483647),
('XLVvAAAACAAJ', 'Harry Potter Y la Piedra Filosofal', 'J. K. Rowling', 'England', 2006, 'Disponible', '1', 2147483647),
('xzJjBgAAQBAJ', 'titulo', NULL, NULL, NULL, NULL, NULL, NULL),
('yHWREAAAQBAJ', 'Harry Potter y la piedra filosofal. Edición ilustrada / Harry Potter and the Sorcerer\'s Stone: The I', 'J.K. Rowling', 'Juvenile Fiction', 2015, 'Disponible', '1', 2147483647),
('yizEDwAAQBAJ', 'Archienemigos', 'Marissa Meyer', 'Juvenile Fiction', 2015, 'Disponible', '1', 2147483647),
('YTM6CQAAQBAJ', 'Heartless', 'Marissa Meyer', 'Young Adult Fiction', 2016, 'Disponible', '1', 2147483647),
('yyvEDwAAQBAJ', 'Fairest', 'Marissa Meyer', 'Juvenile Fiction', 2015, 'Disponible', '1', 2147483647),
('zl13g5uRM4EC', 'Harry Potter y la cámara secreta', 'J.K. Rowling', 'Juvenile Fiction', 2015, 'Disponible', '1', 2147483647),
('_c2kEAAAQBAJ ', 'Tres meses (Meses a tu lado 3)', 'Joana Marcús', 'Genero', 2023, 'Disponible', '1', 2147483647),
('_cRODwAAQBAJ ', 'Leonardo da Vinci', 'Walter Isaacson', 'Genero', 2018, 'Disponible', '1', 2147483647),
('_uj1EAAAQBAJ', 'Fangirl', 'Rainbow Rowell', 'Fiction / Romance / Contemporary', 2018, 'Disponible', '1', 2147483647);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_deseos`
--

CREATE TABLE `lista_deseos` (
  `id_usuario` int(11) DEFAULT NULL,
  `id_libro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista_deseos`
--

INSERT INTO `lista_deseos` (`id_usuario`, `id_libro`) VALUES
(10, 'YGdwDwAAQBAJ'),
(20, 'QBwnDwAAQBAJ '),
(20, 'dkOHEAAAQBAJ '),
(20, 'bFiREAAAQBAJ '),
(20, '_c2kEAAAQBAJ '),
(20, 'LSzEDwAAQBAJ '),
(20, '8FCREAAAQBAJ '),
(20, '7IgwjwEACAAJ '),
(20, 'HWn3AAAAQBAJ '),
(20, '3DBJEAAAQBAJ '),
(20, 'Bf4BEAAAQBAJ '),
(20, '1wICEAAAQBAJ '),
(20, 'uZDYlfDVYmEC '),
(7, 'bftNDwAAQBAJ '),
(20, 'RS3EDwAAQBAJ ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id_reseña` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `calificacion` varchar(10) DEFAULT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `id_libro` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id_reseña`, `id_usuario`, `calificacion`, `comentario`, `id_libro`) VALUES
(4, 20, '4', 'Me encantó este libro, lo recomiendo ampliamente', 'TplfY0BnQU4C'),
(5, 30, '5', 'Una historia fascinante, no pude dejar de leerlo', 'TplfY0BnQU4C'),
(6, 31, '3', 'Interesante pero algo predecible', 'TplfY0BnQU4C'),
(10, 20, '5', 'ame, recomendado', 'PKqQEAAAQBAJ'),
(11, 20, '5', 'me rei y llore, lo mejor', 'LSzEDwAAQBAJ'),
(14, 20, '5', 'me sorprendio, recomendado', 'mFk2zwEACAAJ'),
(16, 20, '5', 'muy bueno el libro, me lo lei ya 2 veces', 'bFiREAAAQBAJ'),
(17, 20, '4', 'muy buen libro', 'XLVvAAAACAAJ'),
(30, 20, '5', 'HERMSOOOOO', 'PKqQEAAAQBAJ'),
(33, 20, '1', '1', 'iiH5pwAACAAJ'),
(34, 20, '3', 'aburrido', 'jgr2DwAAQBAJ'),
(35, 20, '1', 'muy malo', 'hDFuDwAAQBAJ'),
(36, 20, '1', 'muy malo', 'hDFuDwAAQBAJ'),
(37, 20, '5', 'muy buena', '6yvEDwAAQBAJ'),
(38, 20, '2', 'HORIIBLEEE', '6yvEDwAAQBAJ'),
(39, 20, '5', 'muy bueno', '_uj1EAAAQBAJ'),
(40, 20, '1', '1', 'GFRAbwAACAAJ'),
(41, 20, '4', 'mee', 'GFRAbwAACAAJ'),
(42, 20, '5', 'el mejor libro del mundo', 'LSzEDwAAQBAJ'),
(43, 20, '5', '333', 'LSzEDwAAQBAJ'),
(44, 20, '5', 'entretenido', 'RS3EDwAAQBAJ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `situacion`
--

CREATE TABLE `situacion` (
  `id_libro` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `id_usuario` int(100) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `situacion`
--

INSERT INTO `situacion` (`id_libro`, `estado`, `id_usuario`) VALUES
('bFiREAAAQBAJ ', 'Prestado', 20),
('LSzEDwAAQBAJ ', 'Prestado', 20),
('_c2kEAAAQBAJ ', 'Prestado', 20),
('HWn3AAAAQBAJ ', 'Prestado', 20),
('3DBJEAAAQBAJ ', 'Prestado', 20),
('uZDYlfDVYmEC ', 'Prestado', 20),
('dkOHEAAAQBAJ ', 'Prestado', 20),
('QBwnDwAAQBAJ ', 'Prestado', 20),
('1wICEAAAQBAJ ', 'Prestado', 20),
('6yvEDwAAQBAJ ', 'Prestado', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `nacimiento` date NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` int(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT curdate(),
  `correo` varchar(300) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `usuario`, `genero`, `nacimiento`, `direccion`, `telefono`, `contraseña`, `fecha_registro`, `correo`, `imagen`) VALUES
(7, 'pau', 'pau', 'mujer', '2002-12-03', 'chile', 123, '123', '2024-04-17', 'pau@gmail.com', 'default.png'),
(10, 'paula', 'paula123', 'mujer', '2002-12-03', 'chile', 12345, '781f9d07d8371ed6', '2024-04-17', 'p.alcarasvillavicenc@gmail.com', '★.jpg'),
(20, 'paula123', 'honeisunnie', 'mujer', '2002-12-03', 'san pablo 2076', 945388424, '3312', '2024-04-17', 'paula.alcaras@gmail.com', 'pelotatsukki.jpg'),
(22, 'Ramon Alcaras', 'ralcaras', 'hombre', '1976-03-27', 'Baquedano', 123455, 'paufer', '2024-04-27', 'ralcaras@hotmail.com', 'default.png'),
(24, 'alicia', 'alicia123', 'mujer', '1986-03-15', 'Valparaiso', 123456, 'monito', '2024-04-27', 'avillavicenc@gmail.com', 'default.png'),
(29, 'Paula', '123', 'hombre', '2000-02-03', 'San Pablo', 945388424, 'monito', '2024-04-29', 'fernanda.alcaras@gmail.com', 'default.png'),
(30, 'eric', 'ericSohn', 'hombre', '2000-12-22', 'corea', 12345, 'eric', '2024-04-29', 'eric.sohn@gmail.com', 'eric tbz [231222].jpg'),
(31, 'sunwoo', 'sunwoo', 'hombre', '2000-04-12', 'corea', 123789, 'sunwoo', '2024-04-29', 'sunwoo.kim@gmail.com', 'default.png'),
(32, 'jennie', 'jennierubyjane', 'mujer', '1996-01-19', 'nueva zelanda', 111111111, 'jenniekim', '2024-05-03', 'jennierubyjane@gmail.com', 'default.png'),
(33, 'haechan', 'haechanchan', 'otro', '2000-02-03', 'corea', 159789, 'nct127', '2024-05-05', 'haechan@gmail.com', 'default.png'),
(34, 'jeno', 'jeno', 'hombre', '2000-02-15', 'corea', 127, 'jeno', '2024-05-05', 'jeno@gmail.com', 'default.png'),
(35, 'lisa', 'lalisa', 'otro', '1996-01-05', 'tailandia', 68434543, 'lisa', '2024-05-05', 'lisa.lalisa@gmail.com', 'default.png'),
(36, 'rose', 'rose', 'mujer', '1996-05-02', 'corea', 4345646, 'rosepark', '2024-05-05', 'rose.park@gmail.com', 'default.png'),
(37, 'jisoo', 'soyaa', 'mujer', '1996-05-03', 'corea', 543836, 'jisoo', '2024-05-05', 'jisoo@gmail.com', 'default.png'),
(38, 'juyeon', 'jujuyeon', 'hombre', '1998-01-15', 'corea', 43446985, 'juyeon', '2024-05-05', 'juyeon@gmail.com', 'default.png'),
(39, 'jae', 'jae', 'hombre', '2000-01-05', 'corea', 58469, 'jae', '2024-05-05', 'jae@gmail.com', NULL),
(40, 'jake', 'jake', 'hombre', '2002-02-01', 'australia', 4673614, 'layla', '2024-05-05', 'jake@gmail.com', NULL),
(41, 'jay', 'jay', 'hombre', '2002-04-15', 'seattle', 44668345, 'jay', '2024-05-05', 'jay@gmail.com', NULL),
(42, 'heesung', 'hee', 'hombre', '2001-02-05', 'coreaa', 556454, 'heesung', '2024-05-05', 'hee@gmail.com', NULL),
(43, 'dwdw', 'sunno', 'hombre', '2003-02-15', 'corea', 5643135, 'sunno', '2024-05-05', 'sunno@gmail.com', NULL),
(44, 'niki', 'niki', 'hombre', '2007-02-05', 'corea', 568458, 'niki', '2024-05-05', 'niki@gmail.com', NULL),
(45, 'julie', 'julie', 'mujer', '2003-03-05', 'corea', 4863543, 'julie', '2024-05-05', 'julie@gmail.com', NULL),
(46, 'sunghoon', 'iceprince', 'hombre', '2002-12-08', 'corea', 154646846, 'sunghoon', '2024-05-05', 'sunghoon@gmail.com', NULL),
(48, 'mark', 'mark', 'hombre', '2000-05-06', 'eeuu', 2147483647, 'mark', '2024-05-05', 'mark@gmail.com', NULL),
(49, 'jhonny', 'jhonny', 'hombre', '1996-03-05', 'chicago', 846464684, 'jhonny', '2024-05-05', 'jhonny@gmail.com', NULL),
(50, '1234', '1234', 'otro', '2000-03-03', 'San Pablo', 945388424, '1234', '2024-05-05', '123@gmail.com', NULL),
(51, '12345', '12345', 'hombre', '2000-03-03', 'San Pablo', 945388424, '123', '2024-05-05', '12345@gmail.com', NULL),
(52, '123456', '123456', 'hombre', '2000-03-03', 'San Pablo', 945388424, '123', '2024-05-05', '123456@gmail.com', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`);

--
-- Indices de la tabla `lista_deseos`
--
ALTER TABLE `lista_deseos`
  ADD KEY `id_libro` (`id_libro`) USING BTREE,
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id_reseña`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `fk_reseñas_id_libro` (`id_libro`);

--
-- Indices de la tabla `situacion`
--
ALTER TABLE `situacion`
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uk_usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id_reseña` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lista_deseos`
--
ALTER TABLE `lista_deseos`
  ADD CONSTRAINT `fk_libro_id_libro` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`),
  ADD CONSTRAINT `lista_deseos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `fk_reseñas_id_libro` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`),
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `situacion`
--
ALTER TABLE `situacion`
  ADD CONSTRAINT `situacion_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
