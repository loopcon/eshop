ALTER TABLE `offers` ADD `text` TEXT NOT NULL AFTER `id`;
ALTER TABLE `offers` ADD `offer_type` ENUM('Percentage','Amount') NOT NULL AFTER `type_id`, ADD `offer_amount` INT(11) NOT NULL AFTER `offer_type`;

-- 11-11-2022
ALTER TABLE `cart` ADD `guest_user_id` INT(11) NOT NULL AFTER `user_id`;
ALTER TABLE `cart` ADD `is_guest` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '(0:No|1:Yes)' AFTER `is_saved_for_later`;

-- 14-11-2022
ALTER TABLE `orders` ADD `is_guest` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '(0:No|1:Yes)' AFTER `id`;
ALTER TABLE `orders` ADD `guest_user_id` INT(11) NOT NULL AFTER `user_id`;
ALTER TABLE `orders` ADD `firstname` VARCHAR(255) NOT NULL AFTER `address_id`, ADD `lastname` VARCHAR(255) NOT NULL AFTER `firstname`, ADD `email` VARCHAR(255) NOT NULL AFTER `lastname`;
ALTER TABLE `orders` ADD `address_line_1` VARCHAR(255) NOT NULL AFTER `mobile`, ADD `address_line_2` VARCHAR(255) NOT NULL AFTER `address_line_1`, ADD `city` VARCHAR(255) NOT NULL AFTER `address_line_2`, ADD `state` VARCHAR(255) NOT NULL AFTER `city`, ADD `country` VARCHAR(255) NOT NULL AFTER `state`, ADD `zipcode` VARCHAR(255) NOT NULL AFTER `country`;

ALTER TABLE `order_items` ADD `is_guest` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '(0:No|1:Yes)' AFTER `id`;
ALTER TABLE `order_items` ADD `guest_user_id` INT(11) NOT NULL AFTER `user_id`;

-- 18-11-2022
ALTER TABLE `seller_data` CHANGE `status` `status` TINYINT(2) NOT NULL DEFAULT '3' COMMENT 'approved: 1 | not-approved: 2 | deactive:3 | deactive:0 | removed :7';

-- 21-11-2022
ALTER TABLE `attribute_set` ADD `added_by` INT(11) NOT NULL AFTER `status`;
ALTER TABLE `attribute_set` ADD `added_user_is` ENUM('Seller','Admin') NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `attributes` ADD `added_by` INT(11) NOT NULL AFTER `status`;
ALTER TABLE `attributes` ADD `added_user_is` ENUM('Seller','Admin') NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `attribute_values` ADD `added_by` INT(11) NOT NULL AFTER `status`;
ALTER TABLE `attribute_values` ADD `added_user_is` ENUM('Seller','Admin') NULL DEFAULT NULL AFTER `status`;

-- 24-11-2022
ALTER TABLE `products` ADD `length` VARCHAR(100) NULL AFTER `description`, ADD `width` VARCHAR(100) NULL AFTER `length`, ADD `height` VARCHAR(100) NULL AFTER `width`, ADD `weight` VARCHAR(100) NULL AFTER `height`, ADD `mass_unit` ENUM('Gram', 'Ounce', 'Pound', 'Kilogram') NULL DEFAULT NULL AFTER `weight`;
-- 25-11-2022
ALTER TABLE `users` ADD `country` INT(11) NULL AFTER `country_code`, ADD `state` INT(11) NULL AFTER `country`;

-- 28-11-2022
ALTER TABLE `areas` ADD `country_id` INT(11) NULL AFTER `name`, ADD `state_id` INT(11) NULL AFTER `country_id`;

