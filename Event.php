<?php

namespace Plugin\DisableNonMember4;

use Eccube\Event\TemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopping/login.twig' => 'onShoppingLoginTwigRender'
        ];
    }


    public function onShoppingLoginTwigRender(TemplateEvent $event)
    {
        $event->addSnippet('@DisableNonMember4/shopping_login.twig');
    }
}
