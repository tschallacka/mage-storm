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

For documentation on how to make queries, queries on relations etc... I'd like to refer you to the
[WinterCms documentation](https://wintercms.com/docs/database/basics) Only the database parts of the doucmentation 
are relevant, the CMS parts etc... are excluded from this library to keep the size small.

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

### Configuration

Default connections will be gleaned from app/etc/env.php and added to the eloquent connection manager
under the names as they are defined there.

If you wish to use other databases like postgres, sqlite, etc... define them under `['magestorm']['connections']`
in env.php like WinterCms requires it. See for the [WinterCms documentation](https://wintercms.com/docs/database/basics) on the configuration values that are accepted. 
Do note that the connections you define under `['magestorm']` cannot be used by Magento, only by MageStorm/Storm Models.

example:

```php
return [
    'backend' => ....
    ...
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'magento',
                'username' => 'magento',
                'password' => 'magento-dev-password',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1',
                'driver_options' => [
                    1014 => false
                ]
            ]
        ]
    ],
    'magestorm' => [
        'connections' => [
            'other_connection_name' => [
                'read' => [
                    'host' => '192.168.1.1',
                ],
                'write' => [
                    'host' => '196.168.1.2'
                ],
                'driver'    => 'mysql',
                'database'  => 'database',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],
            'sqlite_testing' => [
                'driver' => 'sqlite',
                'database' => 'patho/to/testing-db.sqlite',
                'prefix' => '',
            ],
        ]
    ],
    ....
```

## Usage

### Commands

```bash
bin/magento storm:create:model [Module_Name] [ModelName] [Path(Default: "Models")]
```

Creates a new default blank Model file at `path/to/magento/app/code/Module/Name/Path/ModelName.php` with as database name a snake_case version of ModelName
The Path argument is optional. When omitted it will place the files in the Models directory within your module.

Refer to [WinterCms documentation](https://wintercms.com/docs/database/basics) and all the other articles there under Database on how to work with the models if you are not familiar with Laravel / OctoberCms / WinterCMS.

### Table creation

For table creation, instead of using migrations like Laravel / OctoberCMS / WinterCMS uses I recommend to use the [Declarative Schema of Magento](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/declarative-schema/db-schema.html). When using something else than a Magento Database you'll need to work your way around that by using migrations or other methods to update your database schemas.
