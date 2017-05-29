<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE IF NOT EXISTS `{$installer->getTable('look_items')}` (
  `item_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `position` INT(10) UNSIGNED NOT NULL,
  `product_id` INT(10) UNSIGNED NOT NULL,
  `look_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`item_id`),
  CONSTRAINT `FK_ITEM_PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `{$installer->getTable('catalog/product')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ITEM_LOOK` FOREIGN KEY (`look_id`) REFERENCES `{$installer->getTable('looks')}` (`look_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Look Products Relations';");
$installer->endSetup();
