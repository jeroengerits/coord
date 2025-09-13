<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

return static function (RectorConfig $rectorConfig): void {
    // Define what your current PHP version is
    $rectorConfig->phpVersion(80200);

    // Define what sets of rules will be applied
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
        SetList::NAMING,
        SetList::INSTANCEOF,
    ]);

    // Define what directories to process
    $rectorConfig->paths([
        __DIR__.'/src',
    ]);

    // Define what directories to skip
    $rectorConfig->skip([
        // Skip vendor directory
        __DIR__.'/vendor',

        // Skip specific rules if needed
        InlineConstructorDefaultToPropertyRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
        RemoveUselessVarTagRector::class,
        ChangeIfElseValueAssignToEarlyReturnRector::class,
        FirstClassCallableRector::class,
        MyCLabsClassToEnumRector::class,
        ReadOnlyPropertyRector::class,
        AddVoidReturnTypeWhereNoReturnRector::class,
        ReturnTypeFromReturnNewRector::class,
        ReturnTypeFromStrictTypedCallRector::class,
        ReturnTypeFromStrictNewArrayRector::class,
        TypedPropertyFromStrictConstructorRector::class,
    ]);

    // Define parallel processing
    $rectorConfig->parallel();

    // Define cache directory
    $rectorConfig->cacheDirectory(__DIR__.'/.rector-cache');
};
