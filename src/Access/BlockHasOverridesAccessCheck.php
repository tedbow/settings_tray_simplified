<?php

namespace Drupal\settings_tray_simple\Access;

use Drupal\block\BlockInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

/**
 * Determines whether the requested block has a 'settings_tray_simple' form.
 *
 * @internal
 */
class BlockHasOverridesAccessCheck implements AccessInterface {

  /**
   * Checks access for accessing a block's 'settings_tray_simple' form.
   *
   * @param \Drupal\block\BlockInterface $block
   *   The block whose 'settings_tray_simple' form is being accessed.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(BlockInterface $block) {
    return AccessResult::allowedIf(!_settings_tray_simple_has_block_overrides($block));
  }

}
