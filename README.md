# Bolt Omnipay integration
Omnipay driver for Bolt Checkout

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "boltapp/omnipay-bolt": "^0.5.0"
    }
}
```

And run composer to update your dependencies:
```
$ php composer.phar update
```

## Development
#### Setup phpbrew
Follow instructions at the phpbrew [GitHub repo](https://github.com/phpbrew/phpbrew) to setup it up.

Install any version of php that is greater than 5.4
```
phpbrew install 5.4.0 +default
phpbrew use php-5.4.0
```

If you run into installation errors, look into the phpbrew install command. You are probably missing
some native packages (like mcrypt) which may need to be installed using Homebrew. You also may need to include
`.phpbrew/bashrc` into your `~/.bashrc`
 

#### Setup Composer and download vendor packages
```
curl -s http://getcomposer.org/installer | php
php composer.phar update
```

#### Running tests 
```
cd omnipay-bolt
chmod +x runtests.sh (May not be necessary)
./runtests.sh
```