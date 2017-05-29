<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Model_Looks extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'looks';

    public function _construct(){
        parent::_construct();
        $this->_init('looks/looks');
    }

    protected function _getSession(){
        return Mage::getSingleton('customer/session');   
    }
}