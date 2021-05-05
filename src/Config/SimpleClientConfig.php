<?php

namespace Cake\Queue\Config;

class SimpleClientConfig
{
    private $simpleClientConfig = [];

    private $queue = 'default';

    /**
     * __construct
     *
     * @param  mixed $queue the name of the queue drawn from Queue.default.queue or worker -Q queuename
     * @param  mixed $config the Queue.{configname} array where {configname} is the config name i.e. default
     * @return void
     */
    public function __construct(string $queue, array $config)
    {
        $this->create($queue, $config);
    }

    /**
     * get
     * return the SimpleClientConfig array
     * 
     * @return array
     */
    public function get(): array
    {
        return $this->simpleClientConfig;
    }

    /**
     * getQueue
     * Return the queue name
     *
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * create
     * Creates the config array to pass to SimpleClient(...)
     *
     * @param  mixed $queue queue name 
     * @param  mixed $config the Queue.configname array
     * @return void
     */
    public function create($queue, $config)
    {
        $this->queue = $queue !== 'default' ? $queue : $config['queue'];

        $this->simpleClientConfig = [
            'transport' => $config['url'],
            'client' =>
            [
                'prefix' => 'enqueue',
                'separator' => '.',
                'app_name' => 'app',
                'router_topic' => $this->queue,
                'router_queue' => $this->queue,
                'default_queue' => $this->queue,
            ],
            'extensions' => [
                'signal_extension' => false,
                'reply_extension' => false,
            ],
        ];
    }
}
