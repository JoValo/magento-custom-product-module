<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
 class Glosbe_Looks_Block_Adminhtml_Looks_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
	
	protected function _prepareForm(){
		$form = new Varien_Data_Form(
			array(			
				'id' 		=> 'edit_form',
				'action' 	=> $this->getUrl('*/*/update', array('id' =>$this->getRequest()->getParam('id'))),
				'method'	=> 'post',
				'enctype' 	=> 'multipart/form-data'
			)
		);

		$form->setUseContainer(true);
		$this->setForm($form);
		$data = (Mage::registry('data')) ? Mage::registry('data')->getData() : array();
		$form->setValues($data);
		parent::_prepareForm();
	}
}