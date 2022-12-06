<?php

namespace Ced\CatalogList\Model;

use Magento\Framework\Model\AbstractModel;
use Ced\CatalogList\Model\ResourceModel\Likes as ResourceModel;

class Likes extends AbstractModel 
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}