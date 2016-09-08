## Installation
Add the dependency in your composer.json
```json
{
    "require": {
        "bruery/kafka-bundle": "^1.0"
    }
}
```
Enable the bundle in your application kernel
```php
// app/AppKernel.php
public function registerBundles() {
    $bundles = array(
        // ...
        new Bruery\KafkaBundle\BrueryKafkaBundle(),
    );
}
```
## Configuration
Simple configuration could look like:
```yaml
bruery_kafka:
  producers: 
    test_producer: 
      brokers: 127.0.0.1:9092
      topic: sample_topic   
  consumers:
    test_consumer:
      brokers: 127.0.0.1:9092
      topic: sample_topic   
      properties: 
        group_id: "sample_group_id"
      topic_properties: 
        offset_store_method: broker           
        auto_offset_reset: smallest
        auto_commit_interval_ms: 100
```

## Usage
### Publishing messages to a Kafka topic
From a Symfony controller:
```php
$payload = 'test_message';
$topicProducer = $container->get('bruery.kafka.manager')->getProducer("sample_test_producer");
$topicProducer->produceStart();
$topicProducer->produce("message");
$topicProducer->produceStop();
``` 
By CLI:
```bash
./app/console kafka:producer --producer test_producer test_message 
```

### Consume messages out of a Kafka topic:
Implement [ConsumerInterface](https://github.com/bruery/kafka-bundle/blob/master/Consumer/ConsumerInterface.php)
```php
class MessageHandler implements ConsumerInterface {
	public function consume($topic, $partition, $offset, $key, $payload) {
		echo "Received payload: " . $payload . PHP_EOL;
	}
}
```
Register it: 
```yaml
test_message_handler:
    class: MessageHandler
```
From a Symfony controller:
```php
$topicConsumer = $container->get('bruery.kafka.manager'')->getConsumer("sample_test_producer");
$topicConsumer->consumeStart(TopicCommunicator::OFFSET_STORED);
$topicConsumer->consume($consumerImpl);
$topicConsumer->consumeStop();
```
