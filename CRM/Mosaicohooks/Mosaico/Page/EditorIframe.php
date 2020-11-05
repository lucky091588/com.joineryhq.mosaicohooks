<?php

/**
 * Overrides certain methods in CRM_Mosaico_Page_EditorIframe.
 *
 * Really couldn't find a way to do the needful using hooks, so we override methods.
 */
class CRM_Mosaicohooks_Mosaico_Page_EditorIframe extends CRM_Mosaico_Page_EditorIframe {

  /**
   * Modify return value of parent:: method.
   */
  protected function createMosaicoConfig() {
    $config = parent::createMosaicoConfig();

    CRM_Utils_Hook::singleton()->invoke(['config'], $config, $null, $null,
      $null, $null, $null,
      'civicrm_mosaicoConfigAlter'
    );
    return $config;
  }

  /**
   * Modify return value of parent:: method.
   */
  protected function getScriptUrls() {
    $scriptUrls = parent::getScriptUrls();

    CRM_Utils_Hook::singleton()->invoke(['scriptUrls'], $scriptUrls, $null, $null,
      $null, $null, $null,
      'civicrm_mosaicoScriptUrlsAlter'
    );
    return $scriptUrls;
  }

  /**
   * Modify return value of parent:: method.
   */
  protected function getStyleUrls() {
    $styleUrls = parent::getStyleUrls();

    CRM_Utils_Hook::singleton()->invoke(['styleUrls'], $styleUrls, $null, $null,
      $null, $null, $null,
      'civicrm_mosaicoStyleUrlsAlter'
    );
    return $styleUrls;
  }
}
