<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Joemerino\Packstation\Block\Checkout;

use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Store\Api\StoreResolverInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Directory data processor.
 *
 * This class adds various country and region dictionaries to checkout page.
 * This data can be used by other UI components during checkout flow.
 */
class DirectoryDataProcessor extends \Magento\Checkout\Block\Checkout\DirectoryDataProcessor
{
    /**
     * @var array
     */
    private $countryOptions;

    /**
     * @var array
     */
    private $regionOptions;

    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    private $regionCollectionFactory;

    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    private $countryCollectionFactory;

    /**
     * @var StoreResolverInterface
     */
    private $storeResolver;

    /**
     * @var DirectoryHelper
     */
    private $directoryHelper;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollection,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollection,
        StoreResolverInterface $storeResolver,
        DirectoryHelper $directoryHelper,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($countryCollection, $regionCollection, $storeResolver, $directoryHelper);
        $this->countryCollectionFactory = $countryCollection;
        $this->regionCollectionFactory = $regionCollection;
        $this->storeResolver = $storeResolver;
        $this->directoryHelper = $directoryHelper;
        $this->storeManager = $storeManager;
    }

    /**
     * Process js Layout of block.
     *
     * @param array $jsLayout
     *
     * @return array
     */
    public function process($jsLayout)
    {
        if (!isset($jsLayout['components']['checkoutProvider']['dictionaries'])) {
            $jsLayout['components']['checkoutProvider']['dictionaries'] = [
                'country_id' => $this->getCountryOptions(),
                'region_id' => $this->getRegionOptions(),
            ];
        }

        return $jsLayout;
    }

    /**
     * Get country options list.
     *
     * @return array
     */
    private function getCountryOptions()
    {
        if (!isset($this->countryOptions)) {
            $this->countryOptions = $this->countryCollectionFactory->create()->loadByStore(
                $this->storeManager->getStore()->getId()
            )->toOptionArray();
            $this->countryOptions = $this->orderCountryOptions($this->countryOptions);
        }

        return $this->countryOptions;
    }

    /**
     * Get region options list.
     *
     * @return array
     */
    private function getRegionOptions()
    {
        if (!isset($this->regionOptions)) {
            $this->regionOptions = $this->regionCollectionFactory->create()->addAllowedCountriesFilter(
                $this->storeManager->getStore()->getId()
            )->toOptionArray();
        }

        return $this->regionOptions;
    }

    /**
     * Sort country options by top country codes.
     *
     * @return array
     */
    private function orderCountryOptions(array $countryOptions)
    {
        $topCountryCodes = $this->directoryHelper->getTopCountryCodes();
        if (empty($topCountryCodes)) {
            return $countryOptions;
        }

        $headOptions = [];
        $tailOptions = [[
            'value' => 'delimiter',
            'label' => '──────────',
            'disabled' => true,
        ]];
        foreach ($countryOptions as $countryOption) {
            if (empty($countryOption['value']) || in_array($countryOption['value'], $topCountryCodes)) {
                array_push($headOptions, $countryOption);
            } else {
                array_push($tailOptions, $countryOption);
            }
        }

        return array_merge($headOptions, $tailOptions);
    }
}
