
-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Categories
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_categories` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL ,
	`alias` VARCHAR(255) ,
	`sub_category` BIGINT(20) UNSIGNED ,
	`image` VARCHAR(255) ,
	`description` TEXT ,
	`ordering` INT(11) ,
	`published` TINYINT(11) ,
	`created_by` BIGINT(20) UNSIGNED ,
	`modified_by` BIGINT(20) UNSIGNED ,
	`creation_date` DATETIME ,
	`modification_date` DATETIME ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Products
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_products` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL ,
	`alias` VARCHAR(255) ,
	`category_id` BIGINT(20) UNSIGNED NOT NULL ,
	`project_id` BIGINT(20) UNSIGNED ,
	`types` VARCHAR(255) ,
	`who` VARCHAR(255) NOT NULL ,
	`location_id` BIGINT(20) UNSIGNED NOT NULL ,
	`gallery` TEXT NOT NULL ,
	`price` INT(11) NOT NULL ,
	`bedrooms` VARCHAR(255) NOT NULL ,
	`description` TEXT ,
	`address` VARCHAR(255) ,
	`acreage` INT(11) NOT NULL ,
	`behind` INT(11) ,
	`direction` VARCHAR(255) ,
	`legal_documents` VARCHAR(255) ,
	`characteristics` VARCHAR(255) ,
	`shipping_payment` TEXT ,
	`contact_number` VARCHAR(255) ,
	`contact_name` VARCHAR(255) NOT NULL ,
	`contact_email` VARCHAR(255) NOT NULL ,
	`contact_address` VARCHAR(255) ,
	`ordering` INT(11) ,
	`published` TINYINT(11) ,
	`created_by` BIGINT(20) UNSIGNED ,
	`modified_by` BIGINT(20) UNSIGNED ,
	`creation_date` DATETIME ,
	`modification_date` DATETIME ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Projects
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_projects` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL ,
	`alias` VARCHAR(255) ,
	`gallery` TEXT NOT NULL ,
	`type_id` BIGINT(20) UNSIGNED ,
	`location_id` BIGINT(20) UNSIGNED ,
	`address` VARCHAR(255) NOT NULL ,
	`price_min` INT(11) NOT NULL ,
	`price_max` INT(11) NOT NULL ,
	`handing_over` DATE NOT NULL ,
	`investor` VARCHAR(255) NOT NULL ,
	`description` TEXT ,
	`total_area` INT(11) ,
	`utility_id` BIGINT(20) UNSIGNED ,
	`model_house` TEXT ,
	`construction_progress` TEXT ,
	`ordering` INT(11) ,
	`published` TINYINT(11) ,
	`modified_by` BIGINT(20) UNSIGNED ,
	`created_by` BIGINT(20) UNSIGNED ,
	`creation_date` DATETIME ,
	`modification_date` DATETIME ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Types
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_types` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL ,
	`ordering` INT(11) ,
	`published` TINYINT(11) ,
	`creation_date` DATETIME ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Locations
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_locations` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL ,
	`sub_location` BIGINT(20) UNSIGNED ,
	`ordering` INT(11) ,
	`published` TINYINT(11) ,
	`creation_date` DATETIME ,
	`modification_date` DATETIME ,
	`created_by` BIGINT(20) UNSIGNED ,
	`modified_by` BIGINT(20) UNSIGNED ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Utilities
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_utilities` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`title` VARCHAR(255) NOT NULL ,
	`icon` VARCHAR(255) ,
	`ordering` INT(11) ,
	`published` TINYINT(11) ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : Email Templates
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -
CREATE TABLE IF NOT EXISTS `#__bds_emailtemplates` (
	`id` BIGINT(20) UNSIGNED NOT NULL auto_increment,
	`slug_name` VARCHAR(255) ,
	`subject` VARCHAR(255) ,
	`avail_attribute` VARCHAR(255) ,
	`content` TEXT ,
	`created_by` BIGINT(20) UNSIGNED ,
	`modified_by` BIGINT(20) UNSIGNED ,
	`creation_date` DATETIME ,
	`modification_date` DATETIME ,

	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

