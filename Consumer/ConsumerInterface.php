<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\KafkaBundle\Consumer;

interface ConsumerInterface {

	/**
	 * Consume
	 *
	 * @param string $topic Topic name
	 * @param int $partition Partition
	 * @param int $offset Message offset
	 * @param string $key Optional message key
	 * @param string $payload Message payload
	 * @return mixed
	 */
	public function consume($topic, $partition, $offset, $key, $payload);

}