<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	
	public function __construct(){
		parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'looks';
		$this->_controller = 'adminhtml_looks';
        $this->_removeButton('reset');
        $this->_removeButton('save', 'label', $this->__('Save'));
        $this->_addButton('module_controller', array(
        'label' => $this->__('Save'),
        'onclick' => "$('edit_form').action = '".$this->getUrl('*/looks/save',array('id' =>$this->getRequest()->getParam('id')))."'; $('edit_form').submit();"));
	}
	
	public function getHeaderText(){
		return $this->__('Arma tu look');
	}
}