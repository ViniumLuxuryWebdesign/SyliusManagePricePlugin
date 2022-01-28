<?php

declare(strict_types=1);

namespace Vinium\SyliusManagePricePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('vinium_sylius_manage_price_plugin');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
