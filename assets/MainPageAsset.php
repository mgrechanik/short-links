<?php
/**
 * This file is part of the mgrechanik/short-links project
 *
 * @copyright Copyright (c) Mikhail Grechanik <mike.grechanik@gmail.com>
 * @license https://github.com/mgrechanik/short-links/blob/main/LICENSE.md
 * @link https://github.com/mgrechanik/short-links
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main page asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MainPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/main_page.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
