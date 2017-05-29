<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct(){
		parent::__construct();
		$this->setId('looksGrid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('ASC');
	}

	protected function _prepareCollection(){
		$collection = Mage::getModel('looks/looks')->getCollection();
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns(){

		$this->addColumn('look_id', array(
			'header' 	=> Mage::helper('looks')->__('ID'),
			'width' 	=> '10px',
			'index'		=> 'look_id',
		));

	 	$this->addColumn('look_name', array(
			'header' 	=> Mage::helper('looks')->__('Name'),
			'width' 	=> '500px',
			'index'		=> 'name',
		));

		$this->addColumn('look_visibility', array(
			'header' 	=> Mage::helper('looks')->__('Visibility'),
			'width' 	=> '20px',
			'index'		=> 'is_visible',
			'type'      => 'options',
        	'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
		));

		$this->addColumn('look_position', array(
			'header' 	=> Mage::helper('looks')->__('Position'),
			'width' 	=> '20px',
			'index'		=> 'position',
		));

		$this->addColumn('look_price', array(
            'header'        => Mage::helper('catalog')->__('Price'),
            'type'          => 'currency',
            'width'         => '10px',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'         => 'look_price'
            ));

		return parent::_prepareColumns();
	}

	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id'=>$row->getLookId()));
	}
}