<?php

namespace Drupal\settings_tray_simple_test\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Block that explicitly provides a "settings_tray_simple" form class.
 *
 * @Block(
 *   id = "settings_tray_simple_test_class",
 *   admin_label = "Settings Tray test block: forms[settings_tray_simple]=class",
 *   forms = {
 *     "settings_tray_simple" = "\Drupal\settings_tray_simple_test\Form\SettingsTrayFormAnnotationIsClassBlockForm",
 *   },
 * )
 */
class SettingsTrayFormAnnotationIsClassBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return ['#markup' => '<span>class</span>'];
  }

}
