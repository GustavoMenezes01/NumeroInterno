<?php
namespace Certisign\ChallengeOrderNumber\Plugin;

use Magento\Sales\Block\Order\View as Subject;

class OrderViewPlugin
{
    protected static $rendered = false;

    public function afterToHtml(Subject $subject, $result)
    {
        if (self::$rendered) {
            return $result;
        }

        $order = $subject->getOrder();
        $number = $order->getData('challenge_order_number');

        if ($number) {
            $html = '<div">
                        <strong>CERTISIGN:</strong> Número interno do pedido: ' . $number . '
                     </div>';
            self::$rendered = true;
            return $html . $result;
        }

        return $result;
    }
}
