<?php
/**
 * @package   Hatslogic\CartSync
 * @author    Radhu 2Hats <radhu@2hatslogic.com>
 * @copyright 2022 2Hatslogic.
 * @license   See LICENSE.txt for license details.
 */

namespace Hatslogic\CartSync\Service;

/**
 * Interface SyncInterface
 */
interface SyncInterface
{

    /**
     * @param int $customerId
     * @param int $cartId
     *
     * @return SyncInterface|false
     */
    public function synchronizeCustomerCart($customerId, $cartId);

    /**
     * @param string $cartId
     *
     * @return SyncInterface|false
     */
    public function synchronizeGuestCart(string $cartId);
}
