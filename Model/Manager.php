<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\KafkaBundle\Model;

class Manager {

	/**
	 * @var Producer[]
	 */
	protected $producers = array();

	/**
	 * @var Consumer[]
	 */
	protected $consumers = array();


	/**
	 * @param string $name
	 * @param $props
	 */
	public function addProducer($name, $brokers, $props, $topic, $topicProps) {
		$this->producers[$name] = new TopicProducer($brokers, $props, $topic, $topicProps);
	}

	/**
	 * @param string $name
	 * @return TopicProducer
	 */
	public function getProducer($name) {
		return array_key_exists($name, $this->producers) ? $this->producers[$name] : null;
	}

	/**
	 * @param string $name
	 * @param $props
	 */
	public function addConsumer($name, $brokers, $props, $topic, $topicProps) {
		$this->consumers[$name] = new TopicConsumer($brokers, $props, $topic, $topicProps);
	}


	/**
	 * @param $name
	 * @return TopicConsumer
	 */
	public function getConsumer($name) {
		return array_key_exists($name, $this->consumers) ? $this->consumers[$name] : null;
	}

}