<?php
/**
 * Color Palette plugin for Craft CMS 3.x
 *
 * Create a color palette
 *
 * @link      https://www.trevor-davis.com
 * @copyright Copyright (c) 2019 Trevor Davis
 */

namespace davist11\colorpalette\assetbundles\indexcpsection;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Trevor Davis
 * @package   ColorPalette
 * @since     1.0.0
 */
class IndexCPSectionAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@davist11/colorpalette/assetbundles/indexcpsection/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'css/Index.css',
        ];

        parent::init();
    }
}
