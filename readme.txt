=== Savrix Play Store ===
Contributors: Saverio Petrangelo
Tags: android, qr code, market, android badge, google play badge
Requires at least: 2.8
Tested up to: 3.6
Stable tag: 3.1.2

With Savrix Play Store you can easily share your Android app on your blog posts.

== Description ==

With Savrix Play Store you can easily share your Android app on your blog posts.

Just write down the package name of the application you'll need to promote and place it between the [app] tag.

For example if you need to promote the YouTube app ( <a href="https://play.google.com/store/apps/details?id=com.google.android.youtube">Market link for YouTube</a> ) which has com.google.android.youtube as package name, you only need to write <b>[app]com.google.android.youtube[/app]</b> in your blog post and it will generate:

* icon
* name
* developer
* price (The currency displayed depends on the country your server is located in)
* rating
* QR Code
* Appbrain link
* Google Play Store link

of the app.

The Google Play Store link will work perfectly both from mobile and from pc.
The badge max-width is 480px. If your post's column is wider than 480px, the badge will be centered. The badge will adapt to the screen width if lower than 480px.

With the 2.1 update, this plugin becomes more flexible. Apart from the default badge, it is now possible to rearrange and customize the various components in your own style.


* With [qr]package.name[/qr] you can show only the Android Market QR code, with [qr type="appbrain"]package.name[/qr] you can show the Appbrain QR code. You can also specify the size [qr size="100"]package.name[/qr] or the css class [qr class="your_qr_class"]package.name[/qr] if you want to style it in a particular way. The default size for the QR code is 125 pixels.
* With [icon]package.name[/icon] you can show only the app icon. You can also specify the size [appicon size="100"]package.name[/appicon] or the css class [appicon class="your_appicon_class"]package.name[/appicon] if you want to style it in a particular way. The default size for the icon is 125 pixels.
* With the generic [app]package.name[/app] you can show the entire badge, as in the previous version. Now you can also use [app type="appbrain"]package.name[/app] if you want to display the AppBrain QR Code instead of the Market one.

Be careful. Don't use more than two/three shortcode per page, if you don't want your page to load slowly.

== Installation ==

1. Upload all the files to the `/wp-content/plugins/savrix-android-market` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Plugin with Google Play and AppBrain links enabled
2. Plugin with only Google Play link (icon and application name clickable)

== Changelog ==
= 3.1.2 =
* Bugfix

= 3.1.1 =
* Removed the button Google Play if you choose to not show the AppBrain link. Icon and app name become clickable.
* Solved a problem occurring when you use the 3rd option caching method and the app icon is not a PNG file.
* Removed rounded corners.
* Removed QR code from the badge if the screen size is less than 800px.
* Slightly increased the QR code size (80px instead of 75px) using only the Google Play link.

= 3.1 =
* Added setting page to the plugin.
* Added the option to store locally the app data and icons without fetch them everytime from the Play Store. (Depending on the server configuration - it needs to write files on server and use GD library)
* Added the option to choose the language in which app data are displayed.
* Added the option to show both "Google Play" and "AppBrain" buttons or only the "Google Play" one.
* Minor changes to the css file.

= 3.0.2 =
* The plugin now uses cURL instead of file_get_contents (thanks to TamCore for the code). Now it should work with more servers.

= 3.0.1 =
* Added a line of code to prevent errors using the plugin (e.g. extra spaces when copy-paste the package name, other plugins adding html tags to some words, etc.)

= 3.0 =
* Rebrand! Savrix Android Market now become <b>Savrix Play Store</b>!
* Code changes to make the badge responsive. Now it fits all screen resolutions.
* Code changes due to the new web version of Google Play.
* Removed the shortcode usage [stars][/stars] due to problems with the new web version of Google Play.
* English localization of html, php and css code.
* English names for image files.

= 2.2.3 =
* Bug fixes

= 2.2.2 =
* Fixed some code due to some changes to the web version of Google Play

= 2.2.1 =
* Fixed app icon not showing

= 2.2 =
* Updated the plugin to the new Google Play Store
* Used a little darker green color
* Changed the Google Play and AppBrain buttons

= 2.1.6 =
* Corrected a little issue with the W3C validation.

= 2.1.5 =
* Modified some code due to some changes to the web version of the Android Market. Now price information is displayed correctly again.

= 2.1.4 =
* Modified some code due to some changes to the web version of the Android Market. Now evaluation stars are displayed correctly again.

= 2.1.3 =
* Changed some code due to some modification on the web version of the Android Market.

= 2.1.2 =
* Fixed the issue that had the price show as "ND" instead of "Free", when working with some servers.
* Some css additions

= 2.1.1 =
* Minor css additions

= 2.1 =
* added [qr] [stars] [appicon] tags
* added the ability to set a custom css class for the new tags
* some code optimization

= 2.0.1 =
* added the border:0 to the images in the css.

= 2.0 =
* First public release of the Savrix Android Market WP Plugin -- 10th August 2011