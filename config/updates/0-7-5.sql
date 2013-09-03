-- -----------------------------------------------------
-- Table `wc_groups`
-- -----------------------------------------------------
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

INSERT INTO `{database.name}`.`wc_groups` (`id`, `name`, `permissions`, `signup`, `creator_id`, `last_editor_id`, `date_created`, `date_last_edited`) VALUES (1, 'Administrateur', '["webcrafted.admin.*"]', '0', 1, 1, 'NOW()', 'NOW()');
INSERT INTO `{database.name}`.`wc_groups` (`id`, `name`, `permissions`, `signup`, `creator_id`, `last_editor_id`, `date_created`, `date_last_edited`) VALUES (2, 'Utilisateur', '[""]', '1', 1, 1, 'NOW()', 'NOW()');

ALTER TABLE `{database.name}`.`wc_users` DROP telephone;
ALTER TABLE `{database.name}`.`wc_users` DROP admin;
ALTER TABLE `{database.name}`.`wc_users` ADD group_id INT(11) NULL;