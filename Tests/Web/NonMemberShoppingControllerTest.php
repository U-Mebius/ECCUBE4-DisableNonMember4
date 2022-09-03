<?php

/*
 * This file is part of DisableNonMember42
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 * https://umebius.com/
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\DisableNonMember42\Tests\Web;

use Eccube\Tests\Web\AbstractWebTestCase;

/**
 * Class NonMemberShoppingControllerTest.
 */
class NonMemberShoppingControllerTest extends AbstractWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test render maker.
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->generateUrl('shopping_nonmember'));
        $this->assertEquals($this->client->getResponse()->isRedirect(), true);
    }
}
