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
  
DROP TABLE IF EXISTS {$this->getTable('looks')} ;
CREATE  TABLE IF NOT EXISTS {$this->getTable('looks')} (
  `look_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(450) NOT NULL,
  `is_visible` INT NOT NULL,
  `position` INT NOT NULL,
  PRIMARY KEY (`look_id`) )
ENGINE = InnoDB;

");
$installer->endSetup();