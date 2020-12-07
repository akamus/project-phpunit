/*
Navicat MySQL Data Transfer

Source Server         : XAMPP - LOCAL - ROOT
Source Server Version : 100125
Source Host           : localhost:3306
Source Database       : provas

Target Server Type    : MYSQL
Target Server Version : 100125
File Encoding         : 65001

Date: 2020-11-24 09:58:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for prova
-- ----------------------------
DROP TABLE IF EXISTS `prova`;
CREATE TABLE `prova` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `quantidade` int(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for registro
-- ----------------------------
DROP TABLE IF EXISTS `registro`;
CREATE TABLE `registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prova` varchar(255) DEFAULT NULL,
  `disciplina` varchar(255) DEFAULT NULL,
  `assunto` varchar(255) DEFAULT '',
  `quantidade` int(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
