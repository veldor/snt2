/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 5.7.22-log : Database - cottage2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cottage2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `cottage2`;

/*Table structure for table `additional_cottages` */

DROP TABLE IF EXISTS `additional_cottages`;

CREATE TABLE `additional_cottages` (
  `masterId` int(10) unsigned NOT NULL,
  `cottageSquare` int(4) unsigned NOT NULL,
  `isPower` tinyint(1) DEFAULT '0',
  `powerPayFor` varchar(10) DEFAULT NULL,
  `currentPowerData` int(10) DEFAULT NULL,
  `powerDebt` float DEFAULT NULL,
  `isMembership` tinyint(1) DEFAULT '0',
  `membershipPayFor` varchar(10) DEFAULT NULL,
  `isTarget` tinyint(1) DEFAULT '0',
  `targetDebt` float DEFAULT NULL,
  `targetPaysDuty` longtext,
  `individualTariff` tinyint(1) DEFAULT NULL,
  `individualTariffRates` longtext,
  `cottageOwnerPersonals` varchar(200) DEFAULT NULL COMMENT 'Имя владельца части участка',
  `cottageOwnerPhone` char(18) DEFAULT NULL COMMENT 'Телефон владельца части участка',
  `cottageOwnerEmail` varchar(200) DEFAULT NULL COMMENT 'Адрес электронной почты владельца участка',
  `hasDifferentOwner` tinyint(1) DEFAULT '0',
  `cottageOwnerAddress` text,
  `singleDebt` float DEFAULT '0',
  `deposit` float DEFAULT '0',
  `cottageRegistrationInformation` text COMMENT 'Данные кадастрового учёта',
  `partialPayedPower` text COMMENT 'Частично оплаченное электричество',
  `partialPayedMembership` text COMMENT 'Частично оплаченный членский взнос',
  `singlePaysDuty` text COMMENT 'Разовые платежи',
  `cottageOwnerDescription` text COMMENT 'Дополнительная информация о владельце',
  `cottageContacterPersonals` varchar(200) DEFAULT NULL,
  `cottageContacterPhone` char(18) DEFAULT NULL,
  `cottageContacterEmail` varchar(200) DEFAULT NULL,
  `passportData` text,
  `cottageRightsData` text,
  `bill_payers` text,
  `cottageHaveRights` tinyint(1) DEFAULT NULL,
  `cottageRegisterData` text,
  PRIMARY KEY (`masterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `additional_months_power` */

DROP TABLE IF EXISTS `additional_months_power`;

CREATE TABLE `additional_months_power` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(5) unsigned NOT NULL,
  `month` varchar(20) NOT NULL,
  `fillingDate` int(20) unsigned NOT NULL,
  `oldPowerData` int(10) unsigned NOT NULL,
  `newPowerData` int(10) unsigned NOT NULL,
  `searchTimestamp` int(20) unsigned NOT NULL,
  `payed` enum('yes','no') DEFAULT 'no',
  `difference` int(10) unsigned DEFAULT '0',
  `totalPay` float unsigned DEFAULT '0',
  `inLimitSumm` int(10) unsigned DEFAULT '0',
  `overLimitSumm` int(10) unsigned DEFAULT '0',
  `inLimitPay` float unsigned DEFAULT '0',
  `overLimitPay` float unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueCottageAndMonth` (`cottageNumber`,`month`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Table structure for table `additional_payed_membership` */

DROP TABLE IF EXISTS `additional_payed_membership`;

CREATE TABLE `additional_payed_membership` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageId` int(10) unsigned NOT NULL,
  `billId` int(10) unsigned NOT NULL,
  `quarter` varchar(10) NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Table structure for table `additional_payed_power` */

DROP TABLE IF EXISTS `additional_payed_power`;

CREATE TABLE `additional_payed_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `month` varchar(10) NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `additional_payed_single` */

DROP TABLE IF EXISTS `additional_payed_single`;

CREATE TABLE `additional_payed_single` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `time` int(20) unsigned NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`billId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `additional_payed_target` */

DROP TABLE IF EXISTS `additional_payed_target`;

CREATE TABLE `additional_payed_target` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `year` int(4) unsigned NOT NULL,
  `summ` float unsigned DEFAULT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `balance` */

DROP TABLE IF EXISTS `balance`;

CREATE TABLE `balance` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `month` varchar(10) NOT NULL,
  `cash_summ` float unsigned NOT NULL,
  `cashless_summ` float unsigned NOT NULL,
  `startCashBalance` float unsigned NOT NULL,
  `finishCashBalance` float unsigned DEFAULT NULL,
  `startCashlessBalance` float unsigned DEFAULT NULL,
  `finishCashlessBalance` float unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Table structure for table `bank_invoices` */

DROP TABLE IF EXISTS `bank_invoices`;

CREATE TABLE `bank_invoices` (
  `bank_operation_id` bigint(20) unsigned NOT NULL COMMENT 'Уникальный код операции в',
  `pay_date` char(10) NOT NULL COMMENT 'Дата платежа',
  `pay_time` char(8) NOT NULL COMMENT 'Время платежа',
  `filial_number` varchar(100) NOT NULL COMMENT 'Номер отделения',
  `handler_number` varchar(100) NOT NULL COMMENT 'Номер кассира/УС/СБОЛ',
  `account_number` varchar(100) NOT NULL COMMENT 'Лицевой счет',
  `fio` varchar(200) DEFAULT NULL COMMENT 'Фамилия, Имя, Отчество',
  `address` varchar(200) DEFAULT NULL COMMENT 'Адрес',
  `payment_period` varchar(100) DEFAULT NULL COMMENT 'Период оплаты',
  `payment_summ` varchar(100) NOT NULL COMMENT 'Сумма операции',
  `transaction_summ` varchar(100) NOT NULL COMMENT 'Сумма перевода',
  `commission_summ` varchar(100) NOT NULL COMMENT 'Сумма комиссии банку',
  `bounded_bill_id` int(11) DEFAULT NULL COMMENT 'Идентификатор платежа в системе',
  `bounded_bill_is_double` tinyint(1) DEFAULT NULL COMMENT 'Тип участка',
  `real_pay_date` char(10) NOT NULL COMMENT 'Истинная дата платежа',
  PRIMARY KEY (`bank_operation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bill_fines` */

DROP TABLE IF EXISTS `bill_fines`;

CREATE TABLE `bill_fines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `bill_id` int(10) unsigned NOT NULL COMMENT 'Идентификатор платежа',
  `fines_id` bigint(20) unsigned NOT NULL COMMENT 'Идентификатор пени',
  `start_summ` double unsigned NOT NULL COMMENT 'Стоимость пени, включенная в счёт',
  `start_days` int(10) unsigned NOT NULL COMMENT 'Дней оплаты',
  PRIMARY KEY (`id`),
  KEY `bill_id_foreign` (`bill_id`),
  KEY `fines_id_foreign` (`fines_id`),
  CONSTRAINT `bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `payment_bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fines_id_foreign` FOREIGN KEY (`fines_id`) REFERENCES `penalties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Table structure for table `cottages` */

DROP TABLE IF EXISTS `cottages`;

CREATE TABLE `cottages` (
  `cottageNumber` int(5) unsigned NOT NULL COMMENT 'Номер участка',
  `cottageOwnerPersonals` varchar(200) NOT NULL COMMENT 'Фамилия имя и отчество владельца',
  `cottageOwnerPhone` char(18) DEFAULT NULL COMMENT 'Контактный номер владельца',
  `cottageOwnerEmail` varchar(200) DEFAULT NULL COMMENT 'Адрес электронной почты владельца',
  `cottageContacterPersonals` varchar(200) DEFAULT NULL COMMENT 'Фамилия имя и отчество контактного лица',
  `cottageContacterPhone` char(18) DEFAULT NULL COMMENT 'Контактный номер контактного лица',
  `cottageContacterEmail` varchar(200) DEFAULT NULL COMMENT 'Адрес электронной почты контактного лица',
  `cottageSquare` int(4) unsigned NOT NULL COMMENT 'Площадь участка, кв.м.',
  `membershipPayFor` varchar(20) NOT NULL COMMENT 'Последний оплаченный квартал',
  `powerPayFor` varchar(8) DEFAULT NULL COMMENT 'Последний оплаченный месяц',
  `targetDebt` float unsigned NOT NULL COMMENT 'Сумма задолженности по целевым платежам',
  `powerDebt` float unsigned DEFAULT NULL COMMENT 'Сумма задолженности по платежам за электроэнергию',
  `singleDebt` float unsigned DEFAULT '0' COMMENT 'Сумма задолженности по разовым платежам',
  `currentPowerData` int(20) unsigned NOT NULL COMMENT 'Последние показания счётчика электроэнергии',
  `deposit` float unsigned DEFAULT '0' COMMENT 'Сумма средств на депозите',
  `cottageOwnerAddress` longtext COMMENT 'Адрес владельца участка',
  `cottageHaveRights` tinyint(1) DEFAULT NULL COMMENT 'Наличие справки о праве на собственность',
  `cottageOwnerDescription` longtext COMMENT 'Дополнительная информация о владельце участка',
  `targetPaysDuty` longtext COMMENT 'Полная иформация о задолежнности по целевым платежам',
  `singlePaysDuty` longtext COMMENT 'Полная иформация о задолежнности по разовым платежам',
  `individualTariff` tinyint(1) DEFAULT NULL COMMENT 'Индивидуальный тариф',
  `individualTariffRates` longtext COMMENT 'Индивидуальные расценки',
  `haveAdditional` tinyint(1) DEFAULT '0' COMMENT 'Наличие дополнительного участка',
  `passportData` text COMMENT 'Паспортные данные',
  `cottageRightsData` text COMMENT 'Данные права собственности',
  `cottageRegistrationInformation` text COMMENT 'Данные кадастрового учёта',
  `partialPayedPower` text COMMENT 'Частично оплаченное электричество',
  `partialPayedMembership` text COMMENT 'Частично оплаченный членский взнос',
  `cottageRegisterData` tinyint(1) DEFAULT '0' COMMENT 'Данные для реестра',
  `bill_payers` text COMMENT 'Имена плательщиков',
  PRIMARY KEY (`cottageNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `counter_changes` */

DROP TABLE IF EXISTS `counter_changes`;

CREATE TABLE `counter_changes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(10) unsigned NOT NULL,
  `oldCounterStartData` int(10) unsigned NOT NULL,
  `oldCounterNewData` int(10) unsigned NOT NULL,
  `newCounterData` int(10) unsigned NOT NULL,
  `change_time` int(20) unsigned NOT NULL,
  `changeMonth` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

/*Table structure for table `deposit_io` */

DROP TABLE IF EXISTS `deposit_io`;

CREATE TABLE `deposit_io` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(10) unsigned NOT NULL,
  `billId` int(10) unsigned DEFAULT NULL,
  `destination` enum('in','out') NOT NULL,
  `summ` float unsigned NOT NULL,
  `summBefore` float unsigned NOT NULL,
  `summAfter` float unsigned NOT NULL,
  `actionDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8;

/*Table structure for table `discounts` */

DROP TABLE IF EXISTS `discounts`;

CREATE TABLE `discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageNumber` int(10) unsigned NOT NULL,
  `summ` float unsigned NOT NULL,
  `reason` text,
  `actionDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `mailings` */

DROP TABLE IF EXISTS `mailings`;

CREATE TABLE `mailings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `title` varchar(200) DEFAULT NULL COMMENT 'Заголовок рассылки',
  `body` text COMMENT 'Тело рассылки',
  `mailing_time` bigint(20) NOT NULL COMMENT 'Время рассылки',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `months_power` */

DROP TABLE IF EXISTS `months_power`;

CREATE TABLE `months_power` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(5) unsigned NOT NULL,
  `month` varchar(20) NOT NULL,
  `fillingDate` int(20) unsigned NOT NULL,
  `oldPowerData` int(10) unsigned NOT NULL,
  `newPowerData` int(10) unsigned NOT NULL,
  `searchTimestamp` int(20) unsigned NOT NULL,
  `payed` enum('yes','no') DEFAULT 'no',
  `difference` int(10) unsigned DEFAULT '0',
  `totalPay` float unsigned DEFAULT '0',
  `inLimitSumm` int(10) unsigned DEFAULT '0',
  `overLimitSumm` int(10) unsigned DEFAULT '0',
  `inLimitPay` float unsigned DEFAULT '0',
  `overLimitPay` float unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueCottageAndMonth` (`cottageNumber`,`month`),
  CONSTRAINT `CottageNumb` FOREIGN KEY (`cottageNumber`) REFERENCES `cottages` (`cottageNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=2708 DEFAULT CHARSET=utf8;

/*Table structure for table `payed_fines` */

DROP TABLE IF EXISTS `payed_fines`;

CREATE TABLE `payed_fines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `fine_id` bigint(20) unsigned NOT NULL COMMENT 'Идентификатор пени',
  `transaction_id` int(10) unsigned NOT NULL COMMENT 'Идентификатор транзакции',
  `pay_date` bigint(20) unsigned NOT NULL COMMENT 'Дата платежа',
  `summ` double NOT NULL COMMENT 'Сумма оплаты',
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id_foreign` (`transaction_id`),
  KEY `fines_id_foreign_1` (`fine_id`),
  CONSTRAINT `fines_id_foreign_1` FOREIGN KEY (`fine_id`) REFERENCES `penalties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `payed_membership` */

DROP TABLE IF EXISTS `payed_membership`;

CREATE TABLE `payed_membership` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageId` int(10) unsigned NOT NULL,
  `billId` int(10) unsigned NOT NULL,
  `quarter` varchar(10) NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=827 DEFAULT CHARSET=utf8;

/*Table structure for table `payed_power` */

DROP TABLE IF EXISTS `payed_power`;

CREATE TABLE `payed_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `month` varchar(10) NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=713 DEFAULT CHARSET=utf8;

/*Table structure for table `payed_simple` */

DROP TABLE IF EXISTS `payed_simple`;

CREATE TABLE `payed_simple` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `time` int(20) unsigned NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`,`billId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `payed_single` */

DROP TABLE IF EXISTS `payed_single`;

CREATE TABLE `payed_single` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `time` int(20) unsigned NOT NULL,
  `summ` float unsigned NOT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`,`billId`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Table structure for table `payed_target` */

DROP TABLE IF EXISTS `payed_target`;

CREATE TABLE `payed_target` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `billId` int(10) unsigned NOT NULL,
  `cottageId` int(10) unsigned NOT NULL,
  `year` int(4) unsigned NOT NULL,
  `summ` float unsigned DEFAULT NULL,
  `paymentDate` int(20) unsigned NOT NULL,
  `transactionId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8;

/*Table structure for table `payment_bills` */

DROP TABLE IF EXISTS `payment_bills`;

CREATE TABLE `payment_bills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(5) unsigned NOT NULL,
  `bill_content` longtext,
  `isPayed` tinyint(1) NOT NULL DEFAULT '0',
  `creationTime` int(20) unsigned NOT NULL,
  `paymentTime` int(20) unsigned DEFAULT NULL,
  `depositUsed` double unsigned DEFAULT '0',
  `totalSumm` double NOT NULL,
  `payedSumm` double unsigned DEFAULT '0',
  `discount` double unsigned DEFAULT '0',
  `discountReason` text,
  `toDeposit` double unsigned DEFAULT '0',
  `isPartialPayed` tinyint(4) DEFAULT '0',
  `isMessageSend` tinyint(1) DEFAULT '0' COMMENT 'Уведомление отправлено',
  `isInvoicePrinted` tinyint(1) DEFAULT '0' COMMENT 'Квитанция распечатана',
  PRIMARY KEY (`id`),
  KEY `billCottageNum` (`cottageNumber`),
  CONSTRAINT `billCottageNum` FOREIGN KEY (`cottageNumber`) REFERENCES `cottages` (`cottageNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=1444 DEFAULT CHARSET=utf8;

/*Table structure for table `payment_bills_double` */

DROP TABLE IF EXISTS `payment_bills_double`;

CREATE TABLE `payment_bills_double` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(5) unsigned NOT NULL,
  `bill_content` longtext,
  `isPayed` tinyint(1) NOT NULL DEFAULT '0',
  `creationTime` int(20) unsigned NOT NULL,
  `paymentTime` int(20) unsigned DEFAULT NULL,
  `depositUsed` double unsigned DEFAULT '0',
  `totalSumm` double unsigned NOT NULL,
  `payedSumm` double unsigned DEFAULT '0',
  `discount` double unsigned DEFAULT '0',
  `discountReason` text,
  `toDeposit` double unsigned DEFAULT '0',
  `isPartialPayed` tinyint(1) DEFAULT '0',
  `isMessageSend` tinyint(1) DEFAULT '0' COMMENT 'Уведомление отправлено',
  `isInvoicePrinted` tinyint(1) DEFAULT '0' COMMENT 'Квитанция распечатана',
  PRIMARY KEY (`id`),
  KEY `billCottageNum` (`cottageNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `penalties` */

DROP TABLE IF EXISTS `penalties`;

CREATE TABLE `penalties` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `cottage_number` varchar(10) NOT NULL COMMENT 'Номер участка',
  `pay_type` enum('membership','power','target') NOT NULL COMMENT 'Тип взноса',
  `period` varchar(7) NOT NULL COMMENT 'Период оплаты',
  `payUpLimit` bigint(20) NOT NULL COMMENT 'Крайняя дата оплаты',
  `summ` double unsigned NOT NULL COMMENT 'Начисленная сумма',
  `payed_summ` double unsigned NOT NULL COMMENT 'Оплаченная сумма',
  `is_partial_payed` tinyint(1) NOT NULL COMMENT 'Чатично оплачено',
  `is_full_payed` tinyint(1) NOT NULL COMMENT 'Полностью оплачено',
  `is_enabled` tinyint(1) NOT NULL COMMENT 'Активность пени',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=738 DEFAULT CHARSET=utf8;

/*Table structure for table `person` */

DROP TABLE IF EXISTS `person`;

CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `signup_token` varchar(255) DEFAULT NULL,
  `failed_try` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `USERNAME` (`username`),
  UNIQUE KEY `USERMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `send_emails` */

DROP TABLE IF EXISTS `send_emails`;

CREATE TABLE `send_emails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `address` varchar(200) NOT NULL COMMENT 'Адрес почты',
  `subject` varchar(500) NOT NULL COMMENT 'Тема',
  `body` longtext NOT NULL COMMENT 'Текст письма',
  `is_send` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Письмо успешно отправлено',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `snt_bills` */

DROP TABLE IF EXISTS `snt_bills`;

CREATE TABLE `snt_bills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `bill_id` int(10) unsigned NOT NULL COMMENT 'Идентификатор платежа для совместимости',
  `cottage` int(10) unsigned NOT NULL COMMENT 'Участок',
  `total_amount` int(10) unsigned NOT NULL COMMENT 'Сумма счёта',
  `payed` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Оплачено по счёту',
  `creation_time` int(15) unsigned NOT NULL COMMENT 'Дата создания',
  `payment_time` int(15) unsigned DEFAULT NULL COMMENT 'Дата полной оплаты',
  `deposit_used` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Использованный депозит',
  `deposit_gained` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Излишки оплаты',
  `discount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Скидка',
  `discount_reason` text COMMENT 'Причина скидки',
  `is_message_sent` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отправлено сообщение',
  `is_invoice_printed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Распечатана квитанция',
  `is_opened` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Счёт активен',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `snt_consumed_electricity` */

DROP TABLE IF EXISTS `snt_consumed_electricity`;

CREATE TABLE `snt_consumed_electricity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `month` char(7) NOT NULL COMMENT 'Месяц',
  `owner` int(10) unsigned NOT NULL COMMENT 'Участок',
  `meter` int(10) unsigned NOT NULL COMMENT 'Счётчик',
  `old_data` int(10) unsigned NOT NULL COMMENT 'Показания на начало периода',
  `new_data` int(10) unsigned NOT NULL COMMENT 'Показания на конец периода',
  `consumption` int(10) unsigned NOT NULL COMMENT 'Потрачено электроэнергии',
  `limit` int(10) unsigned NOT NULL COMMENT 'Льготный лимит',
  `in_limit_consumption` int(10) unsigned NOT NULL COMMENT 'Потрачено внутри лимита',
  `over_limit_consumption` int(10) unsigned NOT NULL COMMENT 'Потрачено вне лимита',
  `in_limit_cost` int(10) unsigned NOT NULL COMMENT 'Льготная стоимость',
  `over_limit_cost` int(10) unsigned NOT NULL COMMENT 'Обычная стоимость',
  `total_cost` int(10) unsigned NOT NULL COMMENT 'Общая стоимость',
  `completion_date` int(15) unsigned NOT NULL COMMENT 'Дата заполнения показаний',
  `timestamp` int(15) unsigned NOT NULL COMMENT 'Метка времени для поиска',
  `payed` int(15) unsigned NOT NULL DEFAULT '0' COMMENT 'Оплаченная сумма',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2543 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_cottage_subordination` */

DROP TABLE IF EXISTS `snt_cottage_subordination`;

CREATE TABLE `snt_cottage_subordination` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `master_id` int(10) unsigned DEFAULT NULL COMMENT 'Главный участок',
  `sub_id` int(10) unsigned DEFAULT NULL COMMENT 'Дополнительный участок',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_cottages` */

DROP TABLE IF EXISTS `snt_cottages`;

CREATE TABLE `snt_cottages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор участка',
  `number` varchar(10) NOT NULL COMMENT 'Номер участка',
  `square` int(5) unsigned NOT NULL COMMENT 'Площадь участка',
  `deposit` int(20) unsigned NOT NULL COMMENT 'Сумма депозита участка',
  `description` text COMMENT 'Примечание',
  `pay_membership` tinyint(1) NOT NULL COMMENT 'Оплачивает ли участок членские взносы',
  `pay_target` tinyint(1) NOT NULL COMMENT 'Оплачивает ли участок целевые взносы',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_electricity_meters` */

DROP TABLE IF EXISTS `snt_electricity_meters`;

CREATE TABLE `snt_electricity_meters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `owner` int(10) unsigned NOT NULL COMMENT 'Участок',
  `condition` enum('in_use','expired','temporary_off') NOT NULL COMMENT 'Статус',
  `start_data` int(10) unsigned NOT NULL COMMENT 'Начальные показания',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_emails` */

DROP TABLE IF EXISTS `snt_emails`;

CREATE TABLE `snt_emails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `address` varchar(255) NOT NULL COMMENT 'Адрес',
  `person` int(10) unsigned NOT NULL COMMENT 'Владелец',
  `description` text COMMENT 'Примечание',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_membership_data` */

DROP TABLE IF EXISTS `snt_membership_data`;

CREATE TABLE `snt_membership_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `quarter` char(6) NOT NULL COMMENT 'Квартал',
  `cottage` int(10) unsigned NOT NULL COMMENT 'Участок',
  `counted_square` int(10) unsigned NOT NULL COMMENT 'Площадь участка на момент расчёта',
  `from_cottage` int(10) unsigned NOT NULL COMMENT 'Цена с участка',
  `from_square` int(10) unsigned NOT NULL COMMENT 'Цена с сотки',
  `amount_from_square` int(10) unsigned NOT NULL COMMENT 'Начислено по площади',
  `total_amount` int(10) unsigned NOT NULL COMMENT 'К оплате',
  `payed` int(15) unsigned NOT NULL COMMENT 'Оплачено',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1014 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_pay_entities` */

DROP TABLE IF EXISTS `snt_pay_entities`;

CREATE TABLE `snt_pay_entities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('power','membership','target','simple','fine') NOT NULL,
  `cottage` int(10) unsigned NOT NULL,
  `bill` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2531 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_payed_entities` */

DROP TABLE IF EXISTS `snt_payed_entities`;

CREATE TABLE `snt_payed_entities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `type` enum('power','membership','target','fine','single') NOT NULL COMMENT 'Тип оплаты',
  `cottage` int(10) unsigned NOT NULL COMMENT 'Участок',
  `bill` int(10) unsigned NOT NULL COMMENT 'Счёт',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'Идентификатор периода',
  `amount` int(10) unsigned NOT NULL COMMENT 'Сумма оплаты',
  `transaction` int(10) unsigned NOT NULL COMMENT 'Номер транзакции',
  `pay_time` int(15) DEFAULT NULL COMMENT 'Время оплаты',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1929 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_person_roles` */

DROP TABLE IF EXISTS `snt_person_roles`;

CREATE TABLE `snt_person_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `role` varchar(100) NOT NULL COMMENT 'Название роли',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_persons` */

DROP TABLE IF EXISTS `snt_persons`;

CREATE TABLE `snt_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `name` varchar(255) NOT NULL COMMENT 'ФИО',
  `role` int(10) unsigned NOT NULL COMMENT 'Статус',
  `address` text COMMENT 'Адрес места жительства',
  `passportData` text COMMENT 'Паспортные данные',
  `cottage` int(10) unsigned NOT NULL COMMENT 'Номер участка',
  `description` text COMMENT 'Примечание',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_phones` */

DROP TABLE IF EXISTS `snt_phones`;

CREATE TABLE `snt_phones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `phone` char(11) NOT NULL COMMENT 'Номер',
  `person` int(10) unsigned NOT NULL COMMENT 'Владелец',
  `description` text COMMENT 'Примечание',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_single_data` */

DROP TABLE IF EXISTS `snt_single_data`;

CREATE TABLE `snt_single_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `timestamp` int(15) unsigned NOT NULL COMMENT 'Временная метка',
  `cottage` int(10) unsigned NOT NULL COMMENT 'Участок',
  `total_amount` int(10) unsigned NOT NULL COMMENT 'К оплате',
  `payed` int(15) unsigned NOT NULL COMMENT 'Оплачено',
  `description` text COMMENT 'Назначение платежа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_target_data` */

DROP TABLE IF EXISTS `snt_target_data`;

CREATE TABLE `snt_target_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `year` int(4) unsigned NOT NULL COMMENT 'Год',
  `cottage` int(10) unsigned NOT NULL COMMENT 'Участок',
  `counted_square` int(10) unsigned NOT NULL COMMENT 'Площадь участка на момент расчёта',
  `from_cottage` int(10) unsigned NOT NULL COMMENT 'Цена с участка',
  `from_square` int(10) unsigned NOT NULL COMMENT 'Цена с сотки',
  `amount_from_square` int(10) unsigned NOT NULL COMMENT 'Начислено по площади',
  `total_amount` int(10) unsigned NOT NULL COMMENT 'К оплате',
  `payed` int(15) unsigned NOT NULL COMMENT 'Оплачено',
  `description` text COMMENT 'Назначение платежа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=713 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_tariffs_membership` */

DROP TABLE IF EXISTS `snt_tariffs_membership`;

CREATE TABLE `snt_tariffs_membership` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `quarter` char(6) NOT NULL COMMENT 'Квартал',
  `from_cottage` int(10) unsigned NOT NULL COMMENT 'Цена с участка',
  `from_square` int(10) unsigned NOT NULL COMMENT 'Цена с сотки',
  `timestamp` int(15) unsigned NOT NULL COMMENT 'Временная метка для поиска',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_tariffs_power` */

DROP TABLE IF EXISTS `snt_tariffs_power`;

CREATE TABLE `snt_tariffs_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `month` char(7) NOT NULL COMMENT 'Месяц',
  `limit` int(10) unsigned NOT NULL COMMENT 'Льготный лимит',
  `preferential_price` int(10) unsigned NOT NULL COMMENT 'Льготная цена',
  `normal_price` int(10) unsigned NOT NULL COMMENT 'Обычная цена',
  `timestamp` int(15) unsigned NOT NULL COMMENT 'Временная метка для поиска',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_tariffs_target` */

DROP TABLE IF EXISTS `snt_tariffs_target`;

CREATE TABLE `snt_tariffs_target` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Глобальный идентификатор',
  `year` int(4) unsigned NOT NULL COMMENT 'Год',
  `from_cottage` int(10) unsigned NOT NULL COMMENT 'Цена с участка',
  `from_square` int(10) unsigned NOT NULL COMMENT 'Цена с сотки',
  `pay_up` int(15) unsigned NOT NULL COMMENT 'Срок оплаты',
  `description` text COMMENT 'Назначение платежа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `snt_transactions` */

DROP TABLE IF EXISTS `snt_transactions`;

CREATE TABLE `snt_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(10) unsigned DEFAULT NULL,
  `billId` int(10) unsigned DEFAULT NULL,
  `transactionDate` int(20) unsigned NOT NULL,
  `transactionType` enum('cash','no-cash') NOT NULL,
  `payed` int(10) unsigned NOT NULL,
  `transactionReason` text,
  `usedDeposit` int(11) NOT NULL,
  `gainedDeposit` int(11) NOT NULL,
  `partial` tinyint(1) DEFAULT NULL,
  `payDate` int(10) unsigned NOT NULL,
  `bankDate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `CottageNum` (`cottageNumber`),
  KEY `BillId` (`billId`)
) ENGINE=InnoDB AUTO_INCREMENT=1158 DEFAULT CHARSET=utf8;

/*Table structure for table `tariffs_membership` */

DROP TABLE IF EXISTS `tariffs_membership`;

CREATE TABLE `tariffs_membership` (
  `quarter` varchar(8) NOT NULL,
  `fixed_part` float unsigned NOT NULL,
  `changed_part` float unsigned NOT NULL,
  `search_timestamp` int(20) unsigned NOT NULL,
  `fullSumm` float unsigned NOT NULL DEFAULT '0',
  `payedSumm` float unsigned NOT NULL DEFAULT '0',
  `paymentInfo` longtext,
  PRIMARY KEY (`quarter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tariffs_power` */

DROP TABLE IF EXISTS `tariffs_power`;

CREATE TABLE `tariffs_power` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `targetMonth` varchar(20) NOT NULL COMMENT 'Месяц для расчёта суммы платежа',
  `powerLimit` int(5) unsigned NOT NULL COMMENT 'Порог потребления электроэнергии',
  `powerCost` float unsigned NOT NULL COMMENT 'Цена электроэнергии до порога',
  `powerOvercost` float unsigned NOT NULL COMMENT 'Цена электроэнергии при перерасходе',
  `searchTimestamp` int(20) unsigned NOT NULL COMMENT 'Временная метка для поиска дат',
  `fullSumm` float unsigned NOT NULL COMMENT 'Сумма начисленная за месяц',
  `payedSumm` float unsigned NOT NULL COMMENT 'Фактически заплаченная сумма',
  `paymentInfo` longtext NOT NULL COMMENT 'Подробная информация об оплате',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueMonth` (`targetMonth`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

/*Table structure for table `tariffs_target` */

DROP TABLE IF EXISTS `tariffs_target`;

CREATE TABLE `tariffs_target` (
  `year` int(4) unsigned NOT NULL COMMENT 'Год регистрации целевого платежа',
  `fixed_part` float unsigned NOT NULL COMMENT 'Фиксированная часть оплаты',
  `float_part` float unsigned NOT NULL COMMENT 'Стоимость платежа с сотки',
  `description` text NOT NULL COMMENT 'Цели платежа',
  `fullSumm` float unsigned NOT NULL COMMENT 'Расчёт полной суммы платежей с садоводства',
  `payedSumm` float unsigned NOT NULL COMMENT 'Сумма оплаченных счетов',
  `paymentInfo` longtext NOT NULL COMMENT 'Полная информация по платежам',
  `payUpTime` int(11) NOT NULL COMMENT 'Срок оплаты',
  PRIMARY KEY (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(5) unsigned DEFAULT NULL,
  `billId` int(10) unsigned DEFAULT NULL,
  `transactionDate` int(20) unsigned NOT NULL,
  `transactionType` enum('cash','no-cash') NOT NULL,
  `transactionSumm` double unsigned NOT NULL,
  `transactionWay` enum('in','out') NOT NULL,
  `transactionReason` text,
  `billCast` text,
  `usedDeposit` double NOT NULL,
  `gainedDeposit` double NOT NULL,
  `partial` tinyint(1) DEFAULT NULL,
  `payDate` int(10) unsigned NOT NULL,
  `bankDate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `CottageNum` (`cottageNumber`),
  KEY `BillId` (`billId`),
  CONSTRAINT `BillId` FOREIGN KEY (`billId`) REFERENCES `payment_bills` (`id`),
  CONSTRAINT `CottageNum` FOREIGN KEY (`cottageNumber`) REFERENCES `cottages` (`cottageNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=1187 DEFAULT CHARSET=utf8;

/*Table structure for table `transactions_double` */

DROP TABLE IF EXISTS `transactions_double`;

CREATE TABLE `transactions_double` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(5) unsigned DEFAULT NULL,
  `billId` int(10) unsigned DEFAULT NULL,
  `transactionDate` int(20) unsigned NOT NULL,
  `transactionType` enum('cash','no-cash') NOT NULL,
  `transactionSumm` double unsigned NOT NULL,
  `transactionWay` enum('in','out') NOT NULL,
  `transactionReason` text,
  `billCast` text,
  `usedDeposit` double NOT NULL,
  `gainedDeposit` double NOT NULL,
  `partial` tinyint(1) DEFAULT NULL,
  `payDate` int(10) unsigned DEFAULT NULL,
  `bankDate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CottageNum` (`cottageNumber`),
  KEY `BillId` (`billId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `unsended_messages` */

DROP TABLE IF EXISTS `unsended_messages`;

CREATE TABLE `unsended_messages` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `cottageNumber` int(10) unsigned NOT NULL,
  `subject` longtext NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
