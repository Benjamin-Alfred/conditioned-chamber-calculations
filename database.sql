CREATE TABLE `wp_coe_conditioned_chamber_calculation_readings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conditioned_chamber_calculation_id` int(10) unsigned NOT NULL,
  `reading_time` smallint(6) NOT NULL,
  `reading_a` smallint(6) NOT NULL,
  `reading_b` smallint(6) NOT NULL,
  `reading_c` smallint(6) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `wp_coe_conditioned_chamber_calculations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(150) NOT NULL,
  `submission_number` varchar(50) NOT NULL,
  `certificate_number` varchar(60) DEFAULT NULL,
  `date_performed` date NOT NULL,
  `manufacturer_id` int(10) unsigned NOT NULL,
  `equipment_id` int(10) unsigned NOT NULL,
  `equipment_model` varchar(60) DEFAULT NULL,
  `equipment_serial_number` varchar(60) NOT NULL,
  `expected_temperature` smallint(6) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `uncertainity` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `wp_coe_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

CREATE TABLE `wp_coe_manufacturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

