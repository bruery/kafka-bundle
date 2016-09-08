<?php

namespace Bruery\KafkaBundle\Command;

use Bruery\KafkaBundle\Model\Communicator;
use Bruery\KafkaBundle\Producer\TopicProducer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Produce Command
 *
 * @author Mike Shauneu <mike.shauneu@gmail.com>
 */
class TopicProduceCommand extends ContainerAwareCommand {

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Console\Command\Command::configure()
	 */
	protected function configure() {
		$this
			->setName('bruery:kafka:producer')
            ->setDescription('CLI for producing kafka messages.')
			->addOption('producer', null, InputOption::VALUE_REQUIRED, 'Producer')
			->addOption('partition', 'p', InputOption::VALUE_OPTIONAL, 'Partition')
			->addOption('key', 'k', InputOption::VALUE_OPTIONAL, 'Key')
			->addArgument('message', InputArgument::REQUIRED, 'Message')
		;
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
    protected function execute(InputInterface $input, OutputInterface $output) {
		$producer = $input->getOption('producer');

		$topicProducer = $this->getContainer()->get('bruery.kafka.manager')->getProducer($producer);
		if (!$topicProducer) {
			throw new \Exception(sprintf("TopicProducer with name '%s' is not defined", $producer));
		}

		$partition = $input->getOption('partition');
		if ($partition) {
			if(!is_numeric($partition) || $partition < 0) {
				throw new \Exception("Partition needs to be a number in the range 0..2^32-1");
			}
		} else {
			$partition = TopicCommunicator::PARTITION_UA;
		}

		$key = $input->getOption('key');

		$message = $input->getArgument('message');

		$topicProducer->produceStart();
		$topicProducer->produce($message, $partition, $key);
		$topicProducer->produceStop();
    }

}

