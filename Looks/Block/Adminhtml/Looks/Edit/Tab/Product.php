<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid{

    public function __construct(){
        parent::__construct();
        $this->setId('product_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(false); 
    }

    protected function _prepareCollection(){
        $collection = Mage::getModel('catalog/category')->load(99)
            ->getProductCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price');

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns(){
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'  => 'checkbox',
            'name'  => 'in_products',
            'values'=> $this->_getSelectedItems(),
            'align' => 'center',
            'index' => 'entity_id'
            ));

        $this->addColumn('entity_id', array(
            'header'=> Mage::helper('catalog')->__('ID'),
            'width' => '10',
            'align' => 'left',
            'index' => 'entity_id'
            ));

        $this->addColumn('name', array(
            'header'=> Mage::helper('catalog')->__('Name'),
            'align' => 'left',
            'index' => 'name',
            ));

        $this->addColumn('sku', array(
            'header'=> Mage::helper('catalog')->__('SKU'),
            'align' => 'left',
            'index' => 'sku',
            ));

        $this->addColumn('price', array(
            'header'        => Mage::helper('catalog')->__('Price'),
            'type'          => 'currency',
            'width'         => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'         => 'price'
            ));

        $this->addColumn('position', array(
            'header'        => Mage::helper('catalog')->__('Position'),
            'name'          => 'position',
            'width'         => 60,
            'type'          => 'number',
            'validate_class'=> 'validate-number',
            'index'         => 'position',
            'editable'      => true,
            ));

        return parent::_prepareColumns();
    }


    protected function _getSelectedItems(){
        $products = array_keys($this->getSelectedItems());    
        return $products;       
    }

    public function getSelectedItems(){
        $products = array();
        $selected = (int)$this->getRequest()->getParam('id', null);
        $itemsSelected = Mage::getModel('looks/items')->getCollection()
            ->addFieldToFilter('look_id',array("eq"=>$selected))
            ->addFieldToSelect('*')
            ->getData();

        foreach ($itemsSelected as $itemProduct) {
            $products[$itemProduct['product_id']] = array('position' => $itemProduct['position']);
        }

        return $products;
    }

    public function getRowUrl($item){
        return '#';
    }

    protected function _addColumnFilterToCollection($column){
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedItems();
            if(empty($productIds)){
                $productIds = 0;
            }
            if($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }else{
                if($productIds){
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                }
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}
