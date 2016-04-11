<?php

namespace Yuloh\Pipeline;

/**
 * A simple pipeline implementation.  Aims to have the simplest API possible.
 */
class Pipeline
{
    /**
     * @var []
     */
    private $stages;

    /**
     * @var mixed
     */
    private $payload;

    /**
     * @param mixed $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @param  callable|null $stage A callable to process the payload.
     * @param  mixed         $args  The arguments to pass to the stage.
     * @return mixed
     */
    public function __invoke($stage = null, ...$args)
    {
        if (func_num_args() === 0) {
            return $this->process();
        }

        $this->stages[] = [
            $stage,
            $args
        ];

        return $this;
    }

    /**
     * Process the payload.  The stages will be invoked in the order they were registered.
     * Stages will be invoked with the payload and any arguments.
     *
     * @return mixed
     */
    private function process()
    {
        $payload = $this->payload;
        foreach ($this->stages as $stage) {
            $payload = $stage[0]($payload, ...$stage[1]);
        }

        return $payload;
    }
}
