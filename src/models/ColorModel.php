<?php
/**
 * Color Palette plugin for Craft CMS 3.x
 *
 * Create a color palette
 *
 * @link      https://www.trevor-davis.com
 * @copyright Copyright (c) 2019 Trevor Davis
 */

namespace davist11\colorpalette\models;

use davist11\colorpalette\ColorPalette;

use Craft;
use craft\base\Model;

/**
 * @author    Trevor Davis
 * @package   ColorPalette
 * @since     1.0.0
 */
class ColorModel extends Model
{
    // Public Properties
    // =========================================================================

    public $id;
    public $name;
    public $hex;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'hex'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['hex'], 'string', 'max' => 7],
        ];
    }

    public function attributeLabels()
    {
        return [
            'hex' => 'Color',
        ];
    }

    public function __toString()
    {
        return $this->hex;
    }
}