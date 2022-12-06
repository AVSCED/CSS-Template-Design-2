<?php

namespace Ced\CatalogList\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('ced_cataloglist_likes')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('ced_cataloglist_likes')
			)
				->addColumn(
					'like_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'ID'
				)
				->addColumn(
					'product_sku',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Product SKU'
				)
				->addColumn(
					'ip_address',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'IP Address'
				)
				->setComment('Like Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('ced_cataloglist_likes'),
				$setup->getIdxName(
					$installer->getTable('ced_cataloglist_likes'),
					['product_sku', 'ip_address'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['product_sku', 'ip_address'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}