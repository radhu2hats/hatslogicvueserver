<?php
/**
 * @package   Hatslogic\CartSync
 * @author    Maciej Daniłowicz <mdaniłowicz@divante.pl>
 * @copyright 2022 2Hatslogic.
 * @license   See LICENSE.txt for license details.
 */

namespace Hatslogic\CartSync\Observer;

use Hatslogic\CartSync\Model\Config;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SuccessObserver
 *
 * @package Hatslogic\CartSync\Observer
 */
class SuccessObserver implements ObserverInterface
{
    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $url = $this->config->getVueStorefrontSuccessUrl();
        
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getIncrementId();
        if ($url && $url !== '') {
            if (!(strpos($url, "http://") !== false || strpos($url, "https://") !== false)) {
                $url = 'https://' . $url;
            }
            header("Location: " . $url.'?order='.$orderId);
            die();
        }
    }
}
