# rljUtils

Addon for Cockpit CMS, that adds some hardening, cosmetics and helpers

When using Cockpit with multiple users, it needs some customization. By default, some helper functions bypass the user group access control lists or they talk too much, so they definitely need some adjustments. This addon also adds some UI tweaks and helpers.

This addon helps if you forget to adjust some values and sets them to defaults. It also contains some snippets, I collected in the [cockpit-scripts repository][1] over the last year.

Some adjustments are opinion-based. I like them and I wrote this addon as a base to work with for my needs. Use the code as inspiration or if you have suggestions, feel free to file an issue or to send a pull request.

More options and helpers may come soon...

**If you leave `collections_find`, `collections_tree` and `collections_collections` enabled, you might get some problems with collection-link fields.** But in my opinion

## Installation

Copy this repository into `/addons` and name it `rljUtils` or

```bash
cd path/to/cockpit
git clone https://github.com/raffaelj/cockpit_rljUtils.git addons/rljUtils
```

## Usage

By default, all options, except `locked_entries_disabled`, are enabled.

Disable them via `config/config.yaml` or via UI under "settings" --> "rljUtils"

Scroll down for anexample configuration.

## Features

### Hardening

* set `allowed_uploads` to `'jpg, jpeg, png, gif, svg, pdf, ods, odt, doc, docx, xls, xlsx'` if it is not defined
* set `max_upload_size` to 4MB if it is not defined
* restrict collection helper functions/routes, that bypass group acl (used by collection links, OK for pure api usage, but a security no-go in the admin ui)
  * `find` and `_find`
  * `tree`
  * `_collections`
* restrict account helper function/route `/find`
  * disable the whole user list for non-admins
  * return user data only if it is filtered by id
  * return only needed data (user, name, group, _id) and not the personal email addresses
* new acl rule `assets` - if not enabled, the user group can't access the assetsmanager

### Cosmetics

* disable the timer widget in the dashboard
* set the default entries group in entry edit view to "Main" (the default is "All") - If you split the fields in categories, e. g. SEO and config, it is a bit annoying to see the whole list on startup
* add some BIG, coloured language buttons to the action panel (I always forget to switch back after changing some localized values)

### Helpers

* disable entry lock functionality - While developing and testing with multiple browsers it is really annoying to wait until the entry is unlocked. Also my Firefox is setup with some privacy settings, so it never sends the unlock signal when closing a tab or clicking on "Cancel".

## Example configuration

```yaml
app.name: rljUtils Test

languages:
    default: English
    de: Deutsch

groups:
    manager:
        cockpit:
            backend: true
            accounts: true
            assets: true
    author:
        cockpit:
            backend: true
            assets: true
    guest:
        cockpit:
            backend: true

rljutils:
    hardening:
        allowed_uploads: false
        max_upload_size: false
        collections_find: false
        collections_tree: false
        collections_collections: false
        accounts_find: false
        assetsmanager: false
    cosmetics:
        widgets_timer_disabled: false
        entry_default_group_main: false
        entry_language_buttons: false
    helpers:
        locked_entries_disabled: true   # entry lock is annoying while developing and testing with multiple browsers
```

[1]: https://github.com/raffaelj/cockpit-scripts