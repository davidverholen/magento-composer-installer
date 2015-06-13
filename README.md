# Magento Composer Installer

[![Build Status](https://travis-ci.org/davidverholen/magento-composer-installer.svg?branch=1.1)](https://travis-ci.org/davidverholen/magento-composer-installer)

## Supported Types:

magento-module  
magento-core  



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
