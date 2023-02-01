/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : db_siscdi

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 20/11/2022 20:52:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for apartado_area
-- ----------------------------
DROP TABLE IF EXISTS `apartado_area`;
CREATE TABLE `apartado_area`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `id_area` bigint(20) NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_area_apartado`(`id_area`) USING BTREE,
  CONSTRAINT `fk_apar_area` FOREIGN KEY (`id_area`) REFERENCES `areas_expediente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of apartado_area
-- ----------------------------
INSERT INTO `apartado_area` VALUES (1, 'Estudio Socioeconómico del niño (ESEN) o Ficha socio económica firmado y sellado por Facilitador, Partida de Nacimiento con el sello de procesado SDS', 1, 1, '2022-11-18 14:07:54', NULL);
INSERT INTO `apartado_area` VALUES (2, 'Constancia de entrega y liquidación de regalos (Registro de regalos recibidos) que incluya fecha, fotografía, cantidad del regalo y como se usó el dinero', 1, 1, '2022-11-18 14:08:54', '2022-11-18 14:08:54');
INSERT INTO `apartado_area` VALUES (3, 'Constancia de beneficios extraordinarios recibidos o registro de beneficios directos recibidos por medio de fondos de Intervenciones Complementarias (CIV)', 1, 1, '2022-11-18 14:08:52', '2022-11-18 14:08:52');
INSERT INTO `apartado_area` VALUES (4, 'Bianual (con sello de procesado SDS) del niño', 1, 1, '2022-11-18 14:08:51', NULL);
INSERT INTO `apartado_area` VALUES (5, 'Copias de cartas', 1, 1, '2022-11-18 14:09:04', NULL);
INSERT INTO `apartado_area` VALUES (6, 'Hoja de compromiso', 1, 1, '2022-11-18 15:02:06', '2022-11-18 15:02:06');
INSERT INTO `apartado_area` VALUES (7, 'Informe y Evaluacion del Desarrollo del Niño (CDPR), (se actualiza cada 2 años)', 2, 1, '2022-11-18 15:03:53', NULL);

-- ----------------------------
-- Table structure for archivos_detalle_expediente
-- ----------------------------
DROP TABLE IF EXISTS `archivos_detalle_expediente`;
CREATE TABLE `archivos_detalle_expediente`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_detalle_expediente` bigint(20) NULL DEFAULT NULL,
  `tipo_archivo` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_det_exp_arch`(`id_detalle_expediente`) USING BTREE,
  CONSTRAINT `fk_det_exp_arch` FOREIGN KEY (`id_detalle_expediente`) REFERENCES `detalle_expediente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of archivos_detalle_expediente
-- ----------------------------

-- ----------------------------
-- Table structure for areas_expediente
-- ----------------------------
DROP TABLE IF EXISTS `areas_expediente`;
CREATE TABLE `areas_expediente`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of areas_expediente
-- ----------------------------
INSERT INTO `areas_expediente` VALUES (1, 'Administrativa', 1, '2022-11-18 12:29:27', '2022-11-18 12:29:27');
INSERT INTO `areas_expediente` VALUES (2, 'Desarrollo del Niño', 1, '2022-11-18 12:29:20', '2022-11-18 12:29:20');
INSERT INTO `areas_expediente` VALUES (3, 'Espiritual', 1, '2022-11-18 12:29:15', NULL);
INSERT INTO `areas_expediente` VALUES (4, 'Cognitiva', 1, '2022-11-18 12:29:38', NULL);
INSERT INTO `areas_expediente` VALUES (5, 'Física', 1, '2022-11-18 12:29:45', NULL);
INSERT INTO `areas_expediente` VALUES (6, 'Socioemocional', 1, '2022-11-18 12:29:54', NULL);
INSERT INTO `areas_expediente` VALUES (7, 'Talleres Vocacionales', 1, '2022-11-18 12:30:05', NULL);

-- ----------------------------
-- Table structure for cargos
-- ----------------------------
DROP TABLE IF EXISTS `cargos`;
CREATE TABLE `cargos`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cargos
-- ----------------------------
INSERT INTO `cargos` VALUES (1, 'Tutor', NULL, '2022-11-17 11:52:26', '2022-11-17 11:52:26');
INSERT INTO `cargos` VALUES (2, 'Encargado CDI', NULL, '2022-11-08 15:59:21', NULL);

-- ----------------------------
-- Table structure for detalle_expediente
-- ----------------------------
DROP TABLE IF EXISTS `detalle_expediente`;
CREATE TABLE `detalle_expediente`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_expediente` bigint(10) NULL DEFAULT NULL,
  `id_apartado_area` bigint(20) NULL DEFAULT NULL,
  `titulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `fecha` date NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_apar_are_exp`(`id_apartado_area`) USING BTREE,
  INDEX `fk_det_exp`(`id_expediente`) USING BTREE,
  CONSTRAINT `fk_apar_are_exp` FOREIGN KEY (`id_apartado_area`) REFERENCES `apartado_area` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_det_exp` FOREIGN KEY (`id_expediente`) REFERENCES `expediente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_expediente
-- ----------------------------
INSERT INTO `detalle_expediente` VALUES (8, 5, 1, 'sfhj', 'sfh', '2011-12-10', '2022-11-20 20:03:11', NULL);
INSERT INTO `detalle_expediente` VALUES (9, 5, 2, 'sfjh', 'sryhj', '2021-11-11', '2022-11-20 20:30:17', NULL);
INSERT INTO `detalle_expediente` VALUES (10, 5, 1, 'zdgh', 'sfdgn', '2022-11-03', '2022-11-20 20:42:30', NULL);
INSERT INTO `detalle_expediente` VALUES (11, 5, 1, 'xzfg', 'xdfbn', '2022-10-31', '2022-11-20 20:43:23', NULL);
INSERT INTO `detalle_expediente` VALUES (12, 5, 1, 'zcvbn', 'xcvbmn', '2022-10-31', '2022-11-20 20:45:38', NULL);
INSERT INTO `detalle_expediente` VALUES (13, 5, 1, 'fxgh', 'sfhjn', '2022-11-01', '2022-11-20 20:46:28', NULL);
INSERT INTO `detalle_expediente` VALUES (14, 5, 1, 'xfhgj', 'fjh', '2022-10-30', '2022-11-20 20:47:04', NULL);

-- ----------------------------
-- Table structure for empleados
-- ----------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `id_cargo` bigint(20) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_empleados_cargo`(`id_cargo`) USING BTREE,
  CONSTRAINT `fk_empleados_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of empleados
-- ----------------------------
INSERT INTO `empleados` VALUES (1, 'Mario Jairo', 'Ventura Espinosa', 1, 1, '2022-11-08 16:51:07', '2022-11-08 16:51:07');
INSERT INTO `empleados` VALUES (2, 'Juan Carlos', 'Mendez Paredes', 1, 2, '2022-11-08 16:51:09', '2022-11-08 16:51:09');

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `start` date NULL DEFAULT NULL,
  `end` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of events
-- ----------------------------
INSERT INTO `events` VALUES (21, 'Prueba1', 'Prueba1', 'Prueba1', '2022-11-02', '2022-11-03');
INSERT INTO `events` VALUES (22, 'Prueba2', 'Prueba2', 'Prueba2', '2022-11-03', '2022-11-06');
INSERT INTO `events` VALUES (23, 'hhh', 'hgh', '789', '2022-11-09', '2022-11-10');

-- ----------------------------
-- Table structure for expediente
-- ----------------------------
DROP TABLE IF EXISTS `expediente`;
CREATE TABLE `expediente`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nombres` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `genero` tinyint(4) NULL DEFAULT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `edad` int(11) NULL DEFAULT NULL,
  `grupo_edad` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `turno` tinyint(4) NULL DEFAULT NULL,
  `id_tutor` bigint(20) NULL DEFAULT NULL,
  `horario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `foto_url` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_tutor_expe`(`id_tutor`) USING BTREE,
  CONSTRAINT `fk_tutor_expe` FOREIGN KEY (`id_tutor`) REFERENCES `empleados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of expediente
-- ----------------------------
INSERT INTO `expediente` VALUES (1, 'ESD10928237', 'Juan Carlos', 'Pineda Ponce', 1, '2001-01-09', 21, '2-5', 1, 1, 'Lunes - Miércoles ', 1, 'vistas/expediente/fotos/exp_1_f13fe24de28fa3ed2c3e0497a727f846.jpg', '2022-11-18 14:10:22', '2022-11-18 14:10:22');
INSERT INTO `expediente` VALUES (2, 'esd4367346', 'Juan Carlos', 'Aguirre Ayala', 1, '2014-12-10', NULL, '3-8', 1, 1, NULL, 1, NULL, '2022-11-17 12:29:52', NULL);
INSERT INTO `expediente` VALUES (3, 'MI12', 'wsrtfh', 'sretgh', 1, '2022-10-31', NULL, '3-8', 1, 1, 'Lunes - Martes - Jueves - Viernes ', 1, NULL, '2022-11-17 15:38:32', NULL);
INSERT INTO `expediente` VALUES (4, 'MI1245444', 'Ana Marina', 'Molina', 1, '2000-02-11', NULL, '3-8', 1, 1, 'Lunes - Miércoles - Jueves ', 0, NULL, '2022-11-18 10:24:06', '2022-11-18 10:24:06');
INSERT INTO `expediente` VALUES (5, 'PIfrffe', 'Roberto Antonio', 'Constanza Urquilla', 1, '2016-12-10', NULL, '2-5', 2, 1, 'Lunes ', 1, 'vistas/expediente/fotos/exp_5_a94ed91c4046ee752ed62626c46bc3c6.jpg', '2022-11-18 11:54:08', '2022-11-18 11:54:08');
INSERT INTO `expediente` VALUES (6, 'aeth3', 'Yancy', 'Palacios', 2, '2016-02-15', NULL, '3-8', 2, 1, 'Martes ', 0, '', '2022-11-18 11:22:10', '2022-11-18 11:22:10');
INSERT INTO `expediente` VALUES (7, 'adfge4', 'adfg', 'asdfg', 2, '2016-12-10', NULL, '2-5', 2, 1, 'Lunes ', 0, '', '2022-11-18 11:21:47', '2022-11-18 11:21:47');

-- ----------------------------
-- Table structure for modulos
-- ----------------------------
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of modulos
-- ----------------------------
INSERT INTO `modulos` VALUES (1, 'Inicio', 1, '2022-06-23 16:18:22', '2022-06-23 16:18:22');
INSERT INTO `modulos` VALUES (3, 'Roles', 1, '2022-07-04 18:09:17', NULL);
INSERT INTO `modulos` VALUES (4, 'Usuarios', 1, '2022-07-04 18:09:26', NULL);
INSERT INTO `modulos` VALUES (5, 'Expediente', 1, '2022-11-13 19:35:16', NULL);

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_modulo` bigint(20) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_modulo_permiso`(`id_modulo`) USING BTREE,
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES (1, 'Ver Roles', 3, '2022-06-23 16:18:51', '2022-06-23 16:18:51');
INSERT INTO `permisos` VALUES (2, 'Crear Roles', 3, '2022-06-23 16:18:52', '2022-06-23 16:18:52');
INSERT INTO `permisos` VALUES (3, 'Editar Roles', 3, '2022-06-23 16:18:53', '2022-06-23 16:18:53');
INSERT INTO `permisos` VALUES (4, 'Dar de baja Roles', 3, '2022-06-23 16:19:26', '2022-06-23 16:19:26');
INSERT INTO `permisos` VALUES (6, 'Ver Usuarios', 4, '2022-06-23 16:18:56', '2022-06-23 16:18:56');
INSERT INTO `permisos` VALUES (7, 'Crear Usuarios', 4, '2022-06-23 16:18:56', '2022-06-23 16:18:56');
INSERT INTO `permisos` VALUES (8, 'Editar Usuarios', 4, '2022-06-23 16:18:57', '2022-06-23 16:18:57');
INSERT INTO `permisos` VALUES (9, 'Dar de baja Usuarios', 4, '2022-06-23 16:19:17', '2022-06-23 16:19:17');
INSERT INTO `permisos` VALUES (10, 'Ver Expediente', 5, '2022-11-13 19:35:30', NULL);
INSERT INTO `permisos` VALUES (11, 'Crear Expediente', 5, '2022-11-13 19:35:37', NULL);
INSERT INTO `permisos` VALUES (12, 'Editar Expediente', 5, '2022-11-13 19:35:44', NULL);
INSERT INTO `permisos` VALUES (13, 'Dar de baja Expediente', 5, '2022-11-13 19:35:53', NULL);

-- ----------------------------
-- Table structure for permisosrol
-- ----------------------------
DROP TABLE IF EXISTS `permisosrol`;
CREATE TABLE `permisosrol`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permiso` bigint(20) NULL DEFAULT NULL,
  `id_rol` bigint(20) NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_permiso_permisorol`(`id_permiso`) USING BTREE,
  INDEX `fk_rol_permisorol`(`id_rol`) USING BTREE,
  CONSTRAINT `permisosrol_ibfk_1` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `permisosrol_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permisosrol
-- ----------------------------
INSERT INTO `permisosrol` VALUES (1, 1, 1, 1, '2022-07-05 09:50:37', NULL);
INSERT INTO `permisosrol` VALUES (3, 2, 1, 1, '2022-07-05 09:53:04', NULL);
INSERT INTO `permisosrol` VALUES (4, 3, 1, 1, '2022-07-05 09:53:05', NULL);
INSERT INTO `permisosrol` VALUES (5, 4, 1, 1, '2022-07-05 09:53:07', NULL);
INSERT INTO `permisosrol` VALUES (6, 6, 1, 1, '2022-07-05 09:53:12', NULL);
INSERT INTO `permisosrol` VALUES (7, 7, 1, 1, '2022-07-05 09:53:13', NULL);
INSERT INTO `permisosrol` VALUES (8, 8, 1, 1, '2022-07-05 09:53:13', NULL);
INSERT INTO `permisosrol` VALUES (9, 9, 1, 1, '2022-11-08 16:05:42', '2022-11-08 16:05:42');
INSERT INTO `permisosrol` VALUES (10, 10, 1, 1, '2022-11-13 19:35:59', NULL);
INSERT INTO `permisosrol` VALUES (11, 11, 1, 1, '2022-11-13 19:35:59', NULL);
INSERT INTO `permisosrol` VALUES (12, 12, 1, 1, '2022-11-13 19:36:00', NULL);
INSERT INTO `permisosrol` VALUES (13, 13, 1, 1, '2022-11-13 19:36:01', NULL);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrador', 1, '2022-07-05 09:49:14', NULL);
INSERT INTO `roles` VALUES (2, 'Personal del CDI', 1, '2022-11-08 16:55:28', '2022-11-10 16:07:06');
INSERT INTO `roles` VALUES (3, '', 0, '2022-11-12 21:34:11', NULL);
INSERT INTO `roles` VALUES (4, 'a', 1, '2022-11-12 22:18:41', NULL);

-- ----------------------------
-- Table structure for sesiones
-- ----------------------------
DROP TABLE IF EXISTS `sesiones`;
CREATE TABLE `sesiones`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_sesion` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `token` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `token_exp` int(11) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 327 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sesiones
-- ----------------------------
INSERT INTO `sesiones` VALUES (318, '9b4q89mijnunh7qjvngkcnkmji', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Njc5NDUwMDIsImV4cCI6MTY2ODAzMTQwMiwiZGF0YSI6eyJpZCI6IjEiLCJlbWFpbCI6InJpY2NpZXJpcGFsYWNpb3NAZ21haWwuY29tIn19.-Vvou2zQ1R5SfaqJozVOwuYv_u9fG2LCzYHAv6aEKJM', 1668031402, 1, '2022-11-08 16:03:22');
INSERT INTO `sesiones` VALUES (319, 'j4h2nh7rsnifj86ok9tagtd2n7', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NjgyMDcyNDMsImV4cCI6MTY2ODI5MzY0MywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.SHELk_yZcvog-7ZtmD7Phkt9cRGXj4SjyVSlFZPqIiE', 1668293643, 2, '2022-11-11 16:54:03');
INSERT INTO `sesiones` VALUES (320, 'iuinn0t898ai84hqarauvlq50j', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NjgyODQ0NzgsImV4cCI6MTY2ODM3MDg3OCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.dthGjx51Qfqtwvnzwd-UlHzqIsEKtZ5s0V7K0iP9-Ts', 1668370878, 2, '2022-11-12 14:21:18');
INSERT INTO `sesiones` VALUES (321, '61pnqtc60a1sgh79vg6hkm556q', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NjgzMTU3MjAsImV4cCI6MTY2ODQwMjEyMCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.5EeRTyTlC3mugMwhQBj-WLnmLOFYhnYTeiTefHq88wM', 1668402120, 2, '2022-11-12 23:02:00');
INSERT INTO `sesiones` VALUES (326, '9b4q89mijnunh7qjvngkcnkmji', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Njg5ODU5ODEsImV4cCI6MTY2OTA3MjM4MSwiZGF0YSI6eyJpZCI6MSwiZW1haWwiOiJyaWNjaWVyaXBhbGFjaW9zQGdtYWlsLmNvbSJ9fQ.PdVfpZJhHGCwP-VxyaVzPvxR-hzc4heqdsYkTONgGE0', 1669072381, 1, '2022-11-20 17:13:01');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `token_exp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_empleado` bigint(20) NULL DEFAULT NULL,
  `id_rol` bigint(20) NULL DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `foto_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_rol_usuario`(`id_rol`) USING BTREE,
  INDEX `fk_empleados_usuario`(`id_empleado`) USING BTREE,
  CONSTRAINT `fk_empleados_usuario` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'riccieripalacios@gmail.com', '$2a$07$azybxcagsrp23425rpazyOJ2L2WK7boD6L0yabye19u1I.JqjawKG', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NjQzOTg0NDEsImV4cCI6MTY2NDQ4NDg0MSwiZGF0YSI6eyJpZCI6IjEiLCJlbWFpbCI6InJpY2NpZXJpcGFsYWNpb3NAZ21haWwuY29tIn19.qQheX37D9GYQ-Owhl_X0NE3HhMxA4wRGi0KcDBfi5rw', '1664484841', NULL, 1, 1, 'vistas/usuarios/fotos/usuario_17_806c783678d263fd0d79c4929b746062.jpg', '2022-09-28 16:54:01', '2022-09-28 16:54:01');
INSERT INTO `usuarios` VALUES (2, 'admin@gmail.com', '$2a$07$azybxcagsrp23425rpazyOq1MTBjNX.BdECR0V6VIz.oseVnxGeRe', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NjAwNTcwNzcsImV4cCI6MTY2MDE0MzQ3NywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.bLGyq7jUJnIJgQwqAwjmj0rKLlssYY-gyBlv9O4CIqk', '1660143477', 1, 1, 1, NULL, '2022-11-08 16:54:55', '2022-11-08 16:54:55');
INSERT INTO `usuarios` VALUES (3, 'nuevo@gmail.com', '$2a$07$azybxcagsrp23425rpazyOtPOnXN9oEHXAyRtEPmZ3q9b.43njt56', NULL, NULL, 1, 2, 1, NULL, '2022-11-10 16:07:08', '2022-11-10 16:07:08');

SET FOREIGN_KEY_CHECKS = 1;
