/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : db_siscdi

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 02/02/2023 20:54:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cargos
-- ----------------------------
INSERT INTO `cargos` VALUES (1, 'Tutor', 1, '2022-11-29 13:49:33', '2022-11-29 13:49:33');
INSERT INTO `cargos` VALUES (2, 'Encargado CDI', NULL, '2022-11-08 15:59:21', NULL);
INSERT INTO `cargos` VALUES (3, 'Docente', 2, '2022-11-29 13:50:01', NULL);
INSERT INTO `cargos` VALUES (5, 'ORGANIZADOR', 1, '2023-02-01 16:22:45', '2023-02-01 16:22:45');
INSERT INTO `cargos` VALUES (6, 'a', 1, '2023-02-01 21:26:38', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of empleados
-- ----------------------------
INSERT INTO `empleados` VALUES (1, 'Mario Jairo', 'Ventura Espinosa', 1, 1, '2022-11-29 20:58:36', '2022-11-29 20:58:36');

-- ----------------------------
-- Table structure for eventos
-- ----------------------------
DROP TABLE IF EXISTS `eventos`;
CREATE TABLE `eventos`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of eventos
-- ----------------------------
INSERT INTO `eventos` VALUES (10, 'Sistemas para consulta de información de DENUE,SCINCE, Inventario Nacional de Vivienda 2016,PyMES y Mapas Digitales', 1, '2023-02-02 17:36:08', '2023-02-02 17:36:08');

-- ----------------------------
-- Table structure for formularios
-- ----------------------------
DROP TABLE IF EXISTS `formularios`;
CREATE TABLE `formularios`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_tipo_participacion` bigint(4) NULL DEFAULT NULL,
  `id_evento` bigint(20) NULL DEFAULT NULL,
  `nombre_evento_opcional` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fecha_evento` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lugar_evento` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fecha_expedicion` date NULL DEFAULT NULL,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_tipo_participacion`(`id_tipo_participacion`) USING BTREE,
  INDEX `fk_id_evento`(`id_evento`) USING BTREE,
  CONSTRAINT `fk_tipo_participacion` FOREIGN KEY (`id_tipo_participacion`) REFERENCES `participacion` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_evento` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of formularios
-- ----------------------------
INSERT INTO `formularios` VALUES (1, 'Prueba Nombre', 'Prueba Apellido', 12, 10, '', '10/Febrero/2023,17/Febrero/2023', 'Prueba Evento 1', '2023-02-02', '2023-02-02 20:45:15', '2023-02-02 20:45:15');

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
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of modulos
-- ----------------------------
INSERT INTO `modulos` VALUES (1, 'Inicio', 1, '2022-06-23 16:18:22', '2022-06-23 16:18:22');
INSERT INTO `modulos` VALUES (3, 'Roles', 1, '2022-07-04 18:09:17', NULL);
INSERT INTO `modulos` VALUES (4, 'Usuarios', 1, '2022-07-04 18:09:26', NULL);
INSERT INTO `modulos` VALUES (5, 'Expediente', 1, '2022-11-13 19:35:16', NULL);
INSERT INTO `modulos` VALUES (6, 'Empleados', 1, '2022-11-29 13:47:30', NULL);
INSERT INTO `modulos` VALUES (7, 'Cargos', 1, '2022-11-29 13:47:36', NULL);
INSERT INTO `modulos` VALUES (8, 'Areas del Expediente', 1, '2022-12-09 09:17:10', NULL);
INSERT INTO `modulos` VALUES (9, 'Apartados de areas', 1, '2022-12-09 09:20:39', '2022-12-09 09:20:39');
INSERT INTO `modulos` VALUES (10, 'Actividades', 1, '2022-12-09 09:22:37', NULL);
INSERT INTO `modulos` VALUES (11, 'Reporte', 1, '2022-12-11 16:09:36', NULL);
INSERT INTO `modulos` VALUES (12, 'Actividades Finalizadas', 1, '2022-12-12 20:48:10', NULL);
INSERT INTO `modulos` VALUES (13, 'Consultas', 1, '2022-12-12 21:58:04', NULL);
INSERT INTO `modulos` VALUES (14, 'Participacion', 1, '2023-02-01 17:41:50', NULL);
INSERT INTO `modulos` VALUES (15, 'Evento', 1, '2023-02-01 21:35:57', NULL);
INSERT INTO `modulos` VALUES (16, 'Formulario', 1, '2023-02-02 14:18:13', NULL);

-- ----------------------------
-- Table structure for participacion
-- ----------------------------
DROP TABLE IF EXISTS `participacion`;
CREATE TABLE `participacion`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `fecha_creacion` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of participacion
-- ----------------------------
INSERT INTO `participacion` VALUES (12, 'CONFERENCISTA', 1, '2023-02-01 22:00:24', NULL);
INSERT INTO `participacion` VALUES (13, 'CONGRESISTA', 1, '2023-02-01 22:00:37', NULL);
INSERT INTO `participacion` VALUES (14, 'EXPOSITOR', 1, '2023-02-02 15:35:19', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `permisos` VALUES (14, 'Ver Empleado', 6, '2022-11-29 13:47:58', NULL);
INSERT INTO `permisos` VALUES (15, 'Crear Empleado', 6, '2022-11-29 13:48:03', NULL);
INSERT INTO `permisos` VALUES (16, 'Editar Empleado', 6, '2022-11-29 13:48:10', NULL);
INSERT INTO `permisos` VALUES (17, 'Dar de baja Empleado', 6, '2022-11-29 13:48:17', NULL);
INSERT INTO `permisos` VALUES (18, 'Ver Cargo', 7, '2022-11-29 13:48:30', NULL);
INSERT INTO `permisos` VALUES (19, 'Crear Cargo', 7, '2022-11-29 13:48:35', NULL);
INSERT INTO `permisos` VALUES (20, 'Editar Cargo', 7, '2022-11-29 13:48:40', NULL);
INSERT INTO `permisos` VALUES (21, 'Dar de baja Cargo', 7, '2022-11-29 13:48:50', NULL);
INSERT INTO `permisos` VALUES (22, 'Ver Areas Expediente', 8, '2022-12-09 09:18:04', NULL);
INSERT INTO `permisos` VALUES (23, 'Crear Areas Expediente', 8, '2022-12-09 09:18:10', NULL);
INSERT INTO `permisos` VALUES (24, 'Editar Areas Expediente', 8, '2022-12-09 09:18:15', NULL);
INSERT INTO `permisos` VALUES (25, 'Dar de baja Areas Expediente', 8, '2022-12-09 09:18:21', NULL);
INSERT INTO `permisos` VALUES (26, 'Ver Apartado de Expediente', 9, '2022-12-09 09:18:47', NULL);
INSERT INTO `permisos` VALUES (27, 'Crear Apartado de Expediente', 9, '2022-12-09 09:18:53', NULL);
INSERT INTO `permisos` VALUES (28, 'Editar Apartado de Expediente', 9, '2022-12-09 09:19:04', NULL);
INSERT INTO `permisos` VALUES (29, 'Dar de baja Apartado de Expediente', 9, '2022-12-09 09:19:14', NULL);
INSERT INTO `permisos` VALUES (30, 'Ver Actividades', 10, '2022-12-09 09:22:59', '2022-12-09 09:22:59');
INSERT INTO `permisos` VALUES (31, 'Crear Actividades', 10, '2022-12-09 09:23:04', NULL);
INSERT INTO `permisos` VALUES (32, 'Editar Actividades', 10, '2022-12-09 09:23:12', NULL);
INSERT INTO `permisos` VALUES (33, 'Finalizar Actividades', 10, '2022-12-11 15:58:28', '2022-12-11 15:58:28');
INSERT INTO `permisos` VALUES (35, 'Ver Reportes', 11, '2022-12-11 16:09:38', NULL);
INSERT INTO `permisos` VALUES (36, 'Ver ActividadesF', 12, '2022-12-12 20:48:49', NULL);
INSERT INTO `permisos` VALUES (37, 'Ver Consultas', 13, '2022-12-12 21:58:34', '2022-12-12 21:58:34');
INSERT INTO `permisos` VALUES (38, 'Ver Participacion', 14, '2023-02-01 17:46:18', '2023-02-01 17:46:18');
INSERT INTO `permisos` VALUES (39, 'Editar Participacion', 14, '2023-02-01 17:42:46', NULL);
INSERT INTO `permisos` VALUES (40, 'Dar de baja Participacion', 14, '2023-02-01 17:43:19', NULL);
INSERT INTO `permisos` VALUES (41, 'Crear Participacion', 14, '2023-02-01 17:47:24', NULL);
INSERT INTO `permisos` VALUES (42, 'Ver Evento', 15, '2023-02-01 21:36:34', '2023-02-01 21:36:34');
INSERT INTO `permisos` VALUES (43, 'Crear Evento', 15, '2023-02-01 21:36:30', '2023-02-01 21:36:30');
INSERT INTO `permisos` VALUES (44, 'Editar Evento', 15, '2023-02-01 21:36:26', NULL);
INSERT INTO `permisos` VALUES (45, 'Dar de baja Evento', 15, '2023-02-01 21:36:54', '2023-02-01 21:36:54');
INSERT INTO `permisos` VALUES (46, 'Crear Formulario', 16, '2023-02-02 14:18:35', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `permisosrol` VALUES (14, 14, 1, 1, '2022-11-29 13:48:58', NULL);
INSERT INTO `permisosrol` VALUES (15, 15, 1, 1, '2022-11-29 13:48:59', NULL);
INSERT INTO `permisosrol` VALUES (16, 16, 1, 1, '2022-11-29 13:48:59', NULL);
INSERT INTO `permisosrol` VALUES (17, 17, 1, 1, '2022-11-29 13:49:00', NULL);
INSERT INTO `permisosrol` VALUES (18, 18, 1, 1, '2022-11-29 13:49:05', NULL);
INSERT INTO `permisosrol` VALUES (19, 19, 1, 1, '2022-11-29 13:49:05', NULL);
INSERT INTO `permisosrol` VALUES (20, 20, 1, 1, '2022-11-29 13:49:06', NULL);
INSERT INTO `permisosrol` VALUES (21, 21, 1, 1, '2022-11-29 13:49:06', NULL);
INSERT INTO `permisosrol` VALUES (22, 22, 1, 1, '2022-12-09 09:20:12', NULL);
INSERT INTO `permisosrol` VALUES (23, 23, 1, 1, '2022-12-09 09:20:13', NULL);
INSERT INTO `permisosrol` VALUES (24, 24, 1, 1, '2022-12-09 09:20:14', NULL);
INSERT INTO `permisosrol` VALUES (25, 25, 1, 1, '2022-12-09 09:20:14', NULL);
INSERT INTO `permisosrol` VALUES (26, 26, 1, 1, '2022-12-09 09:20:48', NULL);
INSERT INTO `permisosrol` VALUES (27, 27, 1, 1, '2022-12-09 09:20:48', NULL);
INSERT INTO `permisosrol` VALUES (28, 28, 1, 1, '2022-12-09 09:20:49', NULL);
INSERT INTO `permisosrol` VALUES (29, 29, 1, 1, '2022-12-09 09:20:50', NULL);
INSERT INTO `permisosrol` VALUES (30, 31, 1, 1, '2022-12-12 22:47:12', '2022-12-12 22:47:12');
INSERT INTO `permisosrol` VALUES (31, 35, 1, 1, '2022-12-12 22:51:34', '2022-12-12 22:51:34');
INSERT INTO `permisosrol` VALUES (32, 30, 1, 1, '2022-12-12 22:47:12', '2022-12-12 22:47:12');
INSERT INTO `permisosrol` VALUES (33, 32, 1, 1, '2022-12-12 22:49:34', '2022-12-12 22:49:34');
INSERT INTO `permisosrol` VALUES (34, 33, 1, 1, '2022-12-12 22:49:35', '2022-12-12 22:49:35');
INSERT INTO `permisosrol` VALUES (35, 37, 1, 1, '2022-12-12 22:50:38', '2022-12-12 22:50:38');
INSERT INTO `permisosrol` VALUES (36, 36, 1, 1, '2022-12-12 22:50:16', '2022-12-12 22:50:16');
INSERT INTO `permisosrol` VALUES (37, 38, 1, 1, '2023-02-01 17:43:26', NULL);
INSERT INTO `permisosrol` VALUES (38, 39, 1, 1, '2023-02-01 17:43:27', NULL);
INSERT INTO `permisosrol` VALUES (39, 40, 1, 1, '2023-02-01 17:43:27', NULL);
INSERT INTO `permisosrol` VALUES (40, 41, 1, 1, '2023-02-01 17:47:40', NULL);
INSERT INTO `permisosrol` VALUES (41, 42, 1, 1, '2023-02-01 21:54:34', NULL);
INSERT INTO `permisosrol` VALUES (42, 43, 1, 1, '2023-02-01 21:54:34', NULL);
INSERT INTO `permisosrol` VALUES (43, 44, 1, 1, '2023-02-01 21:54:35', NULL);
INSERT INTO `permisosrol` VALUES (44, 45, 1, 1, '2023-02-01 21:54:35', NULL);
INSERT INTO `permisosrol` VALUES (45, 46, 1, 1, '2023-02-02 17:23:03', '2023-02-02 17:23:03');

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Administrador', 1, '2022-07-05 09:49:14', NULL);
INSERT INTO `roles` VALUES (2, 'Capturador de Datos', 1, '2022-11-08 16:55:28', '2023-02-01 22:18:40');

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
) ENGINE = InnoDB AUTO_INCREMENT = 383 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sesiones
-- ----------------------------
INSERT INTO `sesiones` VALUES (346, '5s4uc6mfetfi1r5vl7va5gha3o', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzA5MDUzNTcsImV4cCI6MTY3MDk5MTc1NywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.lQXzI0J6mlwfQf_tw9L1yB8ZKI3k5E1tAdwhR8j5_S8', 1670991757, 2, '2022-12-12 22:22:37');
INSERT INTO `sesiones` VALUES (350, '56ed6h5t3peuefkpo32pa3o8ao', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzA5MDY4MTMsImV4cCI6MTY3MDk5MzIxMywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.LvYfsOaK5OOoR2zpHCIVkcVOxfUajjyCx1lv04GUKJk', 1670993213, 2, '2022-12-12 22:46:53');
INSERT INTO `sesiones` VALUES (351, 'ps8dthum2ef92lpab0hspnrda9', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUyMjE0NDgsImV4cCI6MTY3NTMwNzg0OCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.cUzwis9oPqcZefsnr3-drmt0J9otxI7cNc4SzzsELFY', 1675307848, 2, '2023-01-31 21:17:28');
INSERT INTO `sesiones` VALUES (370, 'qpi5740k62qe5n3vqjg9drb2dr', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUyODgzNDAsImV4cCI6MTY3NTM3NDc0MCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.t94h21HvLJB1RSP_pSXCvBHqgDXYw4w3UzEgZKWIl6c', 1675374740, 2, '2023-02-01 15:52:20');
INSERT INTO `sesiones` VALUES (379, 'j3v2pjjq4op2rd92r2vvro0km0', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUzMTI4NzQsImV4cCI6MTY3NTM5OTI3NCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.65wKy3Ac8mUEDFKIdSZ9sqsyYXovqn_LLHUoWgFbIc4', 1675399274, 2, '2023-02-01 22:41:14');
INSERT INTO `sesiones` VALUES (382, 'tvl16kgob0b7sg3nt5d6t2u8sg', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUzNzk2ODIsImV4cCI6MTY3NTQ2NjA4MiwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.romCAwvG5tovAgGB34tQC6pJ2yd89AckfISNalH3tkQ', 1675466082, 2, '2023-02-02 17:14:42');

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
INSERT INTO `usuarios` VALUES (1, 'a@gmail.com', '$2a$07$azybxcagsrp23425rpazyOJ2L2WK7boD6L0yabye19u1I.JqjawKG', '', '', NULL, 1, 1, '2023-02-01 22:34:03', '2023-02-01 22:34:03');
INSERT INTO `usuarios` VALUES (2, 'admin@gmail.com', '$2a$07$azybxcagsrp23425rpazyOq1MTBjNX.BdECR0V6VIz.oseVnxGeRe', '', '', 1, 1, 1, '2023-02-01 22:33:32', '2023-02-01 22:33:32');
INSERT INTO `usuarios` VALUES (3, 'admin12@gmail.com', '$2a$07$azybxcagsrp23425rpazyO2azgVXM9aZRL32LtNjyYeNAj.BGUtne', NULL, NULL, 1, 2, 1, '2023-02-02 17:08:41', NULL);

SET FOREIGN_KEY_CHECKS = 1;
