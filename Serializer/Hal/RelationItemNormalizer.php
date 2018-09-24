<?php

namespace Videni\Bundle\LinkRelationBundle\Serializer\Hal;

use ApiPlatform\Core\Hal\Serializer\ItemNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RelationItemNormalizer implements NormalizerInterface
{
    use RelationNormalizerTrait;

    private $decorated;

    public function __construct(ItemNormalizer $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);

        $links = $this->getLinks($object, $context);

        return !empty($links) ? array_merge_recursive($data, ['_links'=> $links]) : $data;
    }

     /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
