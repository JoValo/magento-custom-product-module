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
	ALTER TABLE `{$installer->getTable('looks')}` ADD `look_price` DECIMAL(12,4)");
$installer->endSetup();
