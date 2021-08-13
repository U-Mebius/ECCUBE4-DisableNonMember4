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

namespace Plugin\DisableNonMember4;

use Eccube\Controller\NonMemberShoppingController;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        ContainerInterface $container,
        AuthorizationCheckerInterface $authorizationChecker,
        RouterInterface $router
    ) {
        $this->container = $container;
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            EccubeEvents::FRONT_CART_BUYSTEP_COMPLETE => 'onFrontCartBuystepComplete',
            'Shopping/login.twig' => 'onShoppingLoginTwigRender',
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controllers = $event->getController();
        if (!is_array($controllers)) {
            return;
        }

        foreach ($controllers as $controller) {
            if ($controller instanceof NonMemberShoppingController) {
                $event->setController(function () {
                    return new RedirectResponse($this->router->generate('entry'));
                });
                break;
            }
        }
    }

    public function onFrontCartBuystepComplete(EventArgs $eventArgs)
    {
        // IS_AUTHENTICATED_REMEMBEREDの場合はShoppingControllerからリダイレクトされてくるのでROLE_USERにしておく
        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->container->get('router')->generate('shopping_login'));
            $eventArgs->setResponse($response);
        }
    }

    public function onShoppingLoginTwigRender(TemplateEvent $event)
    {
        $event->addAsset('@DisableNonMember4/shopping_login_css.twig');
        $event->addSnippet('@DisableNonMember4/shopping_login.twig');
    }
}
