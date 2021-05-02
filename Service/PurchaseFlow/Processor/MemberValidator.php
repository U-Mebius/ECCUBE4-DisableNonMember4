<?php

/*
 * This file is part of DisableNonMember4
 *
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 *
 * https://umebius.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\DisableNonMember4\Service\PurchaseFlow\Processor;

use Eccube\Annotation\ShoppingFlow;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\ItemHolderInterface;
use Eccube\Entity\Order;
use Eccube\Service\PurchaseFlow\InvalidItemException;
use Eccube\Service\PurchaseFlow\ItemHolderValidator;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\ItemValidator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @ShoppingFlow
 */
class MemberValidator extends ItemHolderValidator
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * DeliveryFeePreprocessor constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(
        RequestStack $requestStack,
        EccubeConfig $eccubeConfig
    ) {
        $this->requestStack = $requestStack;
        $this->eccubeConfig = $eccubeConfig;
    }


    /**
     * @param ItemHolderInterface $itemHolder
     * @param PurchaseContext $context
     * @throws InvalidItemException
     */
    protected function validate(ItemHolderInterface $itemHolder, PurchaseContext $context)
    {
        /* @var $Order Order */
        $Order = $itemHolder;

        if (!$Order->getCustomer()) {
            $this->throwInvalidItemException('please.login.to.purchase', null, false);
        }

    }

    protected function handle(ItemHolderInterface $item)
    {

    }
}
