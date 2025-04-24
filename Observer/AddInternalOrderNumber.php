<?php
namespace Certisign\ChallengeOrderNumber\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;

class AddInternalOrderNumber implements ObserverInterface
{
    protected $resource;
    protected $logger;

    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();

            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('sales_order');
            $internalOrderNumber = (int) $connection->fetchOne("SELECT MAX(challenge_order_number) FROM {$tableName}");

            $internalOrderNumberSequence = $internalOrderNumber + rand(1, 10);
            $order->setData('challenge_order_number', $internalOrderNumberSequence);

        } catch (\Throwable $e) {
            $this->logger->error('[Observer] Erro ao gerar número interno: ' . $e->getMessage());
        }
    }
}
