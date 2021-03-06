<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace  Bruery\KafkaBundle\Model;

use RdKafka\Conf;
use RdKafka\TopicConf;

abstract class Communicator {

	const PARTITION_UA = -1;
	const OFFSET_BEGINNING = -2;
	const OFFSET_END = -1;
	const OFFSET_STORED = -1000;

	protected $brokers;
	protected $props;
	protected $topic;
	protected $topicProps;

	/**
	 * @param string $brokers
	 * @param object $props
	 * @param string $topic
	 * @param object $topicProps
	 */
	public function __construct($brokers, $props, $topic, $topicProps) {
		$this->brokers = $brokers;
		$this->props = $props;
		$this->topic = $topic;
		$this->topicProps = $topicProps;
	}

	/**
	 * @param object $props
	 * @return \RdKafka\Conf
	 */
	protected function getConfig($props) {
		$conf = new Conf();
		if (null !== $props) {
			foreach ($props as $name => $value) {
				$conf->set(str_replace("_", ".", $name), $value);
			}
		}
		return $conf;
	}

	/**
	 * @param object $props
	 * @return \RdKafka\TopicConf
	 */
	protected function getTopicConfig($props) {
		$topicConf = new TopicConf();
		if (null !== $props) {
			foreach ($props as $name => $value) {
			    if($value === false) {
			        $value = 0;
                }
				$topicConf->set(str_replace("_", ".", $name), $value);
			}
		}
		return $topicConf;
	}

}