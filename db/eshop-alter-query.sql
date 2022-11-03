ALTER TABLE `offers` ADD `text` TEXT NOT NULL AFTER `id`;
ALTER TABLE `offers` ADD `offer_type` ENUM('Percentage','Amount') NOT NULL AFTER `type_id`, ADD `offer_amount` INT(11) NOT NULL AFTER `offer_type`;
