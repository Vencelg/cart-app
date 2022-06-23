<?php

namespace CartApp\Core\Service;

/**
 * MqttService
 */
class MqttService
{
    /**
     * MqttService constructor.
     * @param $host
     * @param $tcpPort
     */

    protected $mqtt;

    public function __construct($host, $tcpPort)
    {
        $this->mqtt = new \PhpMqtt\Client\MqttClient($host, $tcpPort);
    }

    public function publish(string $topic, string $message): void
    {
        $this->mqtt->connect();
        $this->mqtt->publish($topic, $message);
        $this->mqtt->disconnect();
    }
}