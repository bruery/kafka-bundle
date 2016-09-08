<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\KafkaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\EnumNodeDefinition;
use Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('bruery_kafka');

	    $node
			->children()
				->arrayNode('producers')
					->canBeUnset()
					->prototype('array')
						->children()
							->scalarNode('brokers')->isRequired()->end()
							->scalarNode('topic')->isRequired()->end()
							->append($this->getPropertiesNodeDef())
							->append($this->getTopicProducerPropertiesNodeDef())
						->end()
					->end()
				->end()

				->arrayNode('consumers')
					->canBeUnset()
					->prototype('array')
						->children()
							->scalarNode('brokers')->isRequired()->end()
							->scalarNode('topic')->isRequired()->end()
							->append($this->getPropertiesNodeDef())
							->append($this->getTopicConsumerPropertiesNodeDef())
						->end()
					->end()
				->end()
			->end()
		;

        return $treeBuilder;
    }
}
