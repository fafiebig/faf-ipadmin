# faf-ipadmin

Wordpress Plugin to restrict IPs access to Admin Site.

# Installation

* Unzip and upload the plugin to the **/wp-content/plugins/** directory
* Activate the plugin in WordPress
* Got to plugins page and use the optimization.

# If you kill yourself

* set **$restrict to false** on line **28** in **/wp-content/plugins/faf-ipadmin.php** to regain access to admin

# Installation with composer

* Add the repo to your composer.json

```json

"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/fafiebig/faf-ipadmin.git"
    }
],

```

* require the package with composer

```shell

composer require fafiebig/faf-ipadmin 1.*

```