<?php

namespace App\Swagger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SwaggerDecorator
 * @package App\Swagger
 *
 * This decorator is used to add custom api endpoint to api platform doc
 * Annotate your api with OpenApi and run make generate-open-api
 */

class SwaggerDecorator implements NormalizerInterface
{
    private NormalizerInterface $decorated;

    private LoggerInterface $logger;

    private ?string $customSwaggerPath;

    private Filesystem $filesystem;

    public function __construct(
        NormalizerInterface $decorated,
        ?string $customSwaggerPath,
        LoggerInterface $logger,
        Filesystem $filesystem
    )
    {
        $this->decorated = $decorated;
        $this->logger = $logger ?? new NullLogger();
        $this->customSwaggerPath = $customSwaggerPath;
        $this->filesystem = $filesystem;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        if (null !== $this->customSwaggerPath && $this->filesystem->exists($this->customSwaggerPath)) {
            $customSwagger = json_decode(file_get_contents($this->customSwaggerPath), true);
            if (null !== $customSwagger) {
                $docs['paths'] = array_merge($docs['paths']->getArrayCopy(), $customSwagger['paths']);
            }
        }


        return $docs;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}