<?php
/**
 * Color Palette plugin for Craft CMS 3.x
 *
 * Create a color palette
 *
 * @link      https://www.trevor-davis.com
 * @copyright Copyright (c) 2019 Trevor Davis
 */

namespace davist11\colorpalette\fields;

use davist11\colorpalette\ColorPalette;
// use davist11\colorpalette\assetbundles\colorpalettefieldfield\ColorPaletteFieldFieldAsset;
use davist11\colorpalette\services\Color;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Trevor Davis
 * @package   ColorPalette
 * @since     1.0.0
 */
class ColorPaletteField extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $allowMultiple = false;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('color-palette', 'Color Palette');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['allowMultiple', 'boolean'],
            ['allowMultiple', 'default', 'value' => false],
        ]);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value === null) {
            return $value;
        }
        $ids = Json::decodeIfJson($value);
        $colors = Color::getColors($ids);
        
        return (count($colors) === 1) ? $colors[0] : $colors;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'color-palette/_components/fields/ColorPaletteField_settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'color-palette/_components/fields/ColorPaletteField_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'valueIds' => $this->_getIds($value),
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'colors' => Color::getColors(),
            ]
        );
    }

    private function _getIds($value): array
    {
        if ($value === null) {
            return [];
        }

        if (!is_array($value)) {
            return [$value->id];
        }

        $ids = [];

        foreach ($value as $color) {
            $ids[] = $color->id;
        }

        return $ids;
    }
}
