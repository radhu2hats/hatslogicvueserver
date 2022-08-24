<?php
/**
* *.
*
*  @author DCKAP Team
*  @copyright Copyright (c) 2018 DCKAP (https://www.dckap.com)
*/

namespace Joemerino\Packstation\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema.
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /* While module install, creates columns in quote_address and sales_order_address table */

        $eavTable1 = $installer->getTable('quote');
        $eavTable2 = $installer->getTable('sales_order');

        $columns = [
           'packstation_street_address_1' => [
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'nullable' => true,
               'comment' => 'Postnummer',
           ],

           'packstation_street_address_2' => [
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'nullable' => true,
               'comment' => 'Packstation Nr',
           ],

           'packstation_postcode' => [
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'nullable' => true,
               'comment' => 'Postleitzahl',
           ],
           'packstation_city' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Ort/Stadt',
            ],
       ];

        $connection = $installer->getConnection();
        foreach ($columns as $name => $definition) {
            $connection->addColumn($eavTable1, $name, $definition);
            $connection->addColumn($eavTable2, $name, $definition);
        }
        $installer->endSetup();
    }
}
