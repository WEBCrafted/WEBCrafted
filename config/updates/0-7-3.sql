ALTER TABLE `{database.name}`.`users` RENAME TO `{database.name}`.`wc_users`;
ALTER TABLE `{database.name}`.`categories` RENAME TO `{database.name}`.`wc_categories`;
ALTER TABLE `{database.name}`.`comments` RENAME TO `{database.name}`.`wc_comments`;
ALTER TABLE `{database.name}`.`options` RENAME TO `{database.name}`.`wc_options`;
ALTER TABLE `{database.name}`.`posts` RENAME TO `{database.name}`.`wc_posts`;
ALTER TABLE `{database.name}`.`shop_history` RENAME TO `{database.name}`.`wc_shop_history`;
ALTER TABLE `{database.name}`.`shop_items` RENAME TO `{database.name}`.`wc_shop_items`;
ALTER TABLE `{database.name}`.`stats_visitors` RENAME TO `{database.name}`.`wc_stats_visitors`;
ALTER TABLE `{database.name}`.`widgets` RENAME TO `{database.name}`.`wc_widgets`;

-- -----------------------------------------------------
-- Table `wc_partners`
-- -----------------------------------------------------
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

INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_usecode', 'true');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('shop_starpass_credit', '10');
INSERT INTO `{database.name}`.`wc_options` (`entry`, `value`) VALUES ('version', '0-7-3');