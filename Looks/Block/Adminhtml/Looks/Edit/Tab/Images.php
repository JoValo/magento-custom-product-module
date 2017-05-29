<?php
/**
 * @author Jorge Martínez <ing.martinez0302@gmail.com>
 * @package  Glosbe
 * @category Glosbe_Looks
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
**/
class Glosbe_Looks_Block_Adminhtml_Looks_Edit_Tab_Images extends Mage_Adminhtml_Block_Widget{

	protected function _prepareForm() {
        $data = $this->getRequest()->getPost();
        $form = new Varien_Data_Form();
        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function images() {
        $data = Mage::registry('looks_gallery');
        $galleryData = $data->getData();

        return $galleryData;
    }

    public function __construct() {
        parent::__construct();
        $this->setTemplate('looks/blank.phtml');
        $this->setId('media_looks_content');
        $this->setHtmlId('media_looks_content');
    }

    //Uploader function: Verify format image and check if delete action 
    protected function _prepareLayout() {
        $this->setChild('uploader', $this->getLayout()->createBlock('adminhtml/media_uploader'));
        $this->getUploader()->getConfig()
                ->setUrl(Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('*/*/image'))
                ->setFileField('image')
                ->setFilters(array(
                    'images' => array(
                        'label' => Mage::helper('adminhtml')->__('Images (.gif, .jpg, .png)'),
                        'files' => array('*.gif', '*.jpg', '*.jpeg', '*.png')
                    )
                ));
        $this->setChild(
                'delete_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->addData(array(
                            'id' => '{{id}}-delete',
                            'class' => 'delete',
                            'type' => 'button',
                            'label' => Mage::helper('adminhtml')->__('Remove'),
                            'onclick' => $this->getJsObjectName() . '.removeFile(\'{{fileId}}\')'
                        ))
        );
        return parent::_prepareLayout();
    }

    /**
     * Retrive uploader block
     *
     * @return Mage_Adminhtml_Block_Media_Uploader
     */
    public function getUploader() {
        return $this->getChild('uploader');
    }

    /**
     * Retrive uploader block html
     *
     * @return string
     */
    public function getUploaderHtml() {
        return $this->getChildHtml('uploader');
    }

    /**
     *
     * @return type
     */
    public function getJsObjectName() {
        return $this->getHtmlId() . 'JsObject';
    }

    /**
     *
     * @return type
     */
    public function getAddImagesButton() {
        return $this->getButtonHtml(
                        Mage::helper('catalog')->__('Add New Images'), $this->getJsObjectName() . '.showUploader()', 'add', $this->getHtmlId() . '_add_images_button'
        );
    }

    /**
     *
     * @return string
     */
    public function getImagesJson() {
        $images = $this->images();
        if (!is_array($images)) {
            return;
        }

        if (empty($images)) {
            return '[]';
        }

        foreach ($images as &$image) {
            $image['url'] = '/media/looks' . $image['image_name'];

            $image['value_id'] = $image['image_id'];
            unset($image['image_id']);

            $image['file'] = $image['image_name'];
            unset($image['image_name']);

            $image['position'] = $image['position'];
        }
        return Zend_Json::encode($images);
    }

    /**
     *
     * @return type
     */
    public function getImagesValuesJson() {
        $values = array();
        return Zend_Json::encode($values);
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    public function getMediaAttributes() {

    }

    /**
     *
     * @return string
     */
    public function getImageTypes() {
        $type = array();
        $type['gallery']['label'] = "slider";
        $type['gallery']['field'] = "slider";

        $imageTypes = array();

        return $type;
    }

    /**
     *
     * @return type
     */
    public function getImageTypesJson() {
        return Zend_Json::encode($this->getImageTypes());
    }

    /**
     *
     * @return type
     */
    public function getCustomRemove() {
        return $this->setChild(
                        'delete_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                                ->addData(array(
                                    'id' => '{{id}}-delete',
                                    'class' => 'delete',
                                    'type' => 'button',
                                    'label' => Mage::helper('adminhtml')->__('Remove'),
                                    'onclick' => $this->getJsObjectName() . '.removeFile(\'{{fileId}}\')'
                                ))
        );
    }

    /**
     *
     * @return type
     */
    public function getDeleteButtonHtml() {
        return $this->getChildHtml('delete_button');
    }

    /**
     *
     * @return type
     */
    public function getCustomValueId() {
        return $this->setChild(
                        'value_id', $this->getLayout()->createBlock('adminhtml/widget_button')
                                ->addData(array(
                                    'id' => '{{id}}-value',
                                    'class' => 'value_id',
                                    'type' => 'text',
                                    'label' => Mage::helper('adminhtml')->__('ValueId'),
                                ))
        );
    }

    /**
     *
     * @return type
     */
    public function getValueIdHtml() {
        return $this->getChildHtml('value_id');
    }
}