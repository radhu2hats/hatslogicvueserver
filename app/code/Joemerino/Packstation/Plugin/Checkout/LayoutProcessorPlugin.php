<?php
/**
* *.
*
*  @author Joemerino Team
*  @copyright Copyright (c) 2018 DCKAP (https://www.dckap.com)
*/

namespace Joemerino\Packstation\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

/**
 * Class LayoutProcessorPlugin.
 */
class LayoutProcessorPlugin
{
    /**
     * @return array
     */
    public function afterProcess(
       LayoutProcessor $subject,
       array $jsLayout
   ) {
        $validation['required-entry'] = true;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['packstation-shipping-method-fields']['children']['packstation_street_address_1'] = [
           'component' => 'Magento_Ui/js/form/element/abstract',
           'config' => [
               'customScope' => 'packstationShippingMethodFields',
               'template' => 'ui/form/field',
               'elementTmpl' => 'ui/form/element/input',
               'id' => 'packstation_street_address_1',
           ],
           'dataScope' => 'packstationShippingMethodFields.packstation_shipping_field[packstation_street_address_1]',
           'label' => 'Postnummer',
           'provider' => 'checkoutProvider',
           'visible' => true,
           'validation' => $validation,
           'sortOrder' => 1,
           'id' => 'packstation_shipping_field[packstation_street_address_1]',
       ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['packstation-shipping-method-fields']['children']['packstation_street_address_2'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'packstationShippingMethodFields',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'id' => 'packstation_street_address_2',
            ],
            'dataScope' => 'packstationShippingMethodFields.packstation_shipping_field[packstation_street_address_2]',
            'label' => 'Packstation Nr',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => $validation,
            'sortOrder' => 2,
            'id' => 'packstation_shipping_field[packstation_street_address_2]',
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['packstation-shipping-method-fields']['children']['packstation_postcode'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'packstationShippingMethodFields',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'id' => 'packstation_postcode',
            ],
            'dataScope' => 'packstationShippingMethodFields.packstation_shipping_field[packstation_postcode]',
            'label' => 'Postleitzahl',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => $validation,
            'sortOrder' => 3,
            'id' => 'packstation_shipping_field[packstation_postcode]',
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['packstation-shipping-method-fields']['children']['packstation_city'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'packstationShippingMethodFields',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'id' => 'packstation_city',
            ],
            'dataScope' => 'packstationShippingMethodFields.packstation_shipping_field[packstation_city]',
            'label' => 'Ort/Stadt',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => $validation,
            'sortOrder' => 3,
            'id' => 'packstation_shipping_field[packstation_city]',
        ];

        return $jsLayout;
    }
}
