# CiviCRM: Mosaico Hooks

Provides hooks `hook_civicrm_mosaicoStyleUrlsAlter` and `hook_civicrm_mosaicoScriptUrlsAlter` to alter relevant assets in the Mosaico interface. May be a dependency for extensions that need to do this. For example, [Campaign Advocacy](https://github.com/twomice/civicrm-campaignadvocacy) uses these hooks to inject CSS and JavaScript files for custom token handlng in the Mosaico composer.

The extension is licensed under [GPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM 5.0

## Usage

### `hook_civicrm_mosaicoStyleUrlsAlter(&$styleUrls)`
`$styleUrls` is an array of URLs for stylesheets to be loaded in the Mosaico composer interface. Alter (add, remove, change) array elements as needed.

Example from  [Campaign Advocacy](https://github.com/twomice/civicrm-campaignadvocacy):

```php
function campaignadv_civicrm_mosaicoStyleUrlsAlter(&$styleUrls) {
  $res = CRM_Core_Resources::singleton();

  // Build a list of core resources. We'll exclude certain jquery-ui theme styles,
  // but otherwise, we'll add all of these resources to the page, so our pop-ups
  // and other custom token features will work properly.
  $coreResourceList = $res->coreResourceList('html-header');
  $coreResourceList = array_filter($coreResourceList, 'is_string');
  foreach ($coreResourceList as $item) {
    if (
      FALSE !== strpos($item, 'css')
      // Exclude jquery ui theme styles, which conflict with Mosaico styles.
      && FALSE === strpos($item, '/jquery-ui/themes/')
    ) {
      if ($res->isFullyFormedUrl($item)) {
        $itemUrl = $item;
      }
      else {
        $item = CRM_Core_Resources::filterMinify('civicrm', $item);
        $itemUrl = $res->getUrl('civicrm', $item, TRUE);
      }
      $styleUrls[] = $itemUrl;
    }
  }

  // Include our own abridged styles from jquery-ui 'smoothness' theme, as
  // required for our jquery-ui dialog, but which don't conflict with Mosaico.
  $styleUrls[] = $res->getUrl('campaignadv', 'css/jquery-ui-smoothness-partial.css', TRUE);
}
```

### `hook_civicrm_mosaicoScriptUrlsAlter(&$scriptUrls)`
`$scriptUrls` is an array of URLs for JavaScript files to be loaded in the Mosaico composer interface. Alter (add, remove, change) array elements as needed.

Example from  [Campaign Advocacy](https://github.com/twomice/civicrm-campaignadvocacy):

```php
function campaignadv_civicrm_mosaicoScriptUrlsAlter(&$scriptUrls) {
  $res = CRM_Core_Resources::singleton();

  // Include our own JS.
  $url = $res->addCacheCode(CRM_Utils_System::url('civicrm/campaignadv/mosaico-js', '', TRUE, NULL, NULL, NULL, NULL));
  $scriptUrls[] = $url;
}
```


## Support
![screenshot](/images/joinery-logo.png)

Joinery provides services for CiviCRM including custom extension development, training, data migrations, and more. We aim to keep this extension in good working order, and will do our best to respond appropriately to issues reported on its [github issue queue](https://github.com/twomice/com.joineryhq.mosaicohooks/issues). In addition, if you require urgent or highly customized improvements to this extension, we may suggest conducting a fee-based project under our standard commercial terms.  In any case, the place to start is the [github issue queue](https://github.com/twomice/com.joineryhq.mosaicohooks/issues) -- let us hear what you need and we'll be glad to help however we can.

And, if you need help with any other aspect of CiviCRM -- from hosting to custom development to strategic consultation and more -- please contact us directly via https://joineryhq.com
