=== YD WPML Switcher ===
Contributors: ydubois
Donate link: http://www.yann.com/
Tags: plugin, automatic, admin, administration, wpml, plugins, language, French, English, switch, switcher, deactivate, turn off, filter
Requires at least: 2.9.1
Tested up to: 3.0.4
Stable tag: trunk

Add-on to WPML to switch off language filters on specific pages. 

== Description ==

This plugin is an add-on to the WPML Multilingual CMS plugin from http://wpml.org.

Switches the WPML language filters off for specific pages (URLs).

Makes it possible to mix contents in different languages on specific pages.

= multi-language category function =

Use ` get_cat_in_all_languages( $cat )` to get a list of translated category IDs in all languages.

Usage example:

`
$catlist = join( ',', YD_WPMLSwitcher::get_cat_in_all_languages( 'press releases' ) );
query_posts("cat=$catlist");
`
This will let you display a mixed-language list of posts belonging to a specific category (only operates on pages where WPML filtering is switched off)

= Beta version =

Right now WPML is switched of for site root URL / only.

Check the plugin's settings page to switch debug mode on/off.

= Funding Credits =

Original development of this plugin has been paid for by [Wellcom](http://www.wellcom.fr "Eurospreed"). Please visit their site!

Le développement d'origine de ce plugin a été financé par [Wellcom](http://www.wellcom.fr "Eurospreed"). Allez visiter leur site !

= Translation =

If you want to contribute to a translation of this plugin, please drop me a line by e-mail or leave a comment on the [plugin's page](http://www.yann.com/en/wp-plugins/yd-wpml-switcher "Yann Dubois' WPML Switcher plugin for WordPress").
You will get credit for your translation in the plugin file and this documentation, as well as a link on this page and on [my WordPress developers' blog](http://www.yann.com/).

Yann Dubois, [Développeur WordPress](http://www.yann.com/fr/a-propos/developpeur-wordpress "Yann Dubois, développeur WordPress freelance à Paris") 

== Installation ==

1. Unzip yd-wpml-switcher.zip
1. Upload the `yd-wpml-switcher` directory and all its contents into the `/wp-content/plugins/` directory of your main site
1. Activate the plugin **on your main site** or **network-wide** through the 'Plugins' menu in WordPress
1. Use the plugins's own setting page to select on which pages to deactivate WPML.

For specific installations, some more information might be found on the [YD WPML Switcher plugin support page](http://www.yann.com/en/wp-plugins/yd-wpml-switcher "Yann Dubois' WPML Switcher plugin for WordPress")

== Frequently Asked Questions ==

= Where should I ask questions? =

http://www.yann.com/en/wp-plugins/yd-wpml-switcher

Use comments.

I will answer only on that page so that all users can benefit from the answer. 
So please come back to see the answer or subscribe to that page's post comments.

= Puis-je poser des questions et avoir des docs en français ? =

Oui, l'auteur est un [Développeur WordPress freelance](http://www.yann.com/fr/a-propos/developpeur-wordpress Développeur WordPress freelance à Paris) français.
("but alors... you are French?")

== Screenshots ==

1. Not yet.

== Revisions ==

* 0.1.0 Original beta version.
* 0.1.1 Improved beta version.
* 0.1.2 Improved beta version.
* 0.1.3 Improved beta version.
* 0.1.4 Improved beta version.

== Changelog ==

= 0.1.0 =
* Initial release
= 0.1.1 =
* Bugfix: Better regexp
= 0.1.2 =
* Option page
* Debug mode
* Disable backlink in blog footer
* New template function: get_cat_in_all_languages()
* Checked WP 3.0.4 compatibility
= 0.1.3 =
* disable get_terms filter
* disable getarchives filter
= 0.1.4 =
* bugfix (language selection in article admin)

== Upgrade Notice ==

= 0.1.0 =
Initial release.
= 0.1.1 =
No remarks. Automatic upgrade works.
= 0.1.2 =
No remarks. Automatic upgrade works.
= 0.1.3 =
No remarks. Automatic upgrade works.
= 0.1.4 =
No remarks. Automatic upgrade works.

== Did you like it? ==

Drop me a line on http://www.yann.com/en/wp-plugins/yd-wpml-switcher

And... *please* rate this plugin --&gt;