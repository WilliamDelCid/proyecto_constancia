/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : constancia

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 05/02/2023 17:42:45
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
  `url` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `token_unico` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `estado` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_tipo_participacion`(`id_tipo_participacion`) USING BTREE,
  INDEX `fk_id_evento`(`id_evento`) USING BTREE,
  CONSTRAINT `fk_id_evento` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_tipo_participacion` FOREIGN KEY (`id_tipo_participacion`) REFERENCES `participacion` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of formularios
-- ----------------------------
INSERT INTO `formularios` VALUES (42, 'Dato editar', 'Dato editar 2', 17, NULL, 'esta', '01, 02, 03, 04 de Febrero de 2023', 'aa', '2023-02-04', '2023-02-04 22:04:09', '2023-02-04 22:04:09', 'data:image/png;base64,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', 'd781502292d68c2cd4d3025f', 1);

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
INSERT INTO `modulos` VALUES (6, 'Empleados', 1, '2022-11-29 13:47:30', NULL);
INSERT INTO `modulos` VALUES (7, 'Cargos', 1, '2022-11-29 13:47:36', NULL);
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
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of participacion
-- ----------------------------
INSERT INTO `participacion` VALUES (12, 'CONFERENCISTA', 1, '2023-02-01 22:00:24', NULL);
INSERT INTO `participacion` VALUES (17, 'Acti', 1, '2023-02-04 22:15:12', '2023-02-04 22:15:12');

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
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `permisos` VALUES (14, 'Ver Empleado', 6, '2022-11-29 13:47:58', NULL);
INSERT INTO `permisos` VALUES (15, 'Crear Empleado', 6, '2022-11-29 13:48:03', NULL);
INSERT INTO `permisos` VALUES (16, 'Editar Empleado', 6, '2022-11-29 13:48:10', NULL);
INSERT INTO `permisos` VALUES (17, 'Dar de baja Empleado', 6, '2022-11-29 13:48:17', NULL);
INSERT INTO `permisos` VALUES (18, 'Ver Cargo', 7, '2022-11-29 13:48:30', NULL);
INSERT INTO `permisos` VALUES (19, 'Crear Cargo', 7, '2022-11-29 13:48:35', NULL);
INSERT INTO `permisos` VALUES (20, 'Editar Cargo', 7, '2022-11-29 13:48:40', NULL);
INSERT INTO `permisos` VALUES (21, 'Dar de baja Cargo', 7, '2022-11-29 13:48:50', NULL);
INSERT INTO `permisos` VALUES (38, 'Ver Participacion', 14, '2023-02-01 17:46:18', '2023-02-01 17:46:18');
INSERT INTO `permisos` VALUES (39, 'Editar Participacion', 14, '2023-02-01 17:42:46', NULL);
INSERT INTO `permisos` VALUES (40, 'Dar de baja Participacion', 14, '2023-02-01 17:43:19', NULL);
INSERT INTO `permisos` VALUES (41, 'Crear Participacion', 14, '2023-02-01 17:47:24', NULL);
INSERT INTO `permisos` VALUES (42, 'Ver Evento', 15, '2023-02-01 21:36:34', '2023-02-01 21:36:34');
INSERT INTO `permisos` VALUES (43, 'Crear Evento', 15, '2023-02-01 21:36:30', '2023-02-01 21:36:30');
INSERT INTO `permisos` VALUES (44, 'Editar Evento', 15, '2023-02-01 21:36:26', NULL);
INSERT INTO `permisos` VALUES (45, 'Dar de baja Evento', 15, '2023-02-01 21:36:54', '2023-02-01 21:36:54');
INSERT INTO `permisos` VALUES (46, 'Crear Formulario', 16, '2023-02-02 14:18:35', NULL);
INSERT INTO `permisos` VALUES (47, 'Ver Formulario', 16, '2023-02-02 22:23:13', NULL);
INSERT INTO `permisos` VALUES (48, 'Editar Formulario', 16, '2023-02-02 22:23:20', NULL);
INSERT INTO `permisos` VALUES (49, 'Dar de baja Formulario', 16, '2023-02-02 22:23:30', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `permisosrol` VALUES (14, 14, 1, 1, '2022-11-29 13:48:58', NULL);
INSERT INTO `permisosrol` VALUES (15, 15, 1, 1, '2022-11-29 13:48:59', NULL);
INSERT INTO `permisosrol` VALUES (16, 16, 1, 1, '2022-11-29 13:48:59', NULL);
INSERT INTO `permisosrol` VALUES (17, 17, 1, 1, '2022-11-29 13:49:00', NULL);
INSERT INTO `permisosrol` VALUES (18, 18, 1, 1, '2022-11-29 13:49:05', NULL);
INSERT INTO `permisosrol` VALUES (19, 19, 1, 1, '2022-11-29 13:49:05', NULL);
INSERT INTO `permisosrol` VALUES (20, 20, 1, 1, '2022-11-29 13:49:06', NULL);
INSERT INTO `permisosrol` VALUES (21, 21, 1, 1, '2022-11-29 13:49:06', NULL);
INSERT INTO `permisosrol` VALUES (37, 38, 1, 1, '2023-02-01 17:43:26', NULL);
INSERT INTO `permisosrol` VALUES (38, 39, 1, 1, '2023-02-01 17:43:27', NULL);
INSERT INTO `permisosrol` VALUES (39, 40, 1, 1, '2023-02-01 17:43:27', NULL);
INSERT INTO `permisosrol` VALUES (40, 41, 1, 1, '2023-02-01 17:47:40', NULL);
INSERT INTO `permisosrol` VALUES (41, 42, 1, 1, '2023-02-01 21:54:34', NULL);
INSERT INTO `permisosrol` VALUES (42, 43, 1, 1, '2023-02-01 21:54:34', NULL);
INSERT INTO `permisosrol` VALUES (43, 44, 1, 1, '2023-02-01 21:54:35', NULL);
INSERT INTO `permisosrol` VALUES (44, 45, 1, 1, '2023-02-01 21:54:35', NULL);
INSERT INTO `permisosrol` VALUES (45, 46, 1, 1, '2023-02-02 17:23:03', '2023-02-02 17:23:03');
INSERT INTO `permisosrol` VALUES (46, 47, 1, 1, '2023-02-02 22:23:56', NULL);
INSERT INTO `permisosrol` VALUES (47, 48, 1, 1, '2023-02-02 22:23:57', NULL);
INSERT INTO `permisosrol` VALUES (48, 49, 1, 1, '2023-02-02 22:23:57', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 396 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sesiones
-- ----------------------------
INSERT INTO `sesiones` VALUES (346, '5s4uc6mfetfi1r5vl7va5gha3o', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzA5MDUzNTcsImV4cCI6MTY3MDk5MTc1NywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.lQXzI0J6mlwfQf_tw9L1yB8ZKI3k5E1tAdwhR8j5_S8', 1670991757, 2, '2022-12-12 22:22:37');
INSERT INTO `sesiones` VALUES (350, '56ed6h5t3peuefkpo32pa3o8ao', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzA5MDY4MTMsImV4cCI6MTY3MDk5MzIxMywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.LvYfsOaK5OOoR2zpHCIVkcVOxfUajjyCx1lv04GUKJk', 1670993213, 2, '2022-12-12 22:46:53');
INSERT INTO `sesiones` VALUES (351, 'ps8dthum2ef92lpab0hspnrda9', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUyMjE0NDgsImV4cCI6MTY3NTMwNzg0OCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.cUzwis9oPqcZefsnr3-drmt0J9otxI7cNc4SzzsELFY', 1675307848, 2, '2023-01-31 21:17:28');
INSERT INTO `sesiones` VALUES (370, 'qpi5740k62qe5n3vqjg9drb2dr', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUyODgzNDAsImV4cCI6MTY3NTM3NDc0MCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.t94h21HvLJB1RSP_pSXCvBHqgDXYw4w3UzEgZKWIl6c', 1675374740, 2, '2023-02-01 15:52:20');
INSERT INTO `sesiones` VALUES (379, 'j3v2pjjq4op2rd92r2vvro0km0', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUzMTI4NzQsImV4cCI6MTY3NTM5OTI3NCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.65wKy3Ac8mUEDFKIdSZ9sqsyYXovqn_LLHUoWgFbIc4', 1675399274, 2, '2023-02-01 22:41:14');
INSERT INTO `sesiones` VALUES (383, 'tvl16kgob0b7sg3nt5d6t2u8sg', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzUzOTM5MTUsImV4cCI6MTY3NTQ4MDMxNSwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.3nNRQomlAfYIJ-LTaYeqnzWImAc4i5h9rrqvKPb69iA', 1675480315, 2, '2023-02-02 21:11:55');
INSERT INTO `sesiones` VALUES (385, 'qaspe3fgitchvv5nmna9fq5qc2', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzU0MzgyNDEsImV4cCI6MTY3NTUyNDY0MSwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.aGKLrL2O3VO1O1fajpe07s1hQpPQ4WG-9sNlgWEnR0c', 1675524641, 2, '2023-02-03 09:30:41');
INSERT INTO `sesiones` VALUES (386, 'qaspe3fgitchvv5nmna9fq5qc2', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzU0MzgyNjMsImV4cCI6MTY3NTUyNDY2MywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.WP26ZZcejbgoOppmwFhhs0VgZRF9hzWajZjYtHeyULU', 1675524663, 2, '2023-02-03 09:31:03');
INSERT INTO `sesiones` VALUES (388, 'fusj7t2u2recp3i4n6p2vg6tf6', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzU0NjI2NDMsImV4cCI6MTY3NTU0OTA0MywiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.N7ChIQ6XYF35ZNmHOeohv6QutslMT7c-MK-zgkSDILE', 1675549043, 2, '2023-02-03 16:17:23');
INSERT INTO `sesiones` VALUES (389, 'ut077fnqc06o05vgiu9hu3u2ou', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzU1NDc0NjQsImV4cCI6MTY3NTYzMzg2NCwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.iaLK8Y_MuXtXbRXF-TEdF17naOkVXlM8X9dLLc6iySY', 1675633864, 2, '2023-02-04 15:51:04');
INSERT INTO `sesiones` VALUES (395, 'dm0sds3ej1t5cd10b2l581hjgb', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzU2NDAyMzIsImV4cCI6MTY3NTcyNjYzMiwiZGF0YSI6eyJpZCI6IjIiLCJlbWFpbCI6ImFkbWluQGdtYWlsLmNvbSJ9fQ.2cBcAs-KkTEj9mQdnZHjhU11hoh9tAQ63k-YlZjQxmw', 1675726632, 2, '2023-02-05 17:37:12');

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
