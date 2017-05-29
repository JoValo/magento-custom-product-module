<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	
    public function __construct(){
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('looks')->__('Arma tu look'));
    }

    protected function _beforeToHtml(){
        $this->addTab('looks', array(
            'label'     => $this->__('Look data'),
            'content'   => $this->getLayout()->createBlock('looks/adminhtml_looks_edit_form_looks')->toHtml(),  
        ));

        $this->addTab('images', array(
            'label'     => $this->__('Look images'),
            'content' => $this->getLayout()->createBlock('looks/adminhtml_looks_edit_tab_images')->toHtml(),
        ));

        $this->addTab('products', array(
            'label'     => $this->__('Look items'),
            'url' => $this->getUrl('*/*/post', array('_current' => true)),
            'class' => 'ajax',
        ));

        
        return parent::_beforeToHtml();
    }
}