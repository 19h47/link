# Link 🔗

Initially built for the [J'veux être bonne Blog](http://www.jveuxetrebonne.com/), __Link__ is a __WordPress__ plugin for create a custom post type and a custom category associate to __Link__.
__Link__ CPT is like the good old blogroll. Blogroll isn't supported anymore in __WordPress__, it's in source code but only for backward compatibility purpose.

This is the purpose of this plugin: bring back to life blogroll! 🙏

![Status](assets/screenshot.png)

## Feature

A __Link__ can have:

- an URL, save as `link_url` in _post_meta_,

- a color, save as `link_color` in _post_meta_,

- a description, save as `link_description` in _post_meta_,

- For image the custom post type used the built in thumbnail functionality.

- The link plugin offers the possibility to order links in backoffice. Thanks to `menu_order`.

__WordPress__, since [3.5](https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/) version, ship in its core a [color picker](https://github.com/automattic/Iris).

![Columns](img/link-columns.png "Columns")

## PHPCS

### Install the WordPress rules

Add __PHP_CodeSniffer__ to the `composer.json` file

```json
{
    "require": {
        "squizlabs/php_codesniffer": "*"
    }
}
```

Then update dependencies

```bash
composer update
```

Create the project

```bash
Make create-project
```

### Add the Rules to PHP CodeSniffer

```bash
Make config-set
```

## References

- [WordPress plugin boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate)

Thanks to [DevinVinson](https://github.com/DevinVinson), I learn a lot. 🙏
