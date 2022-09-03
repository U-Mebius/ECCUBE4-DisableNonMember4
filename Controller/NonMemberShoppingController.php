<?php

/*
 * This file is part of DisableNonMember42
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 * https://umebius.com/
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\DisableNonMember42\Controller;

use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NonMemberShoppingController extends AbstractController
{
    /**
     * 非会員処理
     *
     * @Route("/shopping/nonmember", name="shopping_nonmember")
     */
    public function index(Request $request)
    {
        return $this->redirectToRoute('shopping_login');
    }
}
