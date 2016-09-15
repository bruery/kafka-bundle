<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\KafkaBundle\Consumer;

use RdKafka\Consumer;
use RdKafka\ConsumerTopic;
use Bruery\KafkaBundle\Model\Communicator;

class DefaultConsumer implements ConsumerInterface {
    /**
     * @param ConsumerInterface $consumer
     * @param number $partition
     * @param number $timeoutInMs
     * @throws \Exception
     */
    public function consume($topic, $partition, $offset, $key, $payload) {
        //echo "Received payload: " . $payload . PHP_EOL;
        dump($payload);
    }
}