<?php

declare(strict_types=1);

use Jeroengerits\Coord\ValueObjects\Longitude;

it('creates a valid longitude', function () {
    $longitude = new Longitude(-74.0060);

    expect($longitude->value())->toBe(-74.0060);
});

it('throws exception for longitude below -180', function () {
    expect(fn () => new Longitude(-181.0))
        ->toThrow(InvalidArgumentException::class, 'Longitude must be between -180 and 180 degrees');
});

it('throws exception for longitude above 180', function () {
    expect(fn () => new Longitude(181.0))
        ->toThrow(InvalidArgumentException::class, 'Longitude must be between -180 and 180 degrees');
});

it('accepts longitude at -180 degrees', function () {
    $longitude = new Longitude(-180.0);

    expect($longitude->value())->toBe(-180.0);
});

it('accepts longitude at 180 degrees', function () {
    $longitude = new Longitude(180.0);

    expect($longitude->value())->toBe(180.0);
});

it('is equal to another longitude with same value', function () {
    $longitude1 = new Longitude(-74.0060);
    $longitude2 = new Longitude(-74.0060);

    expect($longitude1->equals($longitude2))->toBeTrue();
});

it('is not equal to another longitude with different value', function () {
    $longitude1 = new Longitude(-74.0060);
    $longitude2 = new Longitude(-75.0060);

    expect($longitude1->equals($longitude2))->toBeFalse();
});

it('converts to string', function () {
    $longitude = new Longitude(-74.0060);

    expect((string) $longitude)->toBe('-74.006');
});

it('converts to array', function () {
    $longitude = new Longitude(-74.0060);

    expect($longitude->toArray())->toBe(['longitude' => -74.0060]);
});

it('creates from string', function () {
    $longitude = Longitude::fromString('-74.0060');

    expect($longitude->value())->toBe(-74.0060);
});

it('throws exception when creating from invalid string', function () {
    expect(fn () => Longitude::fromString('invalid'))
        ->toThrow(InvalidArgumentException::class, 'Invalid longitude value: invalid');
});

it('determines if longitude is in eastern hemisphere', function () {
    $easternLongitude = new Longitude(120.0);
    $westernLongitude = new Longitude(-120.0);

    expect($easternLongitude->isEastern())->toBeTrue();
    expect($westernLongitude->isEastern())->toBeFalse();
});

it('determines if longitude is in western hemisphere', function () {
    $easternLongitude = new Longitude(120.0);
    $westernLongitude = new Longitude(-120.0);

    expect($easternLongitude->isWestern())->toBeFalse();
    expect($westernLongitude->isWestern())->toBeTrue();
});

it('determines if longitude is at prime meridian', function () {
    $primeMeridianLongitude = new Longitude(0.0);
    $nonPrimeMeridianLongitude = new Longitude(-74.0060);

    expect($primeMeridianLongitude->isPrimeMeridian())->toBeTrue();
    expect($nonPrimeMeridianLongitude->isPrimeMeridian())->toBeFalse();
});

it('determines if longitude is at international date line', function () {
    $dateLineLongitude = new Longitude(180.0);
    $nonDateLineLongitude = new Longitude(-74.0060);

    expect($dateLineLongitude->isInternationalDateLine())->toBeTrue();
    expect($nonDateLineLongitude->isInternationalDateLine())->toBeFalse();
});
