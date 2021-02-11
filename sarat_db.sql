/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.13-MariaDB : Database - sarat_project
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sarat_project` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `sarat_project`;

/*Table structure for table `request_list` */

DROP TABLE IF EXISTS `request_list`;

CREATE TABLE `request_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `req_type` varchar(20) DEFAULT NULL,
  `req_desc` varchar(50) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `pin_code` int(11) DEFAULT NULL,
  `country_code` int(11) DEFAULT NULL,
  `phone_no` bigint(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `record_status` smallint(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `request_list` */

/*Table structure for table `user_master` */

DROP TABLE IF EXISTS `user_master`;

CREATE TABLE `user_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_code` bigint(20) NOT NULL,
  `email_id` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `record_status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user_master` */

/*Table structure for table `user_token` */

DROP TABLE IF EXISTS `user_token`;

CREATE TABLE `user_token` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_code` bigint(20) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `record_status` smallint(6) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_token` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
