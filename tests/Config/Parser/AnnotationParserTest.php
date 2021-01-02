<?php

declare(strict_types=1);

namespace Overblog\GraphQLBundle\Tests\Config\Parser;

use Overblog\GraphQLBundle\Config\Parser\AnnotationParser;
use SplFileInfo;

class AnnotationParserTest extends MetadataParserTest
{
    public function parser($method, ...$args)
    {
        return AnnotationParser::$method(...$args);
    }

    public function formatMetadata(string $metadata): string
    {
        return sprintf('@%s', $metadata);
    }

    public function testLegacyNestedAnnotations(): void
    {
        $this->config = self::cleanConfig($this->parser('parse', new SplFileInfo(__DIR__.'/fixtures/annotations/Deprecated/Deprecated.php'), $this->containerBuilder, ['doctrine' => ['types_mapping' => []]]));
        $this->expect('Deprecated', 'object', [
            'fields' => [
                'color' => ['type' => 'String!'],
                'getList' => [
                    'args' => [
                        'arg1' => ['type' => 'String!'],
                        'arg2' => ['type' => 'Int!'],
                    ],
                    'resolve' => '@=call(value.getList, arguments({arg1: "String!", arg2: "Int!"}, args))',
                    'type' => 'Boolean!',
                ],
            ],
            'builders' => [
                ['builder' => 'MyFieldsBuilder', 'builderConfig' => ['param1' => 'val1']],
            ],
        ]);
    }
}
