<?php
namespace Ced\CatalogList\Block;

class SinglePage extends \Magento\Framework\View\Element\Template
{
    public $productRepository;
    public $likeCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ced\CatalogList\Model\ResourceModel\Likes\CollectionFactory $likeCollectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->likeCollectionFactory = $likeCollectionFactory;
        $this->productRepository = $productRepository;
    }

    public function getProductBySky($sku)
    {
        return $this->productRepository->get($sku);
    }
    public function getLikeData($sku){
        
        $collection = $this->likeCollectionFactory->create();
        $collection->addFieldToFilter('product_sku', ['eq'=>$sku]);
        return $collection;
    }
}