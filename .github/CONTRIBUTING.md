# Contributing

When contributing to this repository, please first discuss the change you wish to make via issue.

## Issues and Pull Requests

Please use provided templates for issues and pull requests. If you don't give the details these templates ask for
it will be harder to address your issue and/or review your code.

## Coding Style

This repository adheres (or at least tries :wink:) to [WordPress Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards)
for PHP and JavaScript. The exceptions are:

* Indentation with spaces, not tabs
* PHP indentation: 2 spaces

The code you submit should follow these rules.

### PHP

For PHP files is enforced by PHP Code Sniffer with the `WordPress` standard.
Refer to the [official repository](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) for more information.

[README.md](https://github.com/zymeth25/gui-for-lcp) contains information on how to use PHP Code Sniffer in this project.
This is very helpful in fixing style issues. You can also use the `phpcbf` command to
[resolve some style issues automatically](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically).

### JavaScript

Currently there are no automated style checks for JS files so please double-check your code. Eslint is set up but in only
performs basic syntax checks.

If you have any style related questions you can include them in your PR's description or in a related issue.

## Pull Request Process

1. Discuss your changes in an issue first.
2. Make sure the `grunt` command runs without errors.
3. Make sure the `phpcs` command runs without errors or warnings. Remember this should be executed on the Vagrant machine.
4. Open a new pull request by filling out the template.
