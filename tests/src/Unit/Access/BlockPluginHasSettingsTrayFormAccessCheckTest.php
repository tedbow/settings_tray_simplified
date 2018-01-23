<?php

namespace Drupal\Tests\settings_tray_simple\Unit\Access;

use Drupal\block\BlockInterface;
use Drupal\Core\Access\AccessResultAllowed;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\PluginWithFormsInterface;
use Drupal\settings_tray_simple\Access\BlockPluginHasSettingsTrayFormAccessCheck;
use Drupal\Tests\UnitTestCase;
use Prophecy\Argument;

/**
 * @coversDefaultClass \Drupal\settings_tray_simple\Access\BlockPluginHasSettingsTrayFormAccessCheck
 * @group settings_tray_simple
 */
class BlockPluginHasSettingsTrayFormAccessCheckTest extends UnitTestCase {

  /**
   * @covers ::access
   * @covers ::accessBlockPlugin
   * @dataProvider providerTestAccess
   */
  public function testAccess($with_forms, array $plugin_definition, AccessResultInterface $expected_access_result) {
    $block_plugin = $this->prophesize()->willImplement(BlockPluginInterface::class);

    if ($with_forms) {
      $block_plugin->willImplement(PluginWithFormsInterface::class);
      $block_plugin->hasFormClass(Argument::type('string'))->will(function ($arguments) use ($plugin_definition) {
        return !empty($plugin_definition['forms'][$arguments[0]]);
      });
    }

    $block = $this->prophesize(BlockInterface::class);
    $block->getPlugin()->willReturn($block_plugin->reveal());

    $access_check = new BlockPluginHasSettingsTrayFormAccessCheck();
    $this->assertEquals($expected_access_result, $access_check->access($block->reveal()));
    $this->assertEquals($expected_access_result, $access_check->accessBlockPlugin($block_plugin->reveal()));
  }

  /**
   * Provides test data for ::testAccess().
   */
  public function providerTestAccess() {
    $annotation_forms_settings_tray_simple_class = [
      'forms' => [
        'settings_tray_simple' => $this->randomMachineName(),
      ],
    ];
    $annotation_forms_settings_tray_simple_not_set = [];
    $annotation_forms_settings_tray_simple_false = [
      'forms' => [
        'settings_tray_simple' => FALSE,
      ],
    ];
    return [
      'block plugin with forms, forms[settings_tray_simple] set to class' => [
        TRUE,
        $annotation_forms_settings_tray_simple_class,
        new AccessResultAllowed(),
      ],
      'block plugin with forms, forms[settings_tray_simple] not set' => [
        TRUE,
        $annotation_forms_settings_tray_simple_not_set,
        new AccessResultNeutral(),
      ],
      'block plugin with forms, forms[settings_tray_simple] set to FALSE' => [
        TRUE,
        $annotation_forms_settings_tray_simple_false,
        new AccessResultNeutral(),
      ],
      // In practice, all block plugins extend BlockBase, which means they all
      // implement PluginWithFormsInterface, but this may change in the future.
      // This ensures Settings Tray will continue to work correctly.
      'block plugin without forms, forms[settings_tray_simple] set to class' => [
        FALSE,
        $annotation_forms_settings_tray_simple_class,
        new AccessResultNeutral(),
      ],
      'block plugin without forms, forms[settings_tray_simple] not set' => [
        FALSE,
        $annotation_forms_settings_tray_simple_not_set,
        new AccessResultNeutral(),
      ],
      'block plugin without forms, forms[settings_tray_simple] set to FALSE' => [
        FALSE,
        $annotation_forms_settings_tray_simple_false,
        new AccessResultNeutral(),
      ],
    ];
  }

}
