-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: cargo
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bdi`
--

DROP TABLE IF EXISTS `bdi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bdi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bdi_code_id` int(10) unsigned NOT NULL,
  `ship_id` int(10) unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bdi_bdi_code_id_foreign` (`bdi_code_id`),
  KEY `bdi_ship_id_foreign` (`ship_id`),
  CONSTRAINT `bdi_bdi_code_id_foreign` FOREIGN KEY (`bdi_code_id`) REFERENCES `bdi_codes` (`id`),
  CONSTRAINT `bdi_ship_id_foreign` FOREIGN KEY (`ship_id`) REFERENCES `ships` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bdi_code`
--

DROP TABLE IF EXISTS `bdi_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bdi_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bdi_codes`
--

DROP TABLE IF EXISTS `bdi_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bdi_codes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `loading_port` int(10) unsigned NOT NULL,
  `discharging_port` int(10) unsigned NOT NULL,
  `laycan_first_day` date NOT NULL,
  `laycan_last_day` date DEFAULT NULL,
  `cargo_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stowage_factor` int(11) NOT NULL,
  `sf_unit` int(10) unsigned NOT NULL,
  `ship_specialization_id` int(10) unsigned NOT NULL,
  `quantity_measurement_id` int(10) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `loading_rate_type` int(10) unsigned NOT NULL,
  `loading_rate` int(11) NOT NULL,
  `discharging_rate_type` int(10) unsigned NOT NULL,
  `discharging_rate` int(11) NOT NULL,
  `freight_idea_measurement_id` int(11) unsigned DEFAULT NULL,
  `freight_idea` int(11) DEFAULT NULL,
  `extra_condition` text COLLATE utf8mb4_unicode_ci,
  `comission` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cargos_customer_id_foreign` (`customer_id`),
  KEY `cargos_loading_port_foreign` (`loading_port`),
  KEY `cargos_discharging_port_foreign` (`discharging_port`),
  KEY `cargos_sf_unit_foreign` (`sf_unit`),
  KEY `cargos_ship_specialization_id_foreign` (`ship_specialization_id`),
  KEY `cargos_quantity_measurement_id_foreign` (`quantity_measurement_id`),
  KEY `cargos_loading_rate_type_foreign` (`loading_rate_type`),
  KEY `cargos_discharging_rate_type_foreign` (`discharging_rate_type`),
  KEY `cargos_freight_idea_measurement_id_foreign` (`freight_idea_measurement_id`),
  CONSTRAINT `cargos_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `cargos_discharging_port_foreign` FOREIGN KEY (`discharging_port`) REFERENCES `ports` (`id`),
  CONSTRAINT `cargos_discharging_rate_type_foreign` FOREIGN KEY (`discharging_rate_type`) REFERENCES `loading_discharging_rate_type` (`id`),
  CONSTRAINT `cargos_freight_idea_measurement_id_foreign` FOREIGN KEY (`freight_idea_measurement_id`) REFERENCES `freight_idea_measurements` (`id`),
  CONSTRAINT `cargos_loading_port_foreign` FOREIGN KEY (`loading_port`) REFERENCES `ports` (`id`),
  CONSTRAINT `cargos_loading_rate_type_foreign` FOREIGN KEY (`loading_rate_type`) REFERENCES `loading_discharging_rate_type` (`id`),
  CONSTRAINT `cargos_quantity_measurement_id_foreign` FOREIGN KEY (`quantity_measurement_id`) REFERENCES `quantity_measurements` (`id`),
  CONSTRAINT `cargos_sf_unit_foreign` FOREIGN KEY (`sf_unit`) REFERENCES `stowage_factor_units` (`id`),
  CONSTRAINT `cargos_ship_specialization_id_foreign` FOREIGN KEY (`ship_specialization_id`) REFERENCES `ship_specializations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `freight_idea_measurements`
--

DROP TABLE IF EXISTS `freight_idea_measurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `freight_idea_measurements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `freight_idea_measurements_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fuel_prices`
--

DROP TABLE IF EXISTS `fuel_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fuel_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fuel_type_id` int(10) unsigned NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fuel_prices_fuel_type_id_foreign` (`fuel_type_id`),
  CONSTRAINT `fuel_prices_fuel_type_id_foreign` FOREIGN KEY (`fuel_type_id`) REFERENCES `fuel_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fuel_types`
--

DROP TABLE IF EXISTS `fuel_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fuel_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loading_discharging_rate_type`
--

DROP TABLE IF EXISTS `loading_discharging_rate_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loading_discharging_rate_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loading_discharging_rate_type_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ports`
--

DROP TABLE IF EXISTS `ports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` int(11) DEFAULT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `max_laden_draft` decimal(8,2) DEFAULT NULL,
  `latitude` decimal(8,2) NOT NULL,
  `longitude` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ports_name_unique` (`name`),
  KEY `ports_region_foreign` (`region_id`),
  CONSTRAINT `ports_region_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  CONSTRAINT `ports_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=414 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quantity_measurements`
--

DROP TABLE IF EXISTS `quantity_measurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quantity_measurements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quantity_measurements_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area1` int(10) unsigned NOT NULL,
  `area2` int(10) unsigned DEFAULT NULL,
  `area3` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `routes_area1_foreign` (`area1`),
  KEY `routes_area2_foreign` (`area2`),
  KEY `routes_area3_foreign` (`area3`),
  CONSTRAINT `routes_area1_foreign` FOREIGN KEY (`area1`) REFERENCES `regions` (`id`),
  CONSTRAINT `routes_area2_foreign` FOREIGN KEY (`area2`) REFERENCES `regions` (`id`),
  CONSTRAINT `routes_area3_foreign` FOREIGN KEY (`area3`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_positions`
--

DROP TABLE IF EXISTS `ship_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_positions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ship_id` int(10) unsigned NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `date_of_opening` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ship_positions_ship_id_foreign` (`ship_id`),
  KEY `ship_positions_region_id_foreign` (`region_id`),
  KEY `ship_positions_port_id_foreign` (`port_id`),
  CONSTRAINT `ship_positions_port_id_foreign` FOREIGN KEY (`port_id`) REFERENCES `ports` (`id`),
  CONSTRAINT `ship_positions_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  CONSTRAINT `ship_positions_ship_id_foreign` FOREIGN KEY (`ship_id`) REFERENCES `ships` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_specializations`
--

DROP TABLE IF EXISTS `ship_specializations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_specializations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ship_specializations_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_types`
--

DROP TABLE IF EXISTS `ship_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ship_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ships`
--

DROP TABLE IF EXISTS `ships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_of_build` date NOT NULL,
  `dwcc` int(11) NOT NULL,
  `max_holds_capacity` decimal(8,2) NOT NULL,
  `ballast_draft` decimal(8,2) NOT NULL,
  `max_laden_draft` decimal(8,2) NOT NULL,
  `speed_laden` decimal(8,2) NOT NULL,
  `speed_ballast` decimal(8,2) NOT NULL,
  `fuel_type_id` int(10) unsigned NOT NULL,
  `fuel_consumption_at_sea` decimal(8,2) DEFAULT NULL,
  `fuel_consumption_in_port` decimal(8,2) DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ship_type_id` int(10) unsigned NOT NULL,
  `ship_specialization_id` int(10) unsigned NOT NULL,
  `gear_onboard` text COLLATE utf8mb4_unicode_ci,
  `additional_information` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ships_imo_unique` (`imo`),
  KEY `ships_fuel_type_id_foreign` (`fuel_type_id`),
  KEY `ships_ship_type_id_foreign` (`ship_type_id`),
  KEY `ships_ship_specialization_id_foreign` (`ship_specialization_id`),
  CONSTRAINT `ships_fuel_type_id_foreign` FOREIGN KEY (`fuel_type_id`) REFERENCES `fuel_types` (`id`),
  CONSTRAINT `ships_ship_specialization_id_foreign` FOREIGN KEY (`ship_specialization_id`) REFERENCES `ship_specializations` (`id`),
  CONSTRAINT `ships_ship_type_id_foreign` FOREIGN KEY (`ship_type_id`) REFERENCES `ship_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stowage_factor_units`
--

DROP TABLE IF EXISTS `stowage_factor_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stowage_factor_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stowage_factor_units_unit_unique` (`unit`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-06 22:08:58
