<?php

namespace Videni\Bundle\LinkRelationBundle\Serializer;

use Hateoas\Configuration\Exclusion;
use Hateoas\Configuration\Relation;
use Hateoas\Expression\ExpressionEvaluator;
use Hateoas\Serializer\Metadata\RelationPropertyMetadata;

class ExclusionManager
{
    /**
     * @var ExpressionEvaluator
     */
    private $expressionEvaluator;

    public function __construct(ExpressionEvaluator $expressionEvaluator)
    {
        $this->expressionEvaluator = $expressionEvaluator;
    }

    public function shouldSkipLink($object, Relation $relation, array $context)
    {
        if ($this->shouldSkipRelation($object, $relation, $context)) {
            return true;
        }

        if (null === $relation->getHref()) {
            return true;
        }

        return false;
    }

    private function shouldSkipRelation($object, Relation $relation, array $context)
    {
        return $this->shouldSkip($object, $relation, $relation->getExclusion(), $context);
    }

    private function shouldSkip($object, Relation $relation, Exclusion $exclusion = null, array $context)
    {
        if (null == $exclusion) {
            return false;
        }

        if (count(array_intersect($exclusion->getGroups(), $context['groups'])) == 0) {
            return true;
        }

        if (null !== $exclusion->getExcludeIf()
            && $this->expressionEvaluator->evaluate($exclusion->getExcludeIf(), $object)
        ) {
            return true;
        }


        return false;
    }
}
