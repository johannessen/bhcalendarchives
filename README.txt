=== bhCalendarchives ===
Contributors: Emmanuel Ostertag aka burningHat
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=webmaster%40burninghat%2enet&item_name=webmaster%20_at_%20burninghat%2enet&item_number=plugin%20WordPress%3a%20bhCalendarchives&no_shipping=0&no_note=1&tax=0&currency_code=CHF&lc=FR&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: archive, archives, widget, sidebar
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: 0.3.2

Replace the archives widget by a wonderful monthly table

== Description ==

= English =

This plugin replace the original archives widget by a wonderful monthly table

Translate in Dutch by Jérémy Verda (http://blog.v-jeremy.net/) and in Spanish by Morgan (http://morgan.jerabek.fr/)

= Français =

Ce plugin remplace le widget original des archives par un superbe tableau mensuel.

Traduit en néerlandais par Jérémy Verda (http://blog.v-jeremy.net/) 

== Installation ==

= English =

Widget:

1. Unzip into your `/wp-content/plugins` directory. If you're uploading it, make sure to upload the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins`
2. Activate the plugin through the `Plugins` menu in WordPress
3. Go to 'Presentation » Widgets' submenu and add the 'Archives' widget to your sidebar
4. Configure your widget
5. Nothing else ! No configuration needed

Without widget:

1. Unzip into your `/wp-content/plugins` directory. If you're uploading it, make sure to upload the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins`
2. Activate the plugin through the `Plugins` menu in WordPress
3. Where you want to display your archives, in your sidebar.php for example, add the following code:
<?php if ( function_exists(bhCalendarchives) ) { bhCalendarchives(args); ?> where args can be 'num', 'first', 'short'.


NB: consider to use a theme with a large sidebar if you want to use it in.

= Français =

Widget:

1. décompressez l'archive dans votre répertoire '/wp-content/plugins'. Si vous uploadez, soyez sûr d'uploader le dossier racine. N'envoyez que les fichiers php dans '/wp-content/plugins'.
2. Activez le plugin depuis le menu 'Plugins' de votre console WordPress
3. Allez dans le sous-menu 'Thème » Widgets' et ajoutez le widget 'Archive' à votre sidebar
4. Configurer votre widget
5. Rien de plus ! Aucune configuration n'est nécessaire


Sans widget:

1. décompressez l'archive dans votre répertoire '/wp-content/plugins'. Si vous uploadez, soyez sûr d'uploader le dossier racine. N'envoyez que les fichiers php dans '/wp-content/plugins'.
2. Activez le plugin depuis le menu 'Plugins' de votre console WordPress
3. Là où vous voulez afficher vos achives, dans le fichier sidebar.php par exemple, ajoutez le code suivant:
<?php if ( function_exists(bhCalendarchives) ) { bhCalendarchives(args); } ?> où args peut être 'num', 'first' ou 'short'.

NB: veillez à utiliser un thème avec une large sidebar si vous voulez y insérer ce tableau.

== Changelog ==

* 0.3 - now the number of posts appears when you roll-over a month
* 0.2 - now you can display the months in two digits or first letter or first three letters
* 0.1.2 - added the Dutch translation
* 0.1.1 - adding option in the "Presentation / Widgets" menu to change the title of the widget 'Archives'. Plugin now ready to internationalization
* 0.1 - initial release

== Credits ==

Copyright 2008  Emmanuel Ostertag alias burningHat (email : webmaster _at_ burninghat.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

== Frequently Asked Questions ==