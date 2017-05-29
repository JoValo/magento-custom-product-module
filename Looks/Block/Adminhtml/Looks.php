<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct(){
		$this->_controller = 'adminhtml_looks';
		$this->_blockGroup = 'looks'; 
		$this->_headerText = $this->__('Looks');
		$this->_addButtonLabel = $this->__('Add New Look'); 
		parent::__construct();
	}
}