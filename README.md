<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Sylius Manage Price Plugin</h1>

<p align="center">Mange price for variants and channels </p>

## Quickstart Installation

1. Install plugin
```
   composer require vinium/sylius-manage-price-plugin
```

2. Add bundle on bundles.php

```php
Vinium\SyliusManagePricePlugin\ViniumSyliusManagePricePlugin::class => ['all' => true]
```

3. Add admin routes

Create `config/routes/vinium_manage_price_plugin.yaml` file:
```yaml
vinium_sylius_manage_price_admin:
    resource: "@ViniumSyliusManagePricePlugin/Resources/config/routes/admin.yaml"
    prefix: /%sylius_admin.path_name%
````

4. Create `config/packages/vinium_manage_price_plugin.yaml` file:
```yaml
imports:
    - { resource: '@ViniumSyliusManagePricePlugin/Resources/config/config.yaml' }

````
