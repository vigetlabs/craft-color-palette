<?php
/**
 * Color Palette plugin for Craft CMS 3.x
 *
 * Create a color palette
 *
 * @link      https://www.trevor-davis.com
 * @copyright Copyright (c) 2019 Trevor Davis
 */

namespace davist11\colorpalette\records;

use davist11\colorpalette\ColorPalette;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    Trevor Davis
 * @package   ColorPalette
 * @since     1.0.0
 */
class ColorRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'hex'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['hex'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%colorpalette}}';
    }
}
