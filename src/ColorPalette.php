<?php
/**
 * Color Palette plugin for Craft CMS 3.x
 *
 * Create a color palette
 *
 * @link      https://www.trevor-davis.com
 * @copyright Copyright (c) 2019 Trevor Davis
 */

namespace davist11\colorpalette;

use davist11\colorpalette\services\Color as ColorService;
use davist11\colorpalette\fields\ColorPaletteField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use yii\base\Event;
use craft\web\twig\variables\CraftVariable;

/**
 * Class ColorPalette
 *
 * @author    Trevor Davis
 * @package   ColorPalette
 * @since     1.0.0
 *
 * @property  ColorPaletteServiceService $colorPaletteService
 */
class ColorPalette extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ColorPalette
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ColorPaletteField::class;
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['color-palette/new'] = ['template' => 'color-palette/_edit'];
                $event->rules['color-palette/<colorId:\d+>'] = 'color-palette/default/edit-color';
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $e) {
                $variable = $e->sender;

                $variable->set('colorPalette', ColorService::class);
            }
        );

        Craft::info(
            Craft::t(
                'color-palette',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
