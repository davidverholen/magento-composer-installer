# Magento Composer Installer

## Supported Types:

magento-module  
magento-core  
magento-theme (currently just the same as magento-module)  



## Core Installer

### Installation

to Install the Magento Core require magento/core in your composer.json.  
Magento will be copied to the Magento root dir (Default: 'magento')  

```json
{
    "require": {  
        "davidverholen/magento-composer-installer": "~1",  
        "magento/core": "~1.9"  
    },  
    "extra": {  
        "magento-root-dir": "magento"  
    }  
}
```

### Persistent Files

There are several persistent files and directories, that will be backed up and restored after core deployment:  

var  
media  
app/etc/local.xml  

You can also define additional Files to be persistent such as local Modules  

```json
{
    "require": {  
        "bragento/magento-composer-installer": "~1",  
        "magento/core": "~1.9"  
    },  
    "extra": {  
        "magento-root-dir": "magento",
        "persistent-files": [
            "somefile",
            "app/code/local/Vendor/SomeModule",
            "app/etc/modules/Vendor_SomeModule.xml"
        ]
    }  
}
```


## Module Installer

### Install a Module

Just require the Modules in your composer.json.

Many composer installable Magento extensions are listed under <a href="http://packages.firegento.com">packages.firegento.com</a>  
There is also an example of how to add a composer package directly from a github (or any git) Repository

```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "packages.firegento.com"
        },
        {
            "type": "git",
            "url": "https://github.com/danslo/ApiImport.git"
        }
    ],
    "require": {  
        "davidverholen/magento-composer-installer": "~1",  
        "magento/core": "~1.9",
        "firegento/magesetup": "~2",
        "danslo/api-import": "~1"
    },  
    "extra": {  
        "magento-root-dir": "magento"  
    }  
}
```

### Change Deploy Strategy

By default, all Modules are deployed by symlink. You can change this behaviour with the config key 'magento-deploystrategy'  

Possible values are:  
symlink  
copy  
none  (will just install the Module but not deploy it to magento root)

```json
{ 
    "extra": {  
        "magento-deploystrategy": "copy"  
    }  
}
```

### Overwrite Deploy Strategy per Module

You can also overwrite the Deploy Strategy for specific Modules under the config key magento-deploystrategy-overwrite  

```json
{ 
    "repositories": [
        {
            "type": "composer",
            "url": "packages.firegento.com"
        }
    ],
    "require": {  
        "davidverholen/magento-composer-installer": "~1",  
        "magento/core": "~1.9",
        "firegento/magesetup": "~2"
    },  
    "extra": {  
        "magento-deploystrategy": "symlink",
        "magento-deploystrategy-overwrite": {
            "firegento/magesetup": "copy"
        }
    }  
}
```

### Auto Append Gitignore

You can define that deployed files will be automatically added to .gitignore in magento root

```json
{
    "extra": {  
        "auto-append-gitignore": true
    }  
}
```

