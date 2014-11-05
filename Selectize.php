<?php

namespace otsec\yii2\selectize;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Selectize renders a text input Selectize.js plugin widget. Selectize.js is the hybrid of textbox and select box.
 *
 * @author Artem Belov <razor2909@gmail.com>
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 */
class Selectize extends InputWidget
{
    /**
     * @var array|null $items the option data items.
     */
    public $items;
    /**
     * @var array the options for the Selectize.js plugin.
     * Please refer to the Selectize.js plugin web page for possible options.
     * @see https://github.com/brianreavis/selectize.js/blob/master/docs/usage.md#options
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the Selectize.js plugin.
     * Please refer to the Selectize.js plugin web page for possible options.
     * @see https://github.com/brianreavis/selectize.js/blob/master/docs/events.md#list-of-events
     */
    public $clientEvents = [];
    /**
     * @var string the asset bundle class for widget customizing.
     */
    public $theme = 'otsec\yii2\selectize\BootstrapAsset';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->hasModel()) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $this->options['id'] = $this->id;
        }

        $this->registerAssetBundle();
        $this->registerJs();
        $this->registerEvents();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            $this->name  = Html::getInputName($this->model, $this->attribute);
            $this->value = Html::getAttributeValue($this->model, $this->attribute);
        }

        return ($this->items)
            ? Html::dropDownList($this->name, $this->value, $this->items, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);
    }

    /**
     * Registers Selectize asset bundle
     */
    public function registerAssetBundle()
    {
        call_user_func([$this->theme, 'register'], $this->view);
    }

    /**
     * Registers plugin for a form field
     */
    public function registerJs()
    {
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').selectize({$clientOptions});");
    }

    /**
     * Registers a specific Selectize events
     */
    public function registerEvents()
    {
        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handle) {
                $js[] = "jQuery('#{$this->options['id']}').on('{$event}',{$handle});";
            }
            $this->getView()->registerJs(implode(PHP_EOL, $js));
        }
    }
}