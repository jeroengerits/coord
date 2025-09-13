<?php

declare(strict_types=1);

use Jeroengerits\Coord\ValueObjects\Coordinates;
use Jeroengerits\Coord\ValueObjects\Latitude;
use Jeroengerits\Coord\ValueObjects\Longitude;

it('creates coordinates with latitude and longitude', function () {
    $latitude = new Latitude(40.7128);
    $longitude = new Longitude(-74.0060);
    $coordinates = new Coordinates($latitude, $longitude);

    expect($coordinates->latitude())->toBe($latitude);
    expect($coordinates->longitude())->toBe($longitude);
});

it('creates coordinates from float values', function () {
    $coordinates = Coordinates::fromFloats(40.7128, -74.0060);

    expect($coordinates->latitude()->value())->toBe(40.7128);
    expect($coordinates->longitude()->value())->toBe(-74.0060);
});

it('creates coordinates from array', function () {
    $coordinates = Coordinates::fromArray([
        'latitude' => 40.7128,
        'longitude' => -74.0060,
    ]);

    expect($coordinates->latitude()->value())->toBe(40.7128);
    expect($coordinates->longitude()->value())->toBe(-74.0060);
});

it('throws exception when creating from array with missing latitude', function () {
    expect(fn () => Coordinates::fromArray(['longitude' => -74.0060]))
        ->toThrow(InvalidArgumentException::class, 'Array must contain both latitude and longitude keys');
});

it('throws exception when creating from array with missing longitude', function () {
    expect(fn () => Coordinates::fromArray(['latitude' => 40.7128]))
        ->toThrow(InvalidArgumentException::class, 'Array must contain both latitude and longitude keys');
});

it('creates coordinates from string', function () {
    $coordinates = Coordinates::fromString('40.7128,-74.0060');

    expect($coordinates->latitude()->value())->toBe(40.7128);
    expect($coordinates->longitude()->value())->toBe(-74.0060);
});

it('creates coordinates from string with space after comma', function () {
    $coordinates = Coordinates::fromString('40.7128, -74.0060');

    expect($coordinates->latitude()->value())->toBe(40.7128);
    expect($coordinates->longitude()->value())->toBe(-74.0060);
});

it('throws exception when creating from invalid string format', function () {
    expect(fn () => Coordinates::fromString('40.7128'))
        ->toThrow(InvalidArgumentException::class, 'Invalid coordinates format. Expected "latitude,longitude"');
});

it('throws exception when creating from string with invalid latitude', function () {
    expect(fn () => Coordinates::fromString('91.0,-74.0060'))
        ->toThrow(InvalidArgumentException::class, 'Latitude must be between -90 and 90 degrees');
});

it('throws exception when creating from string with invalid longitude', function () {
    expect(fn () => Coordinates::fromString('40.7128,181.0'))
        ->toThrow(InvalidArgumentException::class, 'Longitude must be between -180 and 180 degrees');
});

it('is equal to another coordinates with same values', function () {
    $coordinates1 = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));
    $coordinates2 = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($coordinates1->equals($coordinates2))->toBeTrue();
});

it('is not equal to another coordinates with different latitude', function () {
    $coordinates1 = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));
    $coordinates2 = new Coordinates(new Latitude(41.7128), new Longitude(-74.0060));

    expect($coordinates1->equals($coordinates2))->toBeFalse();
});

it('is not equal to another coordinates with different longitude', function () {
    $coordinates1 = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));
    $coordinates2 = new Coordinates(new Latitude(40.7128), new Longitude(-75.0060));

    expect($coordinates1->equals($coordinates2))->toBeFalse();
});

it('converts to string', function () {
    $coordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect((string) $coordinates)->toBe('40.7128,-74.006');
});

it('converts to array', function () {
    $coordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($coordinates->toArray())->toBe([
        'latitude' => 40.7128,
        'longitude' => -74.0060,
    ]);
});

it('determines if coordinates are in northern hemisphere', function () {
    $northernCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));
    $southernCoordinates = new Coordinates(new Latitude(-40.7128), new Longitude(-74.0060));

    expect($northernCoordinates->isNorthern())->toBeTrue();
    expect($southernCoordinates->isNorthern())->toBeFalse();
});

it('determines if coordinates are in southern hemisphere', function () {
    $northernCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));
    $southernCoordinates = new Coordinates(new Latitude(-40.7128), new Longitude(-74.0060));

    expect($northernCoordinates->isSouthern())->toBeFalse();
    expect($southernCoordinates->isSouthern())->toBeTrue();
});

it('determines if coordinates are in eastern hemisphere', function () {
    $easternCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(120.0));
    $westernCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-120.0));

    expect($easternCoordinates->isEastern())->toBeTrue();
    expect($westernCoordinates->isEastern())->toBeFalse();
});

it('determines if coordinates are in western hemisphere', function () {
    $easternCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(120.0));
    $westernCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-120.0));

    expect($easternCoordinates->isWestern())->toBeFalse();
    expect($westernCoordinates->isWestern())->toBeTrue();
});

it('determines if coordinates are at equator', function () {
    $equatorCoordinates = new Coordinates(new Latitude(0.0), new Longitude(-74.0060));
    $nonEquatorCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($equatorCoordinates->isEquator())->toBeTrue();
    expect($nonEquatorCoordinates->isEquator())->toBeFalse();
});

it('determines if coordinates are at prime meridian', function () {
    $primeMeridianCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(0.0));
    $nonPrimeMeridianCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($primeMeridianCoordinates->isPrimeMeridian())->toBeTrue();
    expect($nonPrimeMeridianCoordinates->isPrimeMeridian())->toBeFalse();
});

it('determines if coordinates are at international date line', function () {
    $dateLineCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(180.0));
    $nonDateLineCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($dateLineCoordinates->isInternationalDateLine())->toBeTrue();
    expect($nonDateLineCoordinates->isInternationalDateLine())->toBeFalse();
});

it('determines if coordinates are at Greenwich meridian', function () {
    $greenwichCoordinates = new Coordinates(new Latitude(51.4769), new Longitude(0.0));
    $nonGreenwichCoordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($greenwichCoordinates->isGreenwichMeridian())->toBeTrue();
    expect($nonGreenwichCoordinates->isGreenwichMeridian())->toBeFalse();
});

it('calculates distance to another coordinates', function () {
    $coordinates1 = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060)); // New York
    $coordinates2 = new Coordinates(new Latitude(51.5074), new Longitude(-0.1278)); // London

    $distance = $coordinates1->distanceTo($coordinates2);

    expect($distance)->toBeGreaterThan(5500); // Approximately 5570 km
    expect($distance)->toBeLessThan(5600);
});

it('calculates distance to same coordinates as zero', function () {
    $coordinates = new Coordinates(new Latitude(40.7128), new Longitude(-74.0060));

    expect($coordinates->distanceTo($coordinates))->toBe(0.0);
});
