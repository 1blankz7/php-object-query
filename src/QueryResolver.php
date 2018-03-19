<?php

namespace ObjectQuery;

use ObjectQuery\Source\ArraySource;
use ObjectQuery\Source\ObjectSource;

/**
 * Class QueryResolver
 *
 * @package ObjectQuery
 * @author Christian Blank <christian@cubicl.de>
 */
final class QueryResolver implements QueryResolverInterface
{
    /**
     * @var QueryInterface[]
     */
    private $queries = [];

    /**
     * @param QueryInterface[] ...$queries
     */
    public function __construct(QueryInterface ...$queries)
    {
        foreach ($queries as $query) {
            $this->queries[$query->getName()] = $query;
        }
    }

    /**
     *
     * @param array|object $context
     *
     * @return array
     */
    public function resolveArray($context): array
    {
        return $this->map($context);
    }

    /**
     * @param array|object $context
     *
     * @return array
     */
    private function map($context): array
    {
        $context = $this->makeSource($context);
        $target = [];

        foreach ($this->queries as $query) {
            try {
                $target[$query->getName()] = $query->getDefinition()->getValue($context);
            } catch (\Throwable $e) {
                throw $e;
            }
        }

        return $target;
    }

    /**
     * @param array|object$context
     *
     * @return SourceInterface
     */
    private function makeSource($context)
    {
        if (is_array($context) || $context instanceof \ArrayAccess) {
            return new ArraySource($context);
        }

        return new ObjectSource($context);
    }
}
