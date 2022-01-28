<?php

declare(strict_types=1);

namespace Vinium\SyliusManagePricePlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        if (null !== $catalogMenu = $menu->getChild('catalog')) {
            $catalogMenu->addChild('manage-price', ['route' => 'sylius_admin_manage_price_index'])
                ->setLabel('vinium_sylius_manage_price_plugin.ui.label')
                ->setAttribute('type', 'link')
                ->setLabelAttribute('icon', 'cog');
        }
    }
}
