=== GUI for List Category Posts ===
Contributors: zymeth25
Donate link: https://www.paypal.com/donate?hosted_button_id=BX4TN5Z4MSX52
Tags: list, categories, posts, gui
Requires at least: 4.6
Tested up to: 5.7
Requires PHP: 5.4
Stable tag: 2.0.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

This plugin adds a graphical shortcode creator for the List Category Posts plugin, accessible via the "LCP" button in WordPress editor.

== Description ==

This plugin adds a graphical shortcode creator for the [List Category Posts](https://wordpress.org/plugins/list-category-posts/) plugin by Fernando Briano. The creator is available in WordPress editor by clicking the 'LCP' button of the editor's toolbar.

This means you can use the shortcode creator in:

* Post Editing Screen
* Text Widgets
* Gutenberg's 'Classic' block
* and wherever the WYSIWYG editor is used in plugins and themes

Make sure you have read the [LCP plugin's detailed documentation](https://github.com/picandocodigo/List-Category-Posts/wiki) as well as its readme to understand its features and potential. This is important because even though the GUI provided here tries to make things easily understandable on the front-end, it *does not* explain all features of the base plugin in detail.

==How to use the plugin==

Clicking the 'LCP' button opens a modal window with a form.

The shortcode creator has two sections, divided in two tabs:

1. Selection options
2. Display options

'Selection options' allow you to choose which posts to include while 'Display options' manage what information about selected posts is displayed and what [HTML & CSS customizations](https://github.com/picandocodigo/List-Category-Posts/wiki/HTML-&-CSS-Customization) are applied.

Once you are happy with your selected options, just click the 'Insert into editor' button located at the bottom of the modal window. It will automatically insert a properly formated List Category Posts shortcode into WordPress editor. You can change the position at which the shortcode is inserted by moving the cursor in the editor.

==List Category Posts parameters reference==

Below is a list of shortcode creator's sections together with corresponding shortcode parameters. This is intended to help you navigate List Category Post's documentation.

===Selection options===

* **Categories**: `id`, `categorypage`, `child_categories`
* **Tags**: `tags`, `exclude_tags`, `current_tags`
* **Custom taxonomies**: `taxonomy`, `terms`, `taxonomies_and`, `taxonomies_or`
* **Post type & status**: `post_type`, `post_status`
* **Custom fields**: `customfield_name`, `customfield_value`
* **Exclude posts**: `exclude_posts`
* **Author**: `author_posts`
* **Date**: `monthnum`, `year`, `after`, `before`
* **Search**: `search`
* **Post title firts character**: `starting_with`
* **Offset**: `offset`
* **Parent post**: `post_parent`

===Display options===

* **Pagination, Number of posts & Order**: `pagination`, `numberposts`, `order`, `orderby`
* **List-specific options**: `conditional_title`, `catlink`, `catname`, `category_description`, `morelink`, `class`
* **Post-specific options**: `author`, `comments`, `content`, `customfield_display`, `customfield_display_separately`, `customfield_display_glue`, `customfield_display_name`, `customfield_display_name_glue`, `date`, `date_modified`, `excerpt`, `excerpt_overwrite`, `excerpt_strip`, `excerpt_size`, `display_id`, `post_suffix`, `posts_morelink`, `tags_as_class`, `title_limit`, `link_titles`, `no_post_titles`, `thumbnail`, `force_thumbnail`, `thumbnail_size`
* **Template**: `template`


==Development==

GUI for List Category Posts is open source software. You can find the
development version of the plugin on [Github](https://github.com/klemens-st/gui-for-lcp).

All suggestions and contributions are welcome :) Fork it, read the respository's
readme and start helping with the development!

This is a very early version of GUI for List Category Posts so users' feedback is *more than welcome* :)

==Support the plugin==

If you have found this plugin useful and would like to support its further development please consider
[sponsoring it on GitHub](https://github.com/sponsors/klemens-st/) or [donating on PayPal](https://www.paypal.com/donate?hosted_button_id=BX4TN5Z4MSX52) :)

==User Support==

Please use the support forum for questions about **using** the plugin. Use Github issues for discussing **code changes** and **bugs**.

== Installation ==

Please note that in order for your generated shortcodes to work you need to have the [List Category Posts](https://wordpress.org/plugins/list-category-posts/) plugin installed and activated.

== Frequently Asked Questions ==

= My shortcodes don't work =

Make sure you have [List Category Posts](https://wordpress.org/plugins/list-category-posts/) installed and activated.


== Screenshots ==

1. The 'LCP' button in WordPress editor. Works in text widgets, too.
2. Modal window opened by the button.
3. Example usage.


== Changelog ==

= 1.0.0 =
* Initial plugin release.

= 1.0.1 =
* Fixed a typo in readme.txt.

= 2.0.0 =
* Full overhaul of build tools and dependencies.
* Added a donate link :)
