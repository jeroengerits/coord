<?php

declare(strict_types=1);

use Jeroengerits\Coord\ValueObjects\Latitude;

it('creates a valid latitude', function () {
    $latitude = new Latitude(40.7128);

    expect($latitude->value())->toBe(40.7128);
});

it('throws exception for latitude below -90', function () {
    expect(fn () => new Latitude(-91.0))
        ->toThrow(InvalidArgumentException::class, 'Latitude must be between -90 and 90 degrees');
});

it('throws exception for latitude above 90', function () {
    expect(fn () => new Latitude(91.0))
        ->toThrow(InvalidArgumentException::class, 'Latitude must be between -90 and 90 degrees');
});

it('accepts latitude at -90 degrees', function () {
    $latitude = new Latitude(-90.0);

    expect($latitude->value())->toBe(-90.0);
});

it('accepts latitude at 90 degrees', function () {
    $latitude = new Latitude(90.0);

    expect($latitude->value())->toBe(90.0);
});

it('is equal to another latitude with same value', function () {
    $latitude1 = new Latitude(40.7128);
    $latitude2 = new Latitude(40.7128);

    expect($latitude1->equals($latitude2))->toBeTrue();
});

it('is not equal to another latitude with different value', function () {
    $latitude1 = new Latitude(40.7128);
    $latitude2 = new Latitude(41.7128);

    expect($latitude1->equals($latitude2))->toBeFalse();
});

it('converts to string', function () {
    $latitude = new Latitude(40.7128);

    expect((string) $latitude)->toBe('40.7128');
});

it('converts to array', function () {
    $latitude = new Latitude(40.7128);

    expect($latitude->toArray())->toBe(['latitude' => 40.7128]);
});

it('creates from string', function () {
    $latitude = Latitude::fromString('40.7128');

    expect($latitude->value())->toBe(40.7128);
});

it('throws exception when creating from invalid string', function () {
    expect(fn () => Latitude::fromString('invalid'))
        ->toThrow(InvalidArgumentException::class, 'Invalid latitude value: invalid');
});

it('determines if latitude is in northern hemisphere', function () {
    $northernLatitude = new Latitude(40.7128);
    $southernLatitude = new Latitude(-40.7128);

    expect($northernLatitude->isNorthern())->toBeTrue();
    expect($southernLatitude->isNorthern())->toBeFalse();
});

it('determines if latitude is in southern hemisphere', function () {
    $northernLatitude = new Latitude(40.7128);
    $southernLatitude = new Latitude(-40.7128);

    expect($northernLatitude->isSouthern())->toBeFalse();
    expect($southernLatitude->isSouthern())->toBeTrue();
});

it('determines if latitude is at equator', function () {
    $equatorLatitude = new Latitude(0.0);
    $nonEquatorLatitude = new Latitude(40.7128);

    expect($equatorLatitude->isEquator())->toBeTrue();
    expect($nonEquatorLatitude->isEquator())->toBeFalse();
});
