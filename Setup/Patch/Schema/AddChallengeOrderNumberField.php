<?php
namespace Certisign\ChallengeOrderNumber\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class AddChallengeOrderNumberField implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('sales_order'),
            'challenge_order_number',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'nullable' => true,
                'comment' => 'Challenge Order Number'
            ]
        );
    }

    public static function getDependencies() { return []; }

    public function getAliases() { return []; }
}
