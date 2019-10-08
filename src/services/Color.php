<?php
/**
 * Color Palette plugin for Craft CMS 3.x
 *
 * Create a color palette
 *
 * @link      https://www.trevor-davis.com
 * @copyright Copyright (c) 2019 Trevor Davis
 */

namespace davist11\colorpalette\services;

use davist11\colorpalette\ColorPalette;
use davist11\colorpalette\models\ColorModel;
use davist11\colorpalette\records\ColorRecord;

use Craft;
use craft\base\Component;

/**
 * @author    Trevor Davis
 * @package   ColorPalette
 * @since     1.0.0
 */
class Color extends Component
{
    // Public Methods
    // =========================================================================

    
    public static function save(ColorModel $model): ColorModel
    {
        $record = ($model->id) ? self::_getRecordById($model->id) : new ColorRecord();

        $record->setAttributes($model->getAttributes());

        if (!$record->save()) {
            $model->addErrors($record->getErrors());

            return $model;
        }

        $model->id = $record->id;

        return $model;
    }

    public static function getColors(array $ids = []): array
    {
        $colorRecords = $ids ? ColorRecord::findAll($ids) : ColorRecord::find()->all();
        $colors = [];

        foreach($colorRecords as $colorRecord) {
            $colorModel = new ColorModel();
            $colorModel->setAttributes($colorRecord->getAttributes());
            $colors[] = $colorModel;
        }

        return $colors;
    }

    public static function getById(int $id): ColorModel
    {
        $model = new ColorModel();

        $record = self::_getRecordById($id);
        
        if ($record) {
            $model->setAttributes($record->getAttributes());
        }

        return $model;
    }

    public static function deleteById(int $id)
    {
        $record = self::_getRecordById($id);

        if ($record === null) {
            return false;
        }

        return $record->delete();
    }

    private static function _getRecordById(int $id)
    {
        return ColorRecord::findOne($id);
    }
}
