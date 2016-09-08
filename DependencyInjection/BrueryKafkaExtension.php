<?php

namespace Bruery\KafkaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BrueryKafkaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('manager.xml');

        $def = $container->getDefinition('bruery.kafka.manager');

        if (array_key_exists('producers', $config) && is_array($config['producers'])) {
            foreach ($config['producers'] as $producerName => $producerConfig) {
                $brokers = $producerConfig["brokers"];
                $topic = $producerConfig["topic"];
                $props = array_key_exists("properties", $producerConfig) ? $producerConfig["properties"] : null;
                $topicProps = array_key_exists("topic_properties", $producerConfig) ? $producerConfig["topic_properties"] : null;
                $def->addMethodCall('addProducer', [$producerName, $brokers, $props, $topic, $topicProps]);
            }
        }

        if (array_key_exists('consumers', $config) && is_array($config['consumers'])) {
            foreach ($config['consumers'] as $consumerName => $consumerConfig) {
                $brokers = $consumerConfig["brokers"];
                $topic = $consumerConfig["topic"];
                $props = array_key_exists("properties", $consumerConfig) ? $consumerConfig["properties"] : null;
                $topicProps = array_key_exists("topic_properties", $consumerConfig) ? $consumerConfig["topic_properties"] : null;
                $def->addMethodCall('addConsumer', [$consumerName, $brokers, $props, $topic, $topicProps]);
            }
        }

    }
}
