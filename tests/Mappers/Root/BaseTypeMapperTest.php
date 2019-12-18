<?php

namespace TheCodingMachine\GraphQLite\Mappers\Root;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\Resource_;
use ReflectionMethod;
use TheCodingMachine\GraphQLite\AbstractQueryProviderTest;
use TheCodingMachine\GraphQLite\GraphQLRuntimeException;
use TheCodingMachine\GraphQLite\TypeMappingRuntimeException;

class BaseTypeMapperTest extends AbstractQueryProviderTest
{

    public function testNullableToGraphQLInputType(): void
    {
        $baseTypeMapper = new BaseTypeMapper(new FinalRootTypeMapper($this->getTypeMapper()), $this->getTypeMapper(), $this->getRootTypeMapper());

        $this->expectException(TypeMappingRuntimeException::class);
        $this->expectExceptionMessage("Don't know how to handle type ?\Exception");
        $baseTypeMapper->toGraphQLInputType(new Nullable(new Object_(new Fqsen('\\Exception'))), null, 'foo', new ReflectionMethod(BaseTypeMapper::class, '__construct'), new DocBlock());
    }

    public function testToGraphQLOutputTypeException(): void
    {
        $baseTypeMapper = new BaseTypeMapper(new FinalRootTypeMapper($this->getTypeMapper()), $this->getTypeMapper(), $this->getRootTypeMapper());

        $this->expectException(GraphQLRuntimeException::class);
        //$this->expectExceptionMessage('Type-hinting a parameter against DateTime is not allowed. Please use the DateTimeImmutable type instead.');
        $this->expectExceptionMessage('Don\'t know how to handle type \DateTime');
        $baseTypeMapper->toGraphQLInputType(new Object_(new Fqsen('\\DateTime')), null, 'foo', new ReflectionMethod(BaseTypeMapper::class, '__construct'), new DocBlock());
    }

    public function testUnmappableOutputArray(): void
    {
        $baseTypeMapper = new BaseTypeMapper(new FinalRootTypeMapper($this->getTypeMapper()), $this->getTypeMapper(), $this->getRootTypeMapper());

        $this->expectException(TypeMappingRuntimeException::class);
        $this->expectExceptionMessage("Don't know how to handle type resource");
        $mappedType = $baseTypeMapper->toGraphQLOutputType(new Array_(new Resource_()), null, new ReflectionMethod(BaseTypeMapper::class, '__construct'), new DocBlock());
    }

    public function testUnmappableInputArray(): void
    {
        $baseTypeMapper = new BaseTypeMapper(new FinalRootTypeMapper($this->getTypeMapper()), $this->getTypeMapper(), $this->getRootTypeMapper());

        $this->expectException(TypeMappingRuntimeException::class);
        $this->expectExceptionMessage("Don't know how to handle type resource");
        $mappedType = $baseTypeMapper->toGraphQLInputType(new Array_(new Resource_()), null, 'foo', new ReflectionMethod(BaseTypeMapper::class, '__construct'), new DocBlock());
    }
}
