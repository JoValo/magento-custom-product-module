<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Adminhtml_LooksController extends Mage_Adminhtml_Controller_Action{

	protected function _initGallery() {
        $id = $this->getRequest()->getParam('id'); 
        if ($id) {
        	$model_gallery = Mage::getModel('looks/images')->getCollection();
            $model_gallery->addFieldToFilter('look_id', array('eq' => $id));
        }else{
        	$model_gallery = Mage::getModel('looks/images');
        }
        Mage::register('looks_gallery', $model_gallery);
    }

	public function indexAction(){
		$this->loadLayout();
		$this->_addContent($this->getLayout()->createBlock('looks/adminhtml_looks'));
		$this->renderLayout();
	}

	public function newAction(){
		$this->_initGallery();
		$this->loadLayout();
		$this->_addContent($this->getLayout()->createBlock('looks/adminhtml_looks_edit'));
		$this->_addLeft($this->getLayout()->createBlock('looks/adminhtml_looks_edit_tabs'));
		$this->renderLayout();
	}

	public function saveAction(){
		$id = (int)$this->getRequest()->getParam('id');
		$lookImages = array();
		$links = Mage::app()->getRequest()->getPost('links');
		$data = $this->getRequest()->getPost();		
        $lookImages = Zend_Json::decode($this->getRequest()->getPost('looks_gallery'));

        $model = Mage::getModel('looks/looks');
		if($data){
			$this->newDataLook($data,$model);
			Mage::getSingleton('adminhtml/session')->setFormData($data);
			if($id){
				$model->setId($id);
			}
			try{
				$model->save();
				$lastId = $model->getId();
				if (isset($links['looks'])) {
		            $itemsLook = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['looks']);
		            foreach ($itemsLook as $itemID => $itemProduct) {		      
		            	$itemsID[] = $itemID;
		            	if($itemID && array_key_exists("position", $itemProduct)){
		            		
		            		$itemLookSave =  Mage::getModel('looks/items');
		            		$this->newItemLook($itemID, $lastId, $itemProduct, $itemLookSave);
		            	}
		            }
		            $items = Mage::getModel('looks/items')
		            	->getCollection()
		            	->addFieldToFilter('product_id',array('nin'=>$itemsID))
		            	->addFieldToFilter('look_id',array("eq"=>$lastId));
					
					
		            $itemDelete = Mage::getModel('looks/items');
					foreach ($items as $item) {
			           	$itemDelete->setItemId($item['item_id']);
			           	$itemDelete->delete();
			        }
		        }
		        if ($lastId && !empty($lookImages)) {
					try{
                        $this->saveGallery($lookImages,$lastId);
                    }
                    catch(Exception $e){
                         Mage::getSingleton('adminhtml/session')->addError($this->__('An error was ocurred saving data: %s', $e->getMessage()));
                    }
				}
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Record was successfully saved.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
			}
			catch (Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($this->__('Not saved. Error: %s', $e->getMessage()));
			}
			$this->_redirect('*/*/');
		}
	}

	public function editAction(){
		$this->_initGallery();
		$id = (int)$this->getRequest()->getParam('id', null);
		Mage::getSingleton('core/session')->setLook($id);
		$model = Mage::getModel('looks/looks');
		if($id){
			$model->load($id);
			if($model->getLookId()){
				Mage::register('data', $model);
				Mage::log($model);
			}
			else{
				Mage::getSingleton('adminhtml/session')->addError($this->__('Does not exist.'));
				$this->_redirect('*/*/');
			}
		}
		$this->loadLayout();
		$this->_addContent($this->getLayout()->createBlock('looks/adminhtml_looks_edit'));
		$this->_addLeft($this->getLayout()->createBlock('looks/adminhtml_looks_edit_tabs'));
		$this->renderLayout();
	}

	public function deleteAction(){
		$id = (int)$this->getRequest()->getParam('id', null);
		if($id){
			try {
				$model = Mage::getModel('looks/looks');
				$model->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Record was successfully deleted.'));
				$this->_redirect('*/*/');
			} catch(Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($this->__('Not deleted. Error: %s', $e->getMessage()));
				$this->_redirect('*/*/edit', array('id' => $id));
				return false;
			}
		}
		$this->_redirect('*/*/');	
	}

	 public function postAction(){
    	$this->loadLayout();
		$this->_addLeft($this->getLayout()->createBlock('looks/adminhtml_looks_edit_tabs'));
    	$this->getLayout()->getBlock('looks.edit.tab.product')->setLooks($this->getRequest()->getPost('looks', null));
    	$this->renderLayout();
    }

    public function newDataLook(array $data,$model){
		$model->setName($data['look_name']);
		$model->setIsVisible($data['look_visibility']);
		$model->setPosition($data['look_position']);
		$model->setLookPrice($data['look_price']);

		return $model;
    }

    public function newItemLook($itemID, $lastId, $itemProduct, $itemLookSave){
    	$itemLooks = Mage::getModel('looks/items')
    		->getCollection()
			->addFieldToFilter('product_id',array("eq"=>$itemID))
			->addFieldToFilter('look_id',array("eq"=>$lastId))
			->getFirstItem();
		 
		if($itemLooks->getData()){
			$itemLookSave->setItemId($itemLooks['item_id']);
		}						
		$itemLookSave->setPosition($itemProduct['position']);
		$itemLookSave->setProductId($itemID);
		$itemLookSave->setLookId($lastId);
		$itemLookSave->save();

		return $itemLookSave;
    }

    public function imageAction() {
        $result = array();
        try {
            $uploader = new Glosbe_Looks_Media_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save(
                Mage::getSingleton('looksgallery/config')->getBaseTmpMediaPath()
            );

            $result['url'] = Mage::getSingleton('looksgallery/config')->getTmpMediaUrl($result['file']);
            $result['file'] = $result['file'] . '.tmp';
            $result['cookie'] = array(
                'name' => session_name(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain()
            );
        } catch (Exception $e) {
            $result = array('error' => $e->getMessage(), 'errorcode' => $e->getCode());
        }

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }

	protected function _isAllowed(){
		return Mage::getSingleton('admin/session')->isAllowed('admin/looks/looks');
	}

	public function saveGallery(array $gallery, $lookId = null) {
        $id = ($this->getRequest()->getParam('id') ? $this->getRequest()->getParam('id') : $lookId);
        foreach ($gallery as $_images) {

            $galleryColletion = Mage::getModel('looks/images');
            $imageData = array(
                "position"   	=> $_images['position'],
                "image_name"    => str_replace(".tmp", "", $_images['file']),
                "look_id"		=> $lookId
            );
            $galleryColletion->setData($imageData);

            if (isset($_images['value_id'])) {
                $galleryColletion->setData($imageData);
                $galleryColletion->load($_images['value_id'], 'image_id');

                if (isset($_images['removed']) and $_images['removed'] == 1) {
                    $galleryColletion->setId($_images['value_id'])->delete();
                }
                else {
                    try{
                        $galleryColletion->setData($imageData);
                        $galleryColletion->setId($_images['value_id']);
                        $galleryColletion->save();
                    }
                    catch(Exception $e){
                        Mage::getSingleton('adminhtml/session')->addError($this->__('An error was ocurred saving data: %s', $e->getMessage()));
                    }
                }
            }
            else {
                try{
                    //$galleryColletion->setImageId($id);
                    $galleryColletion->save();
                }
                catch(Exception $e){
                    Mage::getSingleton('adminhtml/session')->addError($this->__('An error was ocurred saving data: %s', $e->getMessage()));
                }
            }
        }
        $this->_redirect('*/*/');
    }

}