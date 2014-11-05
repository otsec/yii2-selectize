<?php

namespace otsec\yii2\selectize;

use yii\web\AssetBundle;

/**
 * Class BootstrapAsset
 *
 * @author Artem Belov <razor2909@gmail.com>
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/selectize/dist';

    public $css = [
        'css/selectize.bootstrap3.css',
    ];

    public $js = [
        'js/standalone/selectize.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}