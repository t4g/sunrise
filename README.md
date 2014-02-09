Sunrise for WordPress
---------------------

#### Forked to add Composer support

* 09-02-14 By T4g
* Pull request to gndev in motion soon.

## Installation

a) build the project for development

    cd <git cloned directory>
    curl -sS https://getcomposer.org/installer | php -- --install-dir=bin
    php bin/composer.phar install

b) or include it in your own plugin via composer

Add the follow to your composer.json file
 * This version *

         "repositories": [
                 {
                     "type": "vcs",
                     "url": "https://github.com/t4g/sunrise"
                 },
                 {
                     "type": "package",
                     "package": {
                         "name": "gndev/sunrise",
                         "version": "6.0.0",
                         "source": {
                             "url": "https://github.com/gndev/sunrise",
                             "type": "git"
                         }
                     }
                 }
             ],

Then pick between this version or the authors original project.
 * This version *
    "require": {
        ...
        "t4g/sunrise": "6.*",
    }

 * Authors version *
     "require": {
         ...
         "gndev/sunrise": "6.*"
     }



#### Options Pages Framework for WordPress Plugins and Themes

Sunrise is an open-source and OOP-based plugin framework. It can help you to make unlimited number of fast and powerful options pages with native look in your WordPress plugins or themes. It was designed to speed up plugin deployment and development, together with sufficient
functionality.

##### Quick start

Open file _plugin-example.php_ and modify the code as you want. Detailed documentation will be added in closest future. Use native WordPress functions to get and update created options - get_option( $id ), update_option( $id, 'new value' )

##### Useful links

* [Documentation](https://gndev.info/kb/) - __not available yet__ - read the code for more info
* [My Twitter](http://twitter.com/gndevinfo) and [homepage](http://gndev.info/)
* [Page at wordpress.org](http://wordpress.org/plugins/sunrise/)

#### Screenshots

![Regular fields](https://raw.github.com/t4g/sunrise/master/sunrise/assets/help/regular-fields.png), ![Extra fields](https://raw.github.com/t4g/sunrise/master/sunrise/assets/help/extra-fields.png)