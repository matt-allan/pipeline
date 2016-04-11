<?php

namespace Yuloh\Pipeline;

/**
 * Creates a new Pipeline.
 *
 * @param  mixed $payload
 * @return Pipeline
 */
function pipe($payload)
{
    return (new Pipeline($payload));
}
