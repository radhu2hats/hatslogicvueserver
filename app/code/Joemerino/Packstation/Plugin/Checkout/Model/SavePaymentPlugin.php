<?php

namespace Joemerino\Packstation\Plugin\Checkout\Model;

class SavePaymentPlugin
{
    protected $orderRepository;
    protected $paymentFactory;
    protected $logger;
    protected $quoteRepository;

    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Quote\Api\Data\PaymentExtensionFactory $paymentFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentFactory = $paymentFactory;
        $this->logger = $logger;
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeSavePaymentInformation(
        \Magento\Checkout\Api\PaymentInformationManagementInterface $subject,
        $cartId,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
    ) {
        $extAttributes = $paymentMethod->getExtensionAttributes();
        $quote = $this->quoteRepository->getActive($cartId);
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        if ($shippingMethod == 'packstation_packstation') {
            $streetAddress1 = $extAttributes->getPackstationStreetAddress1();
            $streetAddress2 = $extAttributes->getPackstationStreetAddress2();
            $postcode = $extAttributes->getPackstationPostCode();
            $city = $extAttributes->getPackstationCity();

            $quote->setPackstationStreetAddress1($streetAddress1);
            $quote->setPackstationStreetAddress2($streetAddress2);
            $quote->setPackstationPostcode($postcode);
            $quote->setPackstationCity($city);
        }
    }
}
