<?php

namespace Yuloh\Pipeline;

/**
 * A simple pipeline implementation.  Aims to have the simplest API possible.
 */
class Pipeline
{
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
     * @return $this
     */
    public function __invoke($stage = null, ...$args)
    {
        if (func_num_args() === 0) {
            return $this->get();
        }

        $this->payload = $stage($this->payload, ...$args);

        return $this;
    }

    /**
     * @param  string $name
     * @param  array $arguments [description]
     * @return $this
     */
    public function __call($name, $arguments)
    {
        return $this->__invoke($name, ...$arguments);
    }

    /**
     * Returns the processed payload.
     *
     * @return mixed The payload after being processed by each stage.
     */
    public function get()
    {
        return $this->payload;
    }
}
