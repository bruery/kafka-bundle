<?php

namespace Bruery\KafkaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\EnumNodeDefinition;
use Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
abstract class AbstractConfiguration
{

    /**
     * Maximum transmit message size.
     * Default value: 1000000
     *
     * @return \Mshauneu\RdKafkaBundle\DependencyInjection\IntegerNodeDefinition
     */
    protected function messageMaxBytesNodeDef() {
        $node = new IntegerNodeDefinition('message_max_bytes');
        $node->min(1000)->max(1000000000);
        return $node;
    }

    /**
     * Maximum receive message size. This is a safety precaution to avoid memory exhaustion in case of protocol hickups.
     * The value should be at least fetch.message.max.bytes
     * number of partitions consumed from + messaging overhead (e.g. 200000 bytes).
     * Default value: 100000000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function receiveMessageMaxBytesNodeDef() {
        $node = new IntegerNodeDefinition('receive_message_max_bytes');
        $node->min(1000)->max(1000000000);
        return $node;
    }

    /**
     * Maximum number of in-flight requests the client will send. This setting applies per broker connection.
     * Default value: 1000000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function maxInFlightRequestsPerConnectionNodeDef() {
        $node = new IntegerNodeDefinition('max_in_flight_requests_per_connection');
        $node->min(1000)->max(1000000);
        return $node;
    }

    /**
     * Non-topic request timeout in milliseconds. This is for metadata requests, etc.
     * Default value: 60000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function metadataRequestTimeoutMsNodeDef() {
        $node = new IntegerNodeDefinition('metadata_request_timeout_ms');
        $node->min(10)->max(900000);
        return $node;
    }

    /**
     * Topic metadata refresh interval in milliseconds. The metadata is automatically refreshed
     * on error and connect. Use -1 to disable the intervalled refresh.
     * Default value: 300000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function topicMetadataRefreshIntervalMsNodeDef() {
        $node = new IntegerNodeDefinition('topic_metadata_refresh_interval_ms');
        $node->min(-1)->max(3600000);
        return $node;
    }

    /**
     * When a topic looses its leader this number of metadata requests are sent with
     * topic.metadata.refresh.fast.interval.ms interval disregarding the topic.metadata.refresh.interval.ms value.
     * This is used to recover quickly from transitioning leader brokers.
     * Default value: 10
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function topicMetadataRefreshFastCntNodeDef() {
        $node = new IntegerNodeDefinition('topic_metadata_refresh_fast_cnt');
        $node->min(0)->max(1000);
        return $node;
    }

    /**
     * @see topicMetadataRefreshFastCntNodeDef() description.
     * Default value: 250
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function topicMetadataRefreshFastIntervalMsNodeDef() {
        $node = new IntegerNodeDefinition('topic_metadata_refresh_fast_interval_ms');
        $node->min(1)->max(60000);
        return $node;
    }

    /**
     * Timeout for network requests.
     * Default value: 60000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function socketTimeoutMsNodeDef() {
        $node = new IntegerNodeDefinition('socket_timeout_ms');
        $node->min(0)->max(300000);
        return $node;
    }

    /**
     * Maximum time a broker socket operation may block. A lower value improves responsiveness at the
     * expense of slightly higher CPU usage.
     * Default value: 100
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function socketBlockingMaxMsNodeDef() {
        $node = new IntegerNodeDefinition('socket_blocking_max_ms');
        $node->min(1)->max(60000);
        return $node;
    }

    /**
     * Broker socket send buffer size.
     * Default value: 0
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function socketSendBufferBytesNodeDef() {
        $node = new IntegerNodeDefinition('socket_send_buffer_bytes');
        $node->min(0)->max(100000000);
        return $node;
    }

    /**
     * Broker socket receive buffer size.
     * Default value: 0
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function socketReceiveBufferBytesNodeDef() {
        $node = new IntegerNodeDefinition('socket_receive_buffer_bytes');
        $node->min(0)->max(100000000);
        return $node;
    }

    /**
     * Enable TCP keep-alives (SO_KEEPALIVE) on broker sockets.
     * Default value: false
     *
     * @return \Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition
     */
    protected function socketKeepaliveEnableNodeDef() {
        $node = new BooleanNodeDefinition('socket_keepalive_enable');
        return $node;
    }

    /**
     * Disconnect from broker when this number of send failures (e.g., timed out requests) is reached.
     * Disable with 0. NOTE: The connection is automatically re-established.
     * Default value: 0
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function socketMaxFailsNodeDef() {
        $node = new IntegerNodeDefinition('socket_max_fails');
        $node->min(0)->max(1000000);
        return $node;
    }

    /**
     * How long to cache the broker address resolving results (milliseconds).
     * Default value: 100
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function brokerAddressTtlNodeDef() {
        $node = new IntegerNodeDefinition('broker_address_ttl');
        $node->min(0)->max(86400000);
        return $node;
    }

    /**
     * Allowed broker IP address families: any, v4, v6.
     * Default value: any
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function brokerAddressFamilyNodeDef() {
        $node = new EnumNodeDefinition('broker_address_family');
        $node->values(array('any', 'v4', 'v6'));
        return $node;
    }

    /**
     * Protocol used to communicate with brokers.
     * Default value: plaintext
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function securityProtocolNodeDef() {
        $node = new EnumNodeDefinition('security_protocol');
        $node->values(array('plaintext', 'ssl', 'sasl_plaintext', 'sasl_ssl'));
        return $node;
    }

    /**
     * A cipher suite is a named combination of authentication, encryption, MAC and key exchange algorithm
     * used to negotiate the security settings for a network connection using TLS or SSL network protocol.
     * See manual page for ciphers(1) and `SSL_CTX_set_cipher_list(3).
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function sslCipherSuitesNodeDef() {
        $node = new ScalarNodeDefinition('ssl_cipher_suites');
        return $node;
    }

    /**
     * Path to client's private key (PEM) used for authentication.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function sslKeyLocationNodeDef() {
        $node = new ScalarNodeDefinition('ssl_key_location');
        return $node;
    }

    /**
     * Private key passphrase.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function sslKeyPasswordNodeDef() {
        $node = new ScalarNodeDefinition('ssl_key_password');
        return $node;
    }

    /**
     * Path to client's public key (PEM) used for authentication.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function sslCertificateLocationNodeDef() {
        $node = new ScalarNodeDefinition('ssl_certificate_location');
        return $node;
    }

    /**
     * File or directory path to CA certificate(s) for verifying the broker's key.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function sslCaLocationNodeDef() {
        $node = new ScalarNodeDefinition('ssl_ca_location');
        return $node;
    }

    /**
     * Path to CRL for verifying broker's certificate validity.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function sslCrlNodeDef() {
        $node = new ScalarNodeDefinition('ssl_crl_location');
        return $node;
    }

    /**
     * SASL mechanism to use for authentication. Supported: GSSAPI, PLAIN.
     * NOTE: Despite the name only one mechanism must be configured.
     * Default value: GSSAPI
     *
     * @return \Symfony\Component\Config\Definition\Builder\EnumNodeDefinition
     */
    protected function saslMechanismsNodeDef() {
        $node = new EnumNodeDefinition('sasl_mechanisms');
        $node->values(array('GSSAPI', 'PLAIN'));
        return $node;
    }

    /**
     * Kerberos principal name that Kafka runs as.
     * Default value: kafka
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function saslKerberosServiceNameNodeDef() {
        $node = new ScalarNodeDefinition('sasl_kerberos_service_name');
        return $node;
    }

    /**
     * This client's Kerberos principal name.
     * Default value: kafkaclient
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function saslKerberosPrincipalNodeDef() {
        $node = new ScalarNodeDefinition('sasl_kerberos_principal');
        return $node;
    }

    /**
     * Full kerberos kinit command string.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function saslKerberosKinitCmdNodeDef() {
        $node = new ScalarNodeDefinition('sasl_kerberos_kinit_cmd');
        return $node;
    }

    /**
     * Path to Kerberos keytab file. Uses system default if not set.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function saslKerberosKeytabNodeDef() {
        $node = new ScalarNodeDefinition('sasl_kerberos_keytab');
        return $node;
    }

    /**
     * Minimum time in milliseconds between key refresh attempts.
     * Default value: 60000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function saslKerberosMinTimeBeforeReloginNodeDef() {
        $node = new IntegerNodeDefinition('sasl_kerberos_min_time_before_relogin');
        $node->min(1)->max(86400000);
        return $node;
    }

    /**
     * SASL username for use with the PLAIN mechanism.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function saslUsernameNodeDef() {
        $node = new ScalarNodeDefinition('sasl_username');
        return $node;
    }

    /**
     * SASL password for use with the PLAIN mechanism.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function saslPasswordNodeDef() {
        $node = new ScalarNodeDefinition('sasl_password');
        return $node;
    }

    /**
     * Client group id string. All clients sharing the same `group.id` belong to the same group.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function groupIdNodeDef() {
        $node = new ScalarNodeDefinition('group_id');
        return $node;
    }

    /**
     * Client group session and failure detection timeout.
     * Default value: 30000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function sessionTimeoutMsNodeDef() {
        $node = new IntegerNodeDefinition('session_timeout_ms');
        $node->min(1)->max(3600000);
        return $node;
    }

    /**
     * Group session keepalive heartbeat interval.
     * Default value: 1000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function heartbeatIntervalMsNodeDef() {
        $node = new IntegerNodeDefinition('heartbeat_interval_ms');
        $node->min(1)->max(3600000);
        return $node;
    }

    protected function getPropertiesNodeDef() {
        $node = new ArrayNodeDefinition('properties');
        return $node
            ->canBeUnset()
            ->children()
            ->append($this->messageMaxBytesNodeDef())
            ->append($this->receiveMessageMaxBytesNodeDef())
            ->append($this->maxInFlightRequestsPerConnectionNodeDef())
            ->append($this->metadataRequestTimeoutMsNodeDef())
            ->append($this->topicMetadataRefreshIntervalMsNodeDef())
            ->append($this->topicMetadataRefreshFastCntNodeDef())
            ->append($this->topicMetadataRefreshFastIntervalMsNodeDef())
            ->append($this->socketTimeoutMsNodeDef())
            ->append($this->socketBlockingMaxMsNodeDef())
            ->append($this->socketSendBufferBytesNodeDef())
            ->append($this->socketReceiveBufferBytesNodeDef())
            ->append($this->socketKeepaliveEnableNodeDef())
            ->append($this->socketMaxFailsNodeDef())
            ->append($this->brokerAddressTtlNodeDef())
            ->append($this->brokerAddressFamilyNodeDef())
            ->append($this->securityProtocolNodeDef())
            ->append($this->sslCipherSuitesNodeDef())
            ->append($this->sslKeyLocationNodeDef())
            ->append($this->sslKeyPasswordNodeDef())
            ->append($this->sslCertificateLocationNodeDef())
            ->append($this->sslCaLocationNodeDef())
            ->append($this->sslCrlNodeDef())
            ->append($this->saslMechanismsNodeDef())
            ->append($this->saslKerberosServiceNameNodeDef())
            ->append($this->saslKerberosPrincipalNodeDef())
            ->append($this->saslKerberosKinitCmdNodeDef())
            ->append($this->saslKerberosKeytabNodeDef())
            ->append($this->saslKerberosMinTimeBeforeReloginNodeDef())
            ->append($this->saslUsernameNodeDef())
            ->append($this->saslPasswordNodeDef())
            ->append($this->groupIdNodeDef())
            ->append($this->sessionTimeoutMsNodeDef())
            ->append($this->heartbeatIntervalMsNodeDef())
            ->end()
            ;
    }

    /**
     * This field indicates how many acknowledgements the leader broker must receive from ISR brokers
     * before responding to the request:
     *   0=Broker does not send any response/ack to client,
     *   1=Only the leader broker will need to ack the message,
     *   -1 or all=broker will block until message is committed by all in sync replicas
     *   	(ISRs) or broker's `in.sync.replicas` setting before sending response.
     * Default value: 1
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function requestRequiredAcksNodeDef() {
        $node = new IntegerNodeDefinition('request_required_acks');
        $node->min(-1)->max(1000);
        return $node;
    }

    /**
     * The ack timeout of the producer request in milliseconds. This value is only enforced by the broker and
     * relies on `request.required.acks` being > 0.
     * Default value: 5000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function requestTimeoutMsNodeDef() {
        $node = new IntegerNodeDefinition('request_timeout_ms');
        $node->min(1)->max(900000);
        return $node;
    }

    /**
     * Local message timeout. This value is only enforced locally and limits the time a produced message waits
     * for successful delivery. A time of 0 is infinite.
     * Default value: 300000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function messageTimeoutMsNodeDef() {
        $node = new IntegerNodeDefinition('message_timeout_ms');
        $node->min(0)->max(900000);
        return $node;
    }

    /**
     * Report offset of produced message back to application.
     * Default value: false
     *
     * @return \Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition
     */
    protected function produceOffsetReportNodeDef() {
        $node = new BooleanNodeDefinition('produce_offset_report');
        return $node;
    }

    /**
     * Compression codec to use for compressing message sets.
     * Default value: inherit
     *
     * @return \Symfony\Component\Config\Definition\Builder\EnumNodeDefinition
     */
    protected function compressionCodecNodeDef() {
        $node = new EnumNodeDefinition('compression_codec');
        $node->values(array('none', 'gzip', 'snappy', 'lz4', 'inherit'));
        return $node;
    }


    protected function getTopicProducerPropertiesNodeDef() {
        $node = new ArrayNodeDefinition('topic_properties');
        return $node
            ->canBeUnset()
            ->children()
            ->append($this->requestRequiredAcksNodeDef())
            ->append($this->requestTimeoutMsNodeDef())
            ->append($this->messageTimeoutMsNodeDef())
            ->append($this->produceOffsetReportNodeDef())
            ->append($this->compressionCodecNodeDef())
            ->end()
            ;
    }

    /**
     * If true, periodically commit offset of the last message handed to the application.
     * This committed offset will be used when the process restarts to pick up where it left off.
     * If false, the application will have to call `rd_kafka_offset_store()` to store an offset (optional).
     * NOTE: This property should only be used with the simple legacy consumer, when using the high-level
     * KafkaConsumer the global `auto.commit.enable` property must be used instead.
     * NOTE: There is currently no zookeeper integration, offsets will be written to broker or local file
     * according to offset.store.method.
     * Default value: true
     *
     * @return \Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition
     */
    protected function autoCommitEnableNodeDef() {
        $node = new BooleanNodeDefinition('auto_commit_enable');
        return $node;
    }

    /**
     * The frequency in milliseconds that the consumer offsets are committed (written) to offset storage.
     * Default value: 60000
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function autoCommitIntervalMsNodeDef() {
        $node = new IntegerNodeDefinition('auto_commit_interval_ms');
        $node->min(10)->max(86400000);
        return $node;
    }

    /**
     * Action to take when there is no initial offset in offset store or the desired offset is out of
     * range: 'smallest','earliest' - automatically reset the offset to the smallest offset, 'largest',
     * 'latest' - automatically reset the offset to the largest offset,
     * 'error' - trigger an error which is retrieved by consuming messages and checking 'message->err'.
     * Default value: largest
     *
     * @return \Symfony\Component\Config\Definition\Builder\EnumNodeDefinition
     */
    protected function autoOffsetResetNodeDef() {
        $node = new EnumNodeDefinition('auto_offset_reset');
        $node->values(array('smallest', 'earliest', 'largest', 'latest', 'error'));
        return $node;
    }

    /**
     * Path to local file for storing offsets. If the path is a directory a filename will be automatically
     * generated in that directory based on the topic and partition.
     * Default value: .
     *
     * @return \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
     */
    protected function offsetStorePathNodeDef() {
        $node = new ScalarNodeDefinition('offset_store_path');
        return $node;
    }

    /**
     * fsync() interval for the offset file, in milliseconds. Use -1 to disable syncing, and 0 for
     * immediate sync after each write.
     * Default value: -1
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function offsetStoreSyncIntervalMsNodeDef() {
        $node = new IntegerNodeDefinition('offset_store_sync_interval_ms');
        $node->min(-1)->max(86400000);
        return $node;
    }

    /**
     * Offset commit store method:
     * 'file' - local file store (offset.store.path, et.al),
     * 'broker' - broker commit store (requires "group.id" to be configured and Apache Kafka 0.8.2 or later on the broker).
     * Default value: broker
     *
     * @return \Symfony\Component\Config\Definition\Builder\EnumNodeDefinition
     */
    protected function offsetStoreMethodNodeDef() {
        $node = new EnumNodeDefinition('offset_store_method');
        $node->values(array('file', 'broker'));
        return $node;
    }

    /**
     * Maximum number of messages to dispatch (0 = unlimited)
     * Default value: 0
     *
     * @return \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
     */
    protected function consumeCallbackMaxMessagesNodeDef() {
        $node = new IntegerNodeDefinition('consume_callback_max_messages');
        $node->min(-1)->max(1000000);
        return $node;
    }

    protected function getTopicConsumerPropertiesNodeDef() {
        $node = new ArrayNodeDefinition('topic_properties');
        return $node
            ->canBeUnset()
            ->children()
            ->append($this->autoCommitEnableNodeDef())
            ->append($this->autoCommitIntervalMsNodeDef())
            ->append($this->autoOffsetResetNodeDef())
            ->append($this->offsetStorePathNodeDef())
            ->append($this->offsetStoreSyncIntervalMsNodeDef())
            ->append($this->offsetStoreMethodNodeDef())
            ->append($this->consumeCallbackMaxMessagesNodeDef())
            ->end()
            ;
    }
}
