SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `{database.name}` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `{database.name}` ;

-- -----------------------------------------------------
-- Table `{database.name}`.`wc_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_categories` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_categories` (
  `id` INT(11) NOT NULL ,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `creator_id` INT(11) NOT NULL ,
  `last_editor_id` INT(11) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_last_edited` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `creator_id` (`creator_id` ASC) ,
  INDEX `last_editor_id` (`last_editor_id` ASC) ,
  CONSTRAINT `categories_ibfk_1`
    FOREIGN KEY (`last_editor_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `categories_ibfk_2`
    FOREIGN KEY (`creator_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_comments` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_comments` (
  `id` INT(11) NOT NULL ,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `post_id` INT(11) NOT NULL ,
  `creator_id` INT(11) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `post_id` (`post_id` ASC) ,
  INDEX `user_creator` (`creator_id` ASC) ,
  CONSTRAINT `comments_ibfk_1`
    FOREIGN KEY (`creator_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `comments_ibfk_2`
    FOREIGN KEY (`post_id` )
    REFERENCES `{database.name}`.`wc_posts` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les commentaires des articles';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_groups` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_groups` (
  `id` INT(11) NOT NULL ,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `permissions` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `signup` ENUM('0','1') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '0' ,
  `creator_id` INT(11) NOT NULL ,
  `last_editor_id` INT(11) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_last_edited` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `user_last_editor` (`last_editor_id` ASC) ,
  INDEX `user_creator` (`creator_id` ASC) ,
  CONSTRAINT `groups_ibfk_1`
    FOREIGN KEY (`creator_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `groups_ibfk_2`
    FOREIGN KEY (`last_editor_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les groupes de permissions';

-- -----------------------------------------------------
-- Table `{database.name}`.`wc_options`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_options` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_options` (
  `entry` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `value` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT 'default' ,
  PRIMARY KEY (`entry`) ,
  UNIQUE INDEX `entry` (`entry` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Les options du site web';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_posts` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_posts` (
  `id` INT(11) NOT NULL ,
  `title` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `slug` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `image` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `extract` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `category_id` INT(11) NOT NULL ,
  `tags` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `type` ENUM('Page','Post') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `comments` ENUM('0','1') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '1' ,
  `online` ENUM('0','1') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '1' ,
  `creator_id` INT(11) NOT NULL ,
  `last_editor_id` INT(11) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_last_edited` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `user_last_editor` (`last_editor_id` ASC) ,
  INDEX `user_creator` (`creator_id` ASC) ,
  INDEX `category_id` (`category_id` ASC) ,
  CONSTRAINT `posts_ibfk_1`
    FOREIGN KEY (`creator_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `posts_ibfk_2`
    FOREIGN KEY (`last_editor_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `posts_ibfk_3`
    FOREIGN KEY (`category_id` )
    REFERENCES `{database.name}`.`wc_categories` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les articles et les pages du site web';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_partners`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_partners` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_partners` (
  `id` INT(11) NOT NULL ,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `url` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `image` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `creator_id` INT(11) NOT NULL ,
  `last_editor_id` INT(11) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_last_edited` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `user_last_editor` (`last_editor_id` ASC) ,
  INDEX `user_creator` (`creator_id` ASC) ,
  CONSTRAINT `partners_ibfk_1`
    FOREIGN KEY (`creator_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `partners_ibfk_2`
    FOREIGN KEY (`last_editor_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les partenaires du site web';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_shop_history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_shop_history` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_shop_history` (
  `id` INT(11) NOT NULL ,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `user_id` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `type` ENUM('Money','Items') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `date` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les historiques de la boutique';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_shop_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_shop_items` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_shop_items` (
  `id` INT(11) NOT NULL ,
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `name_raw` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `image_url` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `method` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `args` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `duration` INT(11) NOT NULL DEFAULT '0' ,
  `category` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `price` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les articles de la boutique';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_stats_visitors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_stats_visitors` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_stats_visitors` (
  `id` INT(11) NOT NULL ,
  `ip` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `first_visit` DATETIME NOT NULL COMMENT 'La date de la première visite' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les visiteurs du site web';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_users` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_users` (
  `id` INT(11) NOT NULL ,
  `username` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `password` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL COMMENT 'Mot de passe hashé' ,
  `email` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `money` INT(11) NOT NULL DEFAULT '0' ,
  `signup_date` DATETIME NOT NULL ,
  `last_login_date` DATETIME NOT NULL ,
  `group_id` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `group_id` (`group_id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les utilisateurs du site web';


-- -----------------------------------------------------
-- Table `{database.name}`.`wc_widgets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{database.name}`.`wc_widgets` ;

CREATE  TABLE IF NOT EXISTS `{database.name}`.`wc_widgets` (
  `id` INT(11) NOT NULL ,
  `title` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `hidden` ENUM('0','1') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL DEFAULT '0' ,
  `creator_id` INT(11) NOT NULL ,
  `last_editor_id` INT(11) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_last_edited` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id` (`id` ASC) ,
  INDEX `user_last_editor` (`last_editor_id` ASC) ,
  INDEX `user_creator` (`creator_id` ASC) ,
  CONSTRAINT `widgets_ibfk_1`
    FOREIGN KEY (`creator_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ),
  CONSTRAINT `widgets_ibfk_2`
    FOREIGN KEY (`last_editor_id` )
    REFERENCES `{database.name}`.`wc_users` (`id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'Table contenant les widgets du site web';

USE `{database.name}` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `{database.name}`.`wc_options`
-- -----------------------------------------------------
START TRANSACTION;
USE `{database.name}`;
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('install', 'false');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('theme', 'webcrafted');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('facebook_page', 'false');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('youtube_channel', 'false');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('twitter_account', 'false');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('server_ip', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('server_port', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('jsonapi_use', 'false');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('jsonapi_port', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('jsonapi_salt', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('jsonapi_username', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('jsonapi_password', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('name', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('slogan', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('description', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('keywords', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('version', '0-7-6');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_use', 'false');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_idd', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_idp', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_code', 'default');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_usecode', 'true');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_credit', '10');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('users_secret_key', 'default');

COMMIT;
