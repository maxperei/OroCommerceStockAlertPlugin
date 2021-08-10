<?php

namespace Synolia\Bundle\StockAlertBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class SynoliaStockAlertBundleInstaller implements Installation
{
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createSynoliaStockAlertTable($schema);

        /** Foreign keys generation **/
        $this->addSynoliaStockAlertForeignKeys($schema);
    }

    protected function createSynoliaStockAlertTable(Schema $schema)
    {
        $table = $schema->createTable('synolia_stock_alert');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('product_id', 'integer', []);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('customer_id', 'integer', ['notnull' => false]);
        $table->addColumn('customer_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('serialized_data', 'array', ['notnull' => false, 'length' => 0, 'comment' => '(DC2Type:array)']);
        $table->addColumn('expiration_date', 'datetime', ['notnull' => false, 'length' => 0, 'comment' => '(DC2Type:datetime)']);
        $table->addColumn('created_at', 'datetime', ['length' => 0, 'comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['length' => 0, 'comment' => '(DC2Type:datetime)']);
        $table->addIndex(['customer_id'], 'IDX_ED3196649395C3F3', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_owner_id'], 'IDX_ED3196649EB185F9', []);
        $table->addIndex(['organization_id'], 'IDX_ED31966432C8A3DE', []);
        $table->addIndex(['customer_user_id'], 'IDX_ED319664BBB3772B', []);
        $table->addIndex(['product_id'], 'IDX_ED3196644584665A', []);
    }

    protected function addSynoliaStockAlertForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('synolia_stock_alert');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_product'),
            ['product_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_customer'),
            ['customer_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_customer_user'),
            ['customer_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }
}
