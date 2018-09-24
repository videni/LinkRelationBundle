<?php

namespace Videni\Bundle\LinkRelationBundle\Factory;

use Hateoas\Configuration\RelationsRepository;
use Hateoas\Model\Link;
use Videni\Bundle\LinkRelationBundle\Serializer\ExclusionManager;
use Hateoas\Factory\LinkFactory;

class LinksFactory
{
    /**
     * @var RelationsRepository
     */
    private $relationsRepository;

    /**
     * @var LinkFactory
     */
    private $linkFactory;

    /**
     * @var ExclusionManager
     */
    private $exclusionManager;

    /**
     * @param RelationsRepository $relationsRepository
     * @param LinkFactory         $linkFactory
     * @param ExclusionManager    $exclusionManager
     */
    public function __construct(RelationsRepository $relationsRepository, LinkFactory $linkFactory, ExclusionManager $exclusionManager)
    {
        $this->relationsRepository = $relationsRepository;
        $this->linkFactory         = $linkFactory;
        $this->exclusionManager    = $exclusionManager;
    }

    /**
     * @param object               $object
     * @param array $context
     *
     * @return Link[]
     */
    public function create($object, array $context)
    {
        $links = array();
        foreach ($this->relationsRepository->getRelations($object) as $relation) {
            if ($this->exclusionManager->shouldSkipLink($object, $relation, $context)) {
                continue;
            }

            $links[] = $this->linkFactory->createLink($object, $relation);
        }

        return $links;
    }
}
