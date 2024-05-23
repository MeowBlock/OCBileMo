<?php
declare(strict_types=1);

namespace App\Api\Documentation;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsDecorator('api_platform.openapi.normalizer.api_gateway')]
final class MyAlteration implements NormalizerInterface, SerializerAwareInterface
{
    private NormalizerInterface $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

        public function setSerializer(SerializerInterface $serializer)
    {
        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }

    public function getSupportedTypes(?string $format): array {
        return $this->decorated->getSupportedTypes($format);
    }

    public function supportsNormalization($data, string|null $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, string|null $format = null, array $context = []): array
    {


        /** @var array $docs */
        $docs = $this->decorated->normalize($object, $format, $context);

        // Make some changes to $docs here.


        // Add the JWT Authentication request object
$docs['components']['schemas']['JWTAuth'] = [
    'type' => 'object',
    'properties' => [
        'email' => ['type' => 'string', 'format' => 'email'],
        'password' => ['type' => 'string'],
    ],
];

// Add the JWT Refresh request object
$docs['components']['schemas']['JWTRefresh'] = [
    'type' => 'object',
    'properties' => [
        'refresh_token' => ['type' => 'string', 'nullable' => false],
    ],
    'required' => [
        'refresh_token'
    ]
];

// Add the JWT response object (used in both auth and refresh).
$docs['components']['schemas']['JWTResponse'] = [
    'type' => 'object',
    'properties' => [
        'token' => ['type' => 'string'],
        'refresh_token' => ['type' => 'string'],
    ],
];



        $docs['paths']['/api/token/refresh']['post'] = [
            'tags' => ['Authentication'],
            'operationId' => 'jwt_refresh',
            'summary' => 'Refresh JWT Token',
            'requestBody' => [
                'required' => false,
                'content' => [
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/JWTRefresh',
                        ],
                    ],
                ],
            ],
            'responses' => [
                200 => [
                    'description' => 'Refresh successful',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/JWTResponse',
                            ],
                        ],
                    ],
                ],
                400 => [
                    'description' => 'Bad request: missing or incorrect body',
                ],
                401 => [
                    'description' => 'An authentication exception occurred: incorrect or expired refresh token',
                ],
            ],
        ];
        ksort($docs['components']['schemas']);
        ksort($docs['paths']);
        
        return $docs;

    }
}