Roundcube Plugin attachment_position
====================================
This plugin adds an option to Roundcube mail that adds a setting allowing users
to choose where the attachment upload pane should appear when composing a
message.

By default, the attachment pane is displayed to the right of the message 
composition window taking up space from the message window.  This makes it easy
for the user to choose to move the attachment pane to the position above the
message window (similar to Roundcube 0.9.x) but still have the ability to drag
and drop attachments, and see a full list of files attached to the message.

Install
-------
Manual download:

* Download the latest stable release of this plugin
* Save it to a directory called `attachment_position`
* Place the folder into the `plugins/` directory of Roundcube
* Add an element `attachment_positions` to the `$config['plugins']` setting
in your Roundcube `config/config.inc.php` file.

Using composer:

* Edit `composer.json` in the root directory where Roundcube is installed
* In the `require` section, add `"sonic/attachment_position": "~1.1"`
* See the [Roundcube plugins][rcplugins] site for more information.  

Usage
-----
When the plugin is activated, a small up arrow icon is dynamically added to the
attachments pane when composing a message.  Clicking this moves the attachment
pane above the message composition window.

Users can permanently set this behavior by going to **Settings** >>
**Preferences** >> **Composing Messages** and setting the option labeled:
*Location of attachments pane* to *above the message composition window*.

Important Skin Information
--------------------------
This plugin is made for the larry skin.  The CSS and Javascript *may* not
function with other skins that are heavily modified or not derived from larry.

If using another skin extending larry, you will need to create a symbolic link
for your skin in the `attachment_position/skins` directory pointing to larry
(e.g. `ln -s larry yourskin`).  If this step is not taken, the plugin will not
load the appropriate CSS and Javascript files when composing a message.

Screenshots
-----------
![attachment pane above message](http://drew.phillips.users.sonic.net/img/roundcube_attachment_position-2.png "Attachments Pane")
![settings](http://drew.phillips.users.sonic.net/img/roundcube_attachment_position-3.png "Position setting")

Copyright
---------
Copyright (c) 2016 Sonic.net, Inc.  This software is released under the
[BSD-3 license][bsd-3].  See the included `LICENSE` file for details.
 
[bsd-3]: https://opensource.org/licenses/BSD-3-Clause
[rcplugins]: https://plugins.roundcube.net/
