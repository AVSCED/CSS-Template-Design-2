<?php
namespace Ced\CatalogList\Model\ResourceModel\Likes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ced\CatalogList\Model\Likes as Model;
use Ced\CatalogList\Model\ResourceModel\Likes as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
