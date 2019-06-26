# ESO Finder Tooltips WordPress Plugin

## Description

This plugin allows you to add tooltips on items from Elder Scrolls Online inside WordPress by pulling informations from [ESO Finder](https://esofinder.com).

To do so, and after activating the plugin, you have to use a custom shortcode inside your posts/pages:

    [esof link='type=id']

Where ***type*** being one of:

**achievement** | **collectible** | **skill**

And ***id*** being the ID of the item you want to add.

For example, if you want to show the achievement *Grand Master Crafter* in your post you will use the following shortcode:

    [esof link='achievement=2227']

And to show the collectible *Skyforge Smith Hammer*:

    [esof link='collectible=5472']

You can find all IDs on [ESO Finder](https://esofinder.com).

## Languages
By default and if supported (otherwise it will be in english), the items and tooltips will be in the same language as your WordPress. If you want to use a different language, you can add the following parameter inside your shortcode:

    [esof link='achievement=2227' lang='XX']

Where ***lang*** being one of:

**en** | **fr**

## Icons
If you want to show the icon of the item instead of the name, you can simply add the following parameter inside your shortcode:

    [esof link='skill=23634' icon='true']


## Installation

1. Upload the plugin files to the `/wp-content/plugins/esofinder-tooltips` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use `[esof]` shortcodes inside your posts/pages.
