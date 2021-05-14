--
-- Databases - Setup (1.0.0)
--
-- @package Coordinator\Modules\Databases
-- @author  Manuel Zavatta <manuel.zavatta@gmail.com>
-- @link    http://www.coordinator.it
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `databases__datasources`
--

CREATE TABLE IF NOT EXISTS `databases__datasources` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`typology` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
	`connector` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
	`hostname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`database` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`tns` text COLLATE utf8_unicode_ci,
	`queries` text COLLATE utf8_unicode_ci,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `databases__datasources__logs`
--

CREATE TABLE IF NOT EXISTS `databases__datasources__logs` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`fkObject` int(11) unsigned NOT NULL,
	`fkUser` int(11) unsigned DEFAULT NULL,
	`timestamp` int(11) unsigned NOT NULL,
	`alert` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`event` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
	`properties_json` text COLLATE utf8_unicode_ci,
	PRIMARY KEY (`id`),
	KEY `fkObject` (`fkObject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Authorizations
--

INSERT IGNORE INTO `framework__modules__authorizations` (`id`,`fkModule`,`order`) VALUES
('databases-manage','databases',1);

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
