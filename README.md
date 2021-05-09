# Theme Updater
This is a [WinterCMS](https://wintercms.com) plugin that supports the semi-automatic update of theme.

For the sake of this plugin, the term *master theme* relates to a theme template that that will be used in one or more
websites. This template theme is located the themes directory of [WinterCMS](https://wintercms.com).

The term *child theme* relates to a theme that is used by [WinterCMS](https://wintercms.com) in displaying website 
content. The theme is again located in the themes directory of [WinterCMS](https://wintercms.com).

## Installation

Use Composer to install the plugin by executing 

```
composer require mercator/wn-themeupdater-plugin
```

## Artisan commands
### php artisan theme:copy master child
The command **php artisan theme:copy *master* *child* *** produces a copy of the theme *master* and calls it *child*. 
Upon completion, it executes the script *themekeeping/install.php* located in the *master* theme, which allows 
modifications to the created *child* theme. See examples for a set of pre-defined commands.

### php artisan theme:update master child
The command **php artisan theme:update *master* *child* *** updates defined parts of the *child* theme with the 
*master* theme. It does so by calling the script *themekeeping/install.php* located in the *child* theme. 
See examples for a set of pre-defined commands.

## Prepare your theme for auto updates
In the master theme, create a directory called *themekeeping* (themes housekeeping). This directory must one or both of
the following files:

- *install.php*, called as part of the *Artisan copy* command after the master theme has been cloned.
- *update.php*, called as part of the *Artisan copy* when the child theme should be updated from the master. Note that 
this file will be copied initially (once) from the master to the child. The *update.php* in the child will be called.

## Commands


### $updater->backup(location)
Backs up *location* of the child there to a temporary location. *location* can either be an individual file or a directory.
*location* is relative to the root of the client, e.g., ``$updater->backup("asssts")``backs up the assets directory.

### $updater->restore(location)
Restores the directory or file specified in *location* to the child there. 
Again,  *location* is relative to the root of the client, e.g., ``$updater->backup("asssts")``backs up the assets directory.

### $updater->remove(location)
Removes a file or directory from the child theme.

### $updater->replace(location)
Replaces the file or directory from the child theme with the master theme after having first delete the 
file or directory in the child theme.

### $updater->mastercopy(from, to )
Copies a file or directory from the master theme (*from*) to the child theme (*to*). Existing files will be overwritten.

### $updater->childcopy(from, to )
Copies a file or directory locally in the child theme. Existing files will be overwritten. For example, if the master
theme holds a config file in assets, that the user needs to adapt, you can copy it as follows:
``` 
childcopy("assets/config.yaml.temaplate", ""assets/config.yaml")
```

And of course, you can use any other PHP command in *install.php* and *update.php*. The following two functions might
come hany in that context:

### $updater->master_path()
Returns the fully qualified name to the root directory of the master.

### $updater->child_path()
Returns the fully qualified name to the root directory of the child.

### file_exists_child(location)
Returns true if the file or directory exists in the child. False otherwise.

### file_exists_master(location)
Returns true if the file or directory exists in the master. False otherwise.


## Examples
If your theme follows a typical implementation, you often only want to update assets and theme.yaml. *update.php* 
would then look as follows
```
<?php
$updater->replace("assets");
$updater->replace("theme.yaml");
```
To update, call the following from the console:
``` 
php artisan theme:copy mater child
``

If you want to update layouts from the master, but keep the existing *default.htm*, back it up and restore afterwards:
```
<?php
$updater->backup("layouts/default.htm");
$updater->replace("layouts");
$updater->restore("layouts/default.htm");
$updater->replace("assets");
$updater->replace("theme.yaml");

```

If you need to call a specific function *yourFunction* to configure a theme after it has been copied, your *install.php*
could look as follows:
<?php
$res = yourFunction($updater->child_path()); // call yourFunction and pass child path

```



