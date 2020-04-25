<?php

namespace TheCodingMachine\GraphQLite\Mappers\Root;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Types\Object_;
use ReflectionMethod;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use TheCodingMachine\GraphQLite\AbstractQueryProviderTest;
use TheCodingMachine\GraphQLite\Mappers\CannotMapTypeException;

class MyCLabsEnumTypeMapperTest extends AbstractQueryProviderTest
{

    public function testObjectTypeHint(): void
    {
        $mapper = new MyCLabsEnumTypeMapper(new FinalRootTypeMapper($this->getTypeMapper()), $this->getAnnotationReader(), new ArrayAdapter(), []);

        $this->expectException(CannotMapTypeException::class);
        $this->expectExceptionMessage("don't know how to handle type object");
        $mapper->toGraphQLOutputType(new Object_(), null, new ReflectionMethod(__CLASS__, 'testObjectTypeHint'), new DocBlock());
    }
}
