<?php

namespace SimklHideSingleValueFacet;

use Shopware\Components\Plugin;
use Shopware\Models\Shop\Shop;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Shopware-Plugin SimklHideSingleValueFacet.
 */
class SimklHideSingleValueFacet extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'registerTemplateDir',
            'Enlight_Controller_Action_PreDispatch_Widgets' => 'registerTemplateDir'
        ];
    }

    /**
     * adds our template dir
     * @param \Enlight_Event_EventArgs $args
     */
    public function registerTemplateDir(\Enlight_Event_EventArgs $args)
    {

        /** @var Plugin\CachedConfigReader $configReader */
        $configReader = $this->container->get('shopware.plugin.cached_config_reader');

        $config = $configReader->getByPluginName('SimklHideSingleValueFacet');
        try {
            /** @var Shop $shop */
            $shop = $this->container->get('shop');
            if ($shop instanceof Shop) {
                $config = $configReader->getByPluginName('SimklHideSingleValueFacet', $shop);
            }
        } catch(ServiceNotFoundException $e) {
            // shop unknown
        }

        if (!$config['enabled']) {
            return;
        }

        /** @var $controller \Enlight_Controller_Action */
        $controller = $args->getSubject();
        $view = $controller->View();
        $view->addTemplateDir(__DIR__ . '/Resources/views');
    }
}
