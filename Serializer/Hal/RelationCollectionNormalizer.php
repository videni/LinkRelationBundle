<?php

namespace Videni\Bundle\LinkRelationBundle\Serializer\Hal;

use ApiPlatform\Core\Hal\Serializer\CollectionNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use ApiPlatform\Core\Serializer\AbstractCollectionNormalizer;

class RelationCollectionNormalizer implements NormalizerInterface
{
    use RelationNormalizerTrait;

    private $decorated;

    public function __construct(AbstractCollectionNormalizer $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);
        if (!isset($context['api_sub_level'])) {
            $relations = $this->getLinks($object, $context);

            return !empty($relations) ? array_merge_recursive($data, ['_links' => $relations]) : $data;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
