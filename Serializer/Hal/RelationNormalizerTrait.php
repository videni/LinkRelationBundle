<?php

namespace Videni\Bundle\LinkRelationBundle\Serializer\Hal;

use Hateoas\Configuration\RelationsRepository;

trait RelationNormalizerTrait
{
    private $linksFactory;

    public function setLinksFactory($linksFactory)
    {
        $this->linksFactory = $linksFactory;
    }

    public function getLinks($object, array $context)
    {
        $links =  $this->linksFactory->create($object, $context);

        return $this->serializeLinks($links, $context);
    }

     /**
     * {@inheritdoc}
     */
    public function serializeLinks(array $links, $context)
    {
        $serializedLinks = array();
        foreach ($links as $link) {
            $serializedLink = array_merge(array(
                'href' => $link->getHref(),
            ), $link->getAttributes());

            if (!isset($serializedLinks[$link->getRel()]) && 'curies' !== $link->getRel()) {
                $serializedLinks[$link->getRel()] = $serializedLink;
            } elseif (isset($serializedLinks[$link->getRel()]['href'])) {
                $serializedLinks[$link->getRel()] = array(
                    $serializedLinks[$link->getRel()],
                    $serializedLink
                );
            } else {
                $serializedLinks[$link->getRel()][] = $serializedLink;
            }
        }

        return $serializedLinks;
    }
}
