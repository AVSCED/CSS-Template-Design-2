<?php 
namespace Ced\CatalogList\Controller\Like;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class Index extends \Magento\Framework\App\Action\Action{

    protected $_likes;
    protected $resultRedirect;
    protected $messageManager;

    protected $cacheTypeList;
    protected $cacheFrontendPool;

    public function __construct(\Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $result,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Ced\CatalogList\Model\LikesFactory  $likes, TypeListInterface $cacheTypeList, 
        Pool $cacheFrontendPool){
            parent::__construct($context);
            $this->messageManager = $messageManager;
            $this->resultRedirect = $result;
            $this->_likes = $likes;

            $this->cacheTypeList = $cacheTypeList;
            $this->cacheFrontendPool = $cacheFrontendPool;
    }
	public function execute(){
        $resultRedirect = $this->resultRedirect->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        $ip = $this->getRequest()->getParam('ip');
        $id = $this->getRequest()->getParam('id');
        $action = $this->getRequest()->getParam('action');

		$model = $this->_likes->create();
        if($action == "like"){
            $model->addData([
                "product_sku" => $id,
                "ip_address" => $ip
                ]);
            $status = "Liked Successfully";
        } else{
            try {
                $model = $this->_likes->create();
                $model->load($id);
                $model->delete();
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
            $status = "Disliked Successfully";
        }
        $saveData = $model->save();

        if($saveData){
            $this->messageManager->addSuccess( __($status) );
        }
        $types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');
        foreach ($types as $type) {
            $this->cacheTypeList->cleanType($type);
        }
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }

		return $resultRedirect;
	}
}
 ?>