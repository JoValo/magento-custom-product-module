<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks_Edit_Form_Looks extends Mage_Adminhtml_Block_Widget_Form{
	
	protected function _prepareForm(){		
		$form = new Varien_Data_Form();
		
		$this->setForm($form);
		
		//Add field legend 
		$fieldset = $form->addFieldset('looks_form', array('legend' => 'Look data'));

		//Add fields to form
		$fieldset->addField('name', 'text', array(
			'label' 	=> $this->__('Look name'),
			'required' 	=> true,
			'name' 		=> 'look_name'
		));

		$fieldset->addField('is_visible', 'select', array(
			'label' 	=> $this->__('Visible in store'),
			'required' 	=> true,
			'name' 		=> 'look_visibility',
			'class' 	=> 'required-entry',
		    'values' 	=> array('1' => $this->__('Yes'),'0' => $this->__('No'))
		));

		$fieldset->addField('position', 'text', array(
			'label' 	=> $this->__('Position'),
			'required' 	=> true,
			'type' 		=> 'number',
			'name' 		=> 'look_position'
		));

		$fieldset->addField('look_price', 'text', array(
			'label' 		=> $this->__('Price'),
			'required' 		=> true,
			'type' 			=> 'currency',
			'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
			'name' 			=> 'look_price'
		));

		$data = (Mage::registry('data')) ? Mage::registry('data')->getData() : array();
		$form->setValues($data);

		parent::_prepareForm();
	}
}