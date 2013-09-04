ALTER TABLE `{database.name}`.`wc_shop_history` ADD ENUM('Money','Items') CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL;

DELETE FROM `{database.name}`.`wc_shop_history` WHERE `entry` = 'facebook_page';
DELETE FROM `{database.name}`.`wc_shop_history` WHERE `entry` = 'youtube_channel';
DELETE FROM `{database.name}`.`wc_shop_history` WHERE `entry` = 'twitter_account';