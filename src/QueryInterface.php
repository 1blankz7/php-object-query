<?php

namespace ObjectQuery;

/**
 * Interface QueryInterface
 * @package ObjectQuery
 * @author Christian Blank <christian@cubicl.de>
 */
interface QueryInterface
{
    public function getName(): string;

    public function getDefinition(): DefinitionInterface;
}
