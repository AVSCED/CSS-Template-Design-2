<?php
namespace Ced\CatalogList\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Likes extends AbstractDb
{
    public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}

    protected function _construct()
    {
        $this->_init('ced_cataloglist_likes', 'like_id');
    }
}