namespace Strego\GoogleBundle\DependencyInjection;
 
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
 
class Configuration implements ConfigurationInterface
{
 
 
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('strego_google');

        $this->addAnalyticsSection($rootNode);

        return $treeBuilder;
    }
    
     /**
     * Add the Analytics section to configuration tree
     *
     * @param ArrayNodeDefinition $node
     */
    private function addAnalyticsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->scalarNode('default_tracker')
                ->defaultValue('default')
            ->end()
            ->arrayNode('trackers')
                ->isRequired()
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('name')
                ->prototype('array')
                ->children()
                    ->scalarNode('accountID')->isRequired()->end()
                    ->scalarNode('clientId')->end()
                    ->floatNode('sampleRate')->min(0)->max(100)->end()
                    ->integerNode('siteSpeedSampleRate')->min(0)->max(100)->end()
                    ->booleanNode('alwaysSendReferrer')->end()
                    ->booleanNode('allowAnchor')->end()
                    ->scalarNode('cookieName')->end()
                    ->scalarNode('cookieDomain')->end()
                    ->integerNode('cookieExpires')->end()
                    ->scalarNode('legacyCookieDomain')->end()
                ->end()
            ->end()
        ->end()
    ->end()
    }

}