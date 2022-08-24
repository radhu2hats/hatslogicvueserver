<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Joemerino\Packstation\Plugin\Checkout\Model;

use Magento\Checkout\Model\GuestPaymentInformationManagement;
use Magento\Checkout\Model\Session;

/**
 * Plugin to convert shopping cart from persistent cart to guest cart before order save when customer not logged in.
 *
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class GuestSavePaymentPlugin
{
    /**
     * Persistence Session Helper.
     *
     * @var \Magento\Persistent\Helper\Session
     */
    private $persistenceSessionHelper;

    /**
     * Persistence Data Helper.
     *
     * @var \Magento\Persistent\Helper\Data
     */
    private $persistenceDataHelper;

    /**
     * Customer Session.
     *
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * Checkout Session.
     *
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * Quote Manager.
     *
     * @var \Magento\Persistent\Model\QuoteManager
     */
    private $quoteManager;

    /**
     * Cart Repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * Initialize dependencies.
     */
    public function __construct(
        \Magento\Persistent\Helper\Data $persistenceDataHelper,
        \Magento\Persistent\Helper\Session $persistenceSessionHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Persistent\Model\QuoteManager $quoteManager,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository
    ) {
        $this->persistenceDataHelper = $persistenceDataHelper;
        $this->persistenceSessionHelper = $persistenceSessionHelper;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->quoteManager = $quoteManager;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Convert customer cart to guest cart before order is placed if customer is not logged in.
     *
     * @param string $cartId
     * @param string $email
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSavePaymentInformation(
        GuestPaymentInformationManagement $subject,
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {
        $quoteId = $this->checkoutSession->getQuoteId();
        $quote = $this->cartRepository->get($quoteId);
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        if ($shippingMethod == 'packstation_packstation') {
            $extAttributes = $paymentMethod->getExtensionAttributes();

            $streetAddress1 = $extAttributes->getPackstationStreetAddress1();
            $streetAddress2 = $extAttributes->getPackstationStreetAddress2();
            $postcode = $extAttributes->getPackstationPostCode();
            $city = $extAttributes->getPackstationCity();

            $quote->setPackstationStreetAddress1($streetAddress1);
            $quote->setPackstationStreetAddress2($streetAddress2);
            $quote->setPackstationPostcode($postcode);
            $quote->setPackstationCity($shippingMethod);
            $this->cartRepository->save($quote);
        }
    }
}
