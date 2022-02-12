SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cmsnews
-- ----------------------------
DROP TABLE IF EXISTS `cmsnews`;
CREATE TABLE `cmsnews`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date` datetime NOT NULL,
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1000 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cmsnews
-- ----------------------------
INSERT INTO `cmsnews` VALUES (1, 'Eventos', 'Apresentação do Servidor', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:48px&quot;&gt;Espa&amp;ccedil;o reservado para a apresenta&amp;ccedil;&amp;atilde;o do servidor.&lt;/span&gt;&lt;/p&gt;\r\n', '2022-01-21 19:30:07', 'Levmud', 0);
INSERT INTO `cmsnews` VALUES (2, 'Notícias', 'Termos de Uso', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:48px&quot;&gt;Espa&amp;ccedil;o reservado&lt;/span&gt;&lt;/p&gt;\r\n', '2022-01-21 19:30:21', 'Levmud', 0);
INSERT INTO `cmsnews` VALUES (3, 'Notícias', 'Políticas de Privacidade', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:48px&quot;&gt;Espa&amp;ccedil;o reservado&lt;/span&gt;&lt;/p&gt;\r\n', '2022-01-22 11:40:54', 'Levmud', 0);
INSERT INTO `cmsnews` VALUES (4, 'Notícias', 'Trabalhe Conosco', '&lt;h1 style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:48px&quot;&gt;Espa&amp;ccedil;o Reservado&lt;/span&gt;&lt;/h1&gt;\r\n', '2022-01-22 11:58:36', 'Levmud', 0);

SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE account ADD web_admin int(11);
ALTER TABLE account ADD register_ip varchar(255);
