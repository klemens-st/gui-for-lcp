# GUI for List Category Posts

This WordPress plugin adds a graphical shortcode creator for the [List Category Posts](https://wordpress.org/plugins/list-category-posts/)
plugin. The creator is available in WordPress editor by clicking the 'LCP' button in the editor's toolbar.

This repository contains a development version of the plugin, with build tools and testing environment configurations.
If you just download this repository and add it to your WordPress installation it *won't work*.
Production releases are available on the [plugin's page in WordPress.org plugin directory](https://wordpress.org/plugins/gui-for-lcp).

## Support

Please use the [WordPress support forum](https://wordpress.org/support/plugin/gui-for-lcp/)
for **user support** and any **questions about how to use the plugin**.
[Github issues](https://github.com/zymeth25/gui-for-lcp/issues) should only be used for **bug reports**,
**feature requests** and other code-related topics.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

The actual plugin code is located in the `gui-for-lcp` directory, everything above it is config, docs and build tools.

The testing environment is a Vagrant box powered by [VCCW](http://vccw.cc/).

### Prerequisites

The build is run by npm, for all its tasks to work you need to have [Node.js](https://nodejs.org/en/) installed:

The virtual machine used for testing needs:

* [Vagrant](https://www.vagrantup.com/downloads.html)
* [VirtualBox](https://www.virtualbox.org/wiki/Downloads)


### Installing

Fork the repo, clone it locally and cd into its root directory.

#### Install dependencies.

```
npm install
```

#### Set up a Vagrant box

```
vagrant up
```
The above command will:
* Create and provision a new virtual machine (Ubuntu + LAMP stack + WordPress)
* Create a `wordpress` directory and mount it on the virtual box's WordPress installation.
* Mount the `gui-for-lcp` directory on the following virtual box directories: 
  * `/vagrant`
  * `wp-content/plugins/gui-for-lcp` in the WordPress directory
  
Any changes in the mounted directories are reflected in the Vagrant box.


## Testing and developing

If the Vagrant box is not active run `vagrant up`. Then in your browser navigate to http://192.168.33.10/

WP admin login:
* Username: `admin`
* Password: `admin`


To avoid running build scripts manually every time you change SCSS or JS files, a watch task has been set up.
```
npm run watch
```
This will automatically compile CSS files and bundle JS whenever you change the source.
Files generates by this task are not fit for production, however.

#### Build for production

```
npm run build
```

### Automated tests

Currently there is no testing suite, but PHP Code Sniffer has been set up to enforce WordPress Coding Standards.

Ssh into the box by running
```
vagrant ssh
```

Then cd into `/vagrant` directory and run 
```
phpcs -p
```

## Contributing

Please read [CONTRIBUTING.md](https://github.com/zymeth25/gui-for-lcp/blob/master/.github/CONTRIBUTING.md)
for details on the process for submitting pull requests.

## Versioning

I use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/zymeth25/gui-for-lcp/tags). 

## License

This project is licensed under the GPL-3.0 License - see the [LICENSE.txt](LICENSE.txt) file for details
