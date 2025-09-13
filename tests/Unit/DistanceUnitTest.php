<?php

declare(strict_types=1);

use Jeroengerits\Coord\Enums\DistanceUnit;

it('has all expected enum cases', function (): void {
    $cases = DistanceUnit::cases();

    expect($cases)->toHaveCount(11);
    expect($cases)->toContain(DistanceUnit::KILOMETERS);
    expect($cases)->toContain(DistanceUnit::MILES);
    expect($cases)->toContain(DistanceUnit::NAUTICAL_MILES);
    expect($cases)->toContain(DistanceUnit::METERS);
    expect($cases)->toContain(DistanceUnit::MILLIMETERS);
    expect($cases)->toContain(DistanceUnit::CENTIMETERS);
    expect($cases)->toContain(DistanceUnit::DECIMETERS);
    expect($cases)->toContain(DistanceUnit::INCHES);
    expect($cases)->toContain(DistanceUnit::FEET);
    expect($cases)->toContain(DistanceUnit::YARDS);
    expect($cases)->toContain(DistanceUnit::LIGHT_YEARS);
});

it('has correct string values for all cases', function (): void {
    expect(DistanceUnit::KILOMETERS->value)->toBe('km');
    expect(DistanceUnit::MILES->value)->toBe('mi');
    expect(DistanceUnit::NAUTICAL_MILES->value)->toBe('nmi');
    expect(DistanceUnit::METERS->value)->toBe('m');
    expect(DistanceUnit::MILLIMETERS->value)->toBe('mm');
    expect(DistanceUnit::CENTIMETERS->value)->toBe('cm');
    expect(DistanceUnit::DECIMETERS->value)->toBe('dm');
    expect(DistanceUnit::INCHES->value)->toBe('in');
    expect(DistanceUnit::FEET->value)->toBe('ft');
    expect(DistanceUnit::YARDS->value)->toBe('yd');
    expect(DistanceUnit::LIGHT_YEARS->value)->toBe('ly');
});

it('returns correct conversion factors for all units', function (): void {
    expect(DistanceUnit::KILOMETERS->getConversionFactor())->toBe(1.0);
    expect(DistanceUnit::MILES->getConversionFactor())->toBe(0.621371);
    expect(DistanceUnit::NAUTICAL_MILES->getConversionFactor())->toBe(0.539957);
    expect(DistanceUnit::METERS->getConversionFactor())->toBe(1000.0);
    expect(DistanceUnit::MILLIMETERS->getConversionFactor())->toBe(1000000.0);
    expect(DistanceUnit::CENTIMETERS->getConversionFactor())->toBe(100000.0);
    expect(DistanceUnit::DECIMETERS->getConversionFactor())->toBe(10000.0);
    expect(DistanceUnit::INCHES->getConversionFactor())->toBe(39370.1);
    expect(DistanceUnit::FEET->getConversionFactor())->toBe(3280.84);
    expect(DistanceUnit::YARDS->getConversionFactor())->toBe(1093.61);
    expect(DistanceUnit::LIGHT_YEARS->getConversionFactor())->toBe(1.057e-13);
});

it('returns correct display names for all units', function (): void {
    expect(DistanceUnit::KILOMETERS->getDisplayName())->toBe('kilometers');
    expect(DistanceUnit::MILES->getDisplayName())->toBe('miles');
    expect(DistanceUnit::NAUTICAL_MILES->getDisplayName())->toBe('nautical miles');
    expect(DistanceUnit::METERS->getDisplayName())->toBe('meters');
    expect(DistanceUnit::MILLIMETERS->getDisplayName())->toBe('millimeters');
    expect(DistanceUnit::CENTIMETERS->getDisplayName())->toBe('centimeters');
    expect(DistanceUnit::DECIMETERS->getDisplayName())->toBe('decimeters');
    expect(DistanceUnit::INCHES->getDisplayName())->toBe('inches');
    expect(DistanceUnit::FEET->getDisplayName())->toBe('feet');
    expect(DistanceUnit::YARDS->getDisplayName())->toBe('yards');
    expect(DistanceUnit::LIGHT_YEARS->getDisplayName())->toBe('light years');
});

it('returns correct abbreviations for all units', function (): void {
    expect(DistanceUnit::KILOMETERS->getAbbreviation())->toBe('km');
    expect(DistanceUnit::MILES->getAbbreviation())->toBe('mi');
    expect(DistanceUnit::NAUTICAL_MILES->getAbbreviation())->toBe('nmi');
    expect(DistanceUnit::METERS->getAbbreviation())->toBe('m');
    expect(DistanceUnit::MILLIMETERS->getAbbreviation())->toBe('mm');
    expect(DistanceUnit::CENTIMETERS->getAbbreviation())->toBe('cm');
    expect(DistanceUnit::DECIMETERS->getAbbreviation())->toBe('dm');
    expect(DistanceUnit::INCHES->getAbbreviation())->toBe('in');
    expect(DistanceUnit::FEET->getAbbreviation())->toBe('ft');
    expect(DistanceUnit::YARDS->getAbbreviation())->toBe('yd');
    expect(DistanceUnit::LIGHT_YEARS->getAbbreviation())->toBe('ly');
});

it('abbreviation method returns the same as value property', function (): void {
    foreach (DistanceUnit::cases() as $unit) {
        expect($unit->getAbbreviation())->toBe($unit->value);
    }
});

it('validates conversion factor accuracy', function (): void {
    // Test that conversion factors are reasonable
    $kilometers = DistanceUnit::KILOMETERS->getConversionFactor();
    $miles = DistanceUnit::MILES->getConversionFactor();
    $nauticalMiles = DistanceUnit::NAUTICAL_MILES->getConversionFactor();
    $meters = DistanceUnit::METERS->getConversionFactor();
    $millimeters = DistanceUnit::MILLIMETERS->getConversionFactor();
    $centimeters = DistanceUnit::CENTIMETERS->getConversionFactor();
    $decimeters = DistanceUnit::DECIMETERS->getConversionFactor();
    $inches = DistanceUnit::INCHES->getConversionFactor();
    $feet = DistanceUnit::FEET->getConversionFactor();
    $yards = DistanceUnit::YARDS->getConversionFactor();
    $lightYears = DistanceUnit::LIGHT_YEARS->getConversionFactor();

    // Kilometers should be the base unit (1.0)
    expect($kilometers)->toBe(1.0);

    // Miles should be less than 1 (since 1 km = ~0.62 miles)
    expect($miles)->toBeGreaterThan(0.6)->toBeLessThan(0.7);

    // Nautical miles should be less than 1 (since 1 km = ~0.54 nautical miles)
    expect($nauticalMiles)->toBeGreaterThan(0.5)->toBeLessThan(0.6);

    // Meters should be greater than 1 (since 1 km = 1000 meters)
    expect($meters)->toBe(1000.0);

    // Millimeters should be much greater than 1 (since 1 km = 1,000,000 mm)
    expect($millimeters)->toBe(1000000.0);

    // Centimeters should be greater than meters (since 1 km = 100,000 cm)
    expect($centimeters)->toBe(100000.0);

    // Decimeters should be greater than meters (since 1 km = 10,000 dm)
    expect($decimeters)->toBe(10000.0);

    // Imperial units should be reasonable
    expect($inches)->toBeGreaterThan(39000)->toBeLessThan(40000);
    expect($feet)->toBeGreaterThan(3200)->toBeLessThan(3300);
    expect($yards)->toBeGreaterThan(1090)->toBeLessThan(1100);

    // Light years should be very small (since 1 km is a tiny fraction of a light year)
    expect($lightYears)->toBeLessThan(1e-10);
});

it('handles enum comparison correctly', function (): void {
    $km1 = DistanceUnit::KILOMETERS;
    $km2 = DistanceUnit::KILOMETERS;
    $miles = DistanceUnit::MILES;

    expect($km1)->toBe($km2);
    expect($km1)->not->toBe($miles);
    expect($km1 === $km2)->toBeTrue();
    expect($km1 === $miles)->toBeFalse();
});

it('can be used in match expressions', function (): void {
    $testConversion = function (DistanceUnit $unit): string {
        return match ($unit) {
            DistanceUnit::KILOMETERS => 'base unit',
            DistanceUnit::MILES => 'imperial unit',
            DistanceUnit::NAUTICAL_MILES => 'maritime unit',
            DistanceUnit::METERS => 'metric unit',
            DistanceUnit::MILLIMETERS => 'small metric unit',
            DistanceUnit::CENTIMETERS => 'small metric unit',
            DistanceUnit::DECIMETERS => 'small metric unit',
            DistanceUnit::INCHES => 'imperial unit',
            DistanceUnit::FEET => 'imperial unit',
            DistanceUnit::YARDS => 'imperial unit',
            DistanceUnit::LIGHT_YEARS => 'astronomical unit',
        };
    };

    expect($testConversion(DistanceUnit::KILOMETERS))->toBe('base unit');
    expect($testConversion(DistanceUnit::MILES))->toBe('imperial unit');
    expect($testConversion(DistanceUnit::NAUTICAL_MILES))->toBe('maritime unit');
    expect($testConversion(DistanceUnit::METERS))->toBe('metric unit');
    expect($testConversion(DistanceUnit::MILLIMETERS))->toBe('small metric unit');
    expect($testConversion(DistanceUnit::CENTIMETERS))->toBe('small metric unit');
    expect($testConversion(DistanceUnit::DECIMETERS))->toBe('small metric unit');
    expect($testConversion(DistanceUnit::INCHES))->toBe('imperial unit');
    expect($testConversion(DistanceUnit::FEET))->toBe('imperial unit');
    expect($testConversion(DistanceUnit::YARDS))->toBe('imperial unit');
    expect($testConversion(DistanceUnit::LIGHT_YEARS))->toBe('astronomical unit');
});

it('can be serialized and deserialized', function (): void {
    foreach (DistanceUnit::cases() as $unit) {
        $serialized = serialize($unit);
        $unserialized = unserialize($serialized);

        expect($unserialized)->toBe($unit);
        expect($unserialized->value)->toBe($unit->value);
    }
});

it('maintains consistency across all methods', function (): void {
    foreach (DistanceUnit::cases() as $unit) {
        // The abbreviation should always match the value
        expect($unit->getAbbreviation())->toBe($unit->value);

        // All methods should return non-empty strings
        expect($unit->getDisplayName())->not->toBeEmpty();
        expect($unit->getAbbreviation())->not->toBeEmpty();

        // Conversion factor should be a positive number
        expect($unit->getConversionFactor())->toBeGreaterThan(0);
    }
});

it('provides meaningful string representation', function (): void {
    foreach (DistanceUnit::cases() as $unit) {
        // Enums don't have __toString() by default, but we can test the value property
        // which is what would be used for string representation
        expect($unit->value)->toBeString();
        expect($unit->value)->not->toBeEmpty();
    }

    // Test specific values for each case
    expect(DistanceUnit::KILOMETERS->value)->toBe('km');
    expect(DistanceUnit::MILES->value)->toBe('mi');
    expect(DistanceUnit::NAUTICAL_MILES->value)->toBe('nmi');
    expect(DistanceUnit::METERS->value)->toBe('m');
    expect(DistanceUnit::MILLIMETERS->value)->toBe('mm');
    expect(DistanceUnit::CENTIMETERS->value)->toBe('cm');
    expect(DistanceUnit::DECIMETERS->value)->toBe('dm');
    expect(DistanceUnit::INCHES->value)->toBe('in');
    expect(DistanceUnit::FEET->value)->toBe('ft');
    expect(DistanceUnit::YARDS->value)->toBe('yd');
    expect(DistanceUnit::LIGHT_YEARS->value)->toBe('ly');
});
