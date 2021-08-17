# Magento Storm
### Bringing the fresh breeze to Magento

Working with database objects in Magento is painful to say the least.   
To get everything you need for a single database model you'll need around 10-15 files
with a lot of boilerplate code.

To make relations, queries, etc... forces you to have a lot of repositories to be provided
searchresult helpers and more.

Coming from a Laravel/OctoberCMS/WinterCMS background, this is not fun to code and maintain.  
Hence this library, which will aim to imitate the base Magento models but make them fluent.
With Collections, easy relations, QueryBuilders etc...

### Very minimal

I've striven to keep this library as minimal as possible, by only including the most 
basic functionality for working with everything you're used to, only focussed on the 
database aspects and utility items for working with the database in a fluent way.

Keeping it lean(ish) because Magento is a beast already.
This package installs 22 fresh dependencies in a basic Magento installation.

## Installation
### Preparing composer.json
In your Magento project dir composer.json add this line in the `"require"` segment
> The reason for this installation step is because laravel needs 
> console 5.1.4, but magento uses console ~4.4.  
> We need to trick composer in accepting the lower version dependency
> By using the `as` composer gets tricked, and will install the modules
> This sadly only works in the main project json, and not in dependency jsons.  
> When using an alias a specific version is needed, feel free to update to a more
> Recent version when applicable.

*For Magento 2.4.2-p1*
```json
"symfony/console": "4.4.29 as 5.1.4",
```
### Summoning the storm
In your Magento project dir run the following command from your shell
```bash
composer require tschallacka/mage-storm
```



