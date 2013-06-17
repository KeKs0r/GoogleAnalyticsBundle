<?php

namespace Strego\GoogleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class StregoGoogleExtension extends Extension
{
    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->analyticsLoad($configs, $container);
    }


    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    private function analyticsLoad(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('analytics.xml');


        foreach ($configs as $config) {
//            $trackers = array();
//            foreach (array_keys($config['trackers']) as $name) {
//                $trackers[$name] = sprintf('strego_google.%s_tracker', $name);
//            }

            $container->getDefinition('strego_google.tracker_factory')->setArguments(
                array($config['trackers'], $config['default_tracker'])
            );
            //$container->setParameter('strego_google.trackerConfigs', );
            $container->setParameter('strego_google.default_tracker', $config['default_tracker']);

        }
    }

    /**
     * Loads a configured Tracker.
     *
     * @param string $name       The name of the connection
     * @param array $connection A tracker configuration.
     * @param ContainerBuilder $container  A ContainerBuilder instance
     */
    protected function loadTracker($name, array $tracker, ContainerBuilder $container)
    {
        $container
            ->setDefinition(
                sprintf('strego_google.%s_tracker', $name),
                new DefinitionDecorator('doctrine.dbal.connection')
            )
            ->setArguments(
                array(
                    new Reference(sprintf('strego_google.%s_tracker.configuration', $name)),
                )
            );


    }

    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::getAlias()
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'strego_google';
    }
}
