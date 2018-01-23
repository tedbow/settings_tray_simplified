<?php

namespace Drupal\settings_tray_simple_test\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Block that does nothing explicit for Settings Tray.
 *
 * @Block(
 *   id = "settings_tray_simple_test_none",
 *   admin_label = "Settings Tray test block: forms[settings_tray_simple] is not specified",
 * )
 */
class SettingsTrayFormAnnotationNoneBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return ['#markup' => '<span>none</span>'];
  }

}
