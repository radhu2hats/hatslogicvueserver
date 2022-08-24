<?php

namespace Joemerino\Packstation\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class SavePackstationObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        $quoteRepository = $this->_objectManager->create('Magento\Quote\Model\QuoteRepository');
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        if ($shippingMethod == 'packstation_packstation') {
            $order = $observer->getEvent()->getOrder();
            $quote = $observer->getEvent()->getQuote();
            $order->getShippingAddress()->setCompany($quote->getPackstationStreetAddress1());
            $order->getShippingAddress()->setStreet(
                [
                    'Packstation',
                    $quote->getPackstationStreetAddress2(),
                ]
            );
            $order->getShippingAddress()->setPostcode($quote->getPackstationPostcode());
            $order->getShippingAddress()->setCity($quote->getPackstationCity());
            $order->setData('packstation_street_address_1', $quote->getPackstationStreetAddress1());
            $order->setData('packstation_street_address_2', $quote->getPackstationStreetAddress2());
            $order->setData('packstation_postcode', $quote->getPackstationPostcode());
            $order->setData('packstation_city', $quote->getPackstationCity());
        }
        return $this;
    }
}
