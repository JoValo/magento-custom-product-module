<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Media_Config extends Mage_Catalog_Model_Product_Media_Config {

    public function getBaseMediaPath() {
        return Mage::getBaseDir('media') . DS . 'looks';
    }

    public function getBaseMediaUrl() {
        return Mage::getBaseUrl('media') . 'looks';
    }

    public function getBaseTmpMediaPath() {
        return Mage::getBaseDir('media') . DS . 'looks';
    }

    public function getBaseTmpMediaUrl() {
        return Mage::getBaseUrl('media') . 'looks';
    }

}