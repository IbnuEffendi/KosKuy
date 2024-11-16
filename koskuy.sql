/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - koskuy_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`koskuy_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `koskuy_db`;

/*Table structure for table `current_rentals` */

DROP TABLE IF EXISTS `current_rentals`;

CREATE TABLE `current_rentals` (
  `rental_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `kos_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','completed','cancelled') NOT NULL,
  PRIMARY KEY (`rental_id`),
  KEY `user_id` (`user_id`),
  KEY `kos_id` (`kos_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `current_rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `current_rentals_ibfk_2` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`kos_id`),
  CONSTRAINT `current_rentals_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `current_rentals` */

/*Table structure for table `facilities` */

DROP TABLE IF EXISTS `facilities`;

CREATE TABLE `facilities` (
  `facility_id` int(11) NOT NULL AUTO_INCREMENT,
  `facility_name` varchar(100) NOT NULL,
  PRIMARY KEY (`facility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `facilities` */

/*Table structure for table `kos` */

DROP TABLE IF EXISTS `kos`;

CREATE TABLE `kos` (
  `kos_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kos` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `preferensi` int(11) DEFAULT NULL,
  PRIMARY KEY (`kos_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `kos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kos` */

insert  into `kos`(`kos_id`,`nama_kos`,`alamat`,`harga`,`deskripsi`,`user_id`,`preferensi`) values 
(25,'Kos Amanah','Jl. Merdeka No. 45, Denpasar',1500000.00,'Kos nyaman dengan fasilitas lengkap',4,1),
(26,'Kos Sejahtera','Jl. Anggrek No. 22, Kuta',1200000.00,'Kos strategis dekat dengan pusat kota',4,2),
(27,'Kos Mapan','Jl. Kenanga No. 8, Ubud',1000000.00,'Kos murah dengan lingkungan yang asri',4,1),
(28,'Kos Harmoni','Jl. Melati No. 10, Sanur',1800000.00,'Kos eksklusif dengan keamanan 24 jam',4,3),
(29,'Kos Eka','Jl. Nangka No.66, Denpasar',1300000.00,'Kos terjangkau dengan view taman',4,1);

/*Table structure for table `kos_facilities` */

DROP TABLE IF EXISTS `kos_facilities`;

CREATE TABLE `kos_facilities` (
  `kos_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  PRIMARY KEY (`kos_id`,`facility_id`),
  KEY `facility_id` (`facility_id`),
  CONSTRAINT `kos_facilities_ibfk_1` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`kos_id`),
  CONSTRAINT `kos_facilities_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`facility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kos_facilities` */

/*Table structure for table `kos_images` */

DROP TABLE IF EXISTS `kos_images`;

CREATE TABLE `kos_images` (
  `kos_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `kos_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`kos_image_id`),
  KEY `kos_id` (`kos_id`),
  CONSTRAINT `kos_images_ibfk_1` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`kos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kos_images` */

insert  into `kos_images`(`kos_image_id`,`kos_id`,`image_url`) values 
(17,25,'kos_1_1.jpg'),
(18,25,'kos_1_2.jpg'),
(19,26,'kos_2_1.jpg'),
(20,26,'kos_2_2.jpg'),
(21,27,'kos_3_1.jpg'),
(22,27,'kos_3_2.jpg'),
(23,28,'kos_4_1.jpg'),
(24,28,'kos_4_2.jpg'),
(25,29,'kos_5_1.jpg'),
(26,29,'kos_5_2.jpg');

/*Table structure for table `rent_payments` */

DROP TABLE IF EXISTS `rent_payments`;

CREATE TABLE `rent_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','verified','failed') DEFAULT 'pending',
  PRIMARY KEY (`payment_id`),
  KEY `request_id` (`request_id`),
  CONSTRAINT `rent_payments_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `rent_requests` (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rent_payments` */

/*Table structure for table `rent_requests` */

DROP TABLE IF EXISTS `rent_requests`;

CREATE TABLE `rent_requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `kos_id` int(11) DEFAULT NULL,
  `request_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`request_id`),
  KEY `user_id` (`user_id`),
  KEY `kos_id` (`kos_id`),
  CONSTRAINT `rent_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `rent_requests_ibfk_2` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`kos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rent_requests` */

/*Table structure for table `rooms` */

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `kos_id` int(11) DEFAULT NULL,
  `room_number` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `kos_id` (`kos_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`kos_id`) REFERENCES `kos` (`kos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rooms` */

/*Table structure for table `user_profiles` */

DROP TABLE IF EXISTS `user_profiles`;

CREATE TABLE `user_profiles` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `kota_asal` varchar(100) DEFAULT NULL,
  `status_menikah` enum('menikah','belum menikah') NOT NULL,
  PRIMARY KEY (`profile_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_profiles` */

insert  into `user_profiles`(`profile_id`,`user_id`,`nama`,`alamat`,`no_telepon`,`jenis_kelamin`,`tanggal_lahir`,`pekerjaan`,`kota_asal`,`status_menikah`) values 
(1,1,'Andi Setiawan ','Jl. Diponegoro No. 15, Denpasar ','081234567890','pria','1990-10-10','Software Developer ','Makassar','menikah'),
(2,6,'Budi Santoso','Jl. Sudirman No. 30, Kuta','081345678901','pria','1988-04-20','Desainer Grafis','Surabaya','menikah'),
(3,3,'Citra Lestari','Jl. Kartini No. 20, Ubud','081456789012','pria','1992-07-25','Guru','Bandung','belum menikah'),
(4,4,'Dewi Maharani','Jl. Gatot Subroto No. 25, Sanur','081567890123','pria','1985-11-30','Dokter','Yogyakarta','menikah'),
(5,5,'Eko Prasetyo','Jl. Imam Bonjol No. 10, Legian','081678901234','pria','1995-03-10','Pengusaha','Bali','belum menikah'),
(6,NULL,'User Ganteng','Jl. Pondok Pengalasan No.33','081292819189','pria','2000-11-11','Mahasiswa','Denpasar','belum menikah');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','owner') NOT NULL,
  `fullname` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`email`,`password`,`role`,`fullname`) values 
(1,'user@gmail.com','$2y$10$ErNZb0T5UCDY/qNxXQfS0eJ7SYFlkaVcDFxk9tG21bp4Zsq2dOIt6','owner','User Dummy'),
(3,'admin@gmail.com','$2y$10$YPM.gLUW9hL8cPZGV7qb3uIaYAgenX0al8/m.EbC5WqGHP6rXsDeG','admin','Admin Dummy'),
(4,'owner@gmail.com','$2y$10$ei.bO85kBm44/IHANsCQ5O5qCsZrHFIR/KPnqW6KSSMfnPxhOkTL2','owner','Owner Dummy'),
(5,'effendi.ibnu72@gmail.com','$2y$10$QAN7uTQOa6/ViN10j9MVYOjYhodY7I4n6Gx57pZmKUA7bDtJzasGe','owner','Ibnu Effendi'),
(6,'ekadarma@gmail.com','$2y$10$o8W9TUEH6HHM/WRRWdJvMea.gF5nPKdjso3PDSGYDSnQJNURtDZFS','owner','Eka Darma'),
(7,'tes@gmail.com','$2y$10$aYVAvpMzT3yaXASzXxl2Dum70xirox3NJtKWKEpcbJg7aFZ5ys.ua','user','tes'),
(8,'tes12@gmail.com','$2y$10$.MlZd5BOh0C.cx/Ew1PLQ.Dzy0ZQRNJTfrDsLmAM/W5c0t.GBBpBW','user','tes12'),
(12,'tes123@gmail.com','$2y$10$BWtvbAcyCsTQd64Rk6gU4eRLs0jsKF4CnY.uOjaujQdyaKI4fTopW','owner','tes');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
