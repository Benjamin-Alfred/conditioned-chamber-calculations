CREATE TABLE `wp_coe_client_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);


CREATE TABLE `wp_coe_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);


CREATE TABLE `wp_coe_conditioned_chamber_calculation_readings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conditioned_chamber_calculation_id` int(10) unsigned NOT NULL,
  `reading_time` smallint(6) NOT NULL,
  `reading_a` decimal(10,5) NOT NULL,
  `reading_b` decimal(10,5) NOT NULL,
  `reading_c` decimal(10,5) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `wp_coe_conditioned_chamber_calculations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL DEFAULT '1',
  `client_contact_id` int(10) unsigned NOT NULL DEFAULT '1',
  `submission_number` varchar(50) NOT NULL,
  `standard_test_equipment_sticker_number` varchar(60) DEFAULT NULL,
  `certificate_number` varchar(60) DEFAULT NULL,
  `standard_test_equipment_certificate_number` varchar(60) DEFAULT NULL,
  `date_performed` date NOT NULL,
  `manufacturer_id` int(10) unsigned NOT NULL,
  `standard_test_equipment_manufacturer_id` int(10) unsigned NOT NULL DEFAULT '1',
  `equipment_id` int(10) unsigned NOT NULL,
  `standard_test_equipment_id` int(10) unsigned NOT NULL DEFAULT '1',
  `equipment_model` varchar(60) DEFAULT NULL,
  `standard_test_equipment_model` varchar(60) DEFAULT NULL,
  `equipment_serial_number` varchar(60) NOT NULL,
  `standard_test_equipment_serial_number` varchar(60) DEFAULT NULL,
  `expected_temperature` decimal(8,5) NOT NULL DEFAULT '0.00000',
  `environmental_temperature` decimal(8,5) NOT NULL DEFAULT '0.00000',
  `environmental_humidity` decimal(8,5) unsigned NOT NULL DEFAULT '0.00000',
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `verified_by` int(10) unsigned DEFAULT NULL,
  `approved_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `uncertainity` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `result` varchar(8) DEFAULT "PENDING",
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

CREATE TABLE `wp_coe_standard_test_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

