<?php

/**
 * Bootstrap Grid plugin for Craft CMS 3.x
 *
 * @link      https://nthmedia.nl
 * @copyright Copyright (c) 2020 NTH media
 */

namespace nthmedia\bootstrapgrid;

use nthmedia\bootstrapgrid\assetbundles\bootstrapgrid\BootstrapGridFieldAsset;
use nthmedia\bootstrapgrid\fields\BootstrapGrid as BootstrapGridField;
use Craft;
use craft\base\Plugin;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    NTH media
 * @package   BootstrapGrid
 * @since     1.0.0
 *
 */
class BootstrapGrid extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * BootstrapGrid::$plugin
     *
     * @var BootstrapGrid
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * BootstrapGrid::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $request = Craft::$app->getRequest();
        if( $request->getIsCpRequest() ){
            BootstrapGridFieldAsset::register(Craft::$app->view);
        }

        // Register our fields
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = BootstrapGridField::class;
            }
        );

        Craft::info(
            Craft::t(
                'bootstrap-grid',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

}
