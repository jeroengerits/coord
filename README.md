# Coord

A PHP library for working with geographic coordinates, providing immutable value objects for Latitude, Longitude, and
Coordinates with distance calculations.

## Features

- 🌍 **Immutable Value Objects**: Type-safe Latitude, Longitude, and Coordinates
- 📏 **Distance Calculations**: Haversine formula for accurate distance calculations
- 🧭 **Geographic Analysis**: Hemisphere detection, special line identification
- 🎯 **Multiple Creation Methods**: From floats, arrays, strings, or other value objects
- ✅ **Fully Tested**: 100% test coverage with Pest PHP
- 🚀 **Modern PHP**: Requires PHP 8.4+ with strict typing
- 📦 **Zero Dependencies**: No external dependencies required

## Quick Start

```php
use JeroenGerits\Coord\ValueObjects\Coordinates;

// Create coordinates
$coordinates = Coordinates::fromFloats(40.7128, -74.0060);
$coordinates = Coordinates::fromString('40.7128,-74.0060');
$coordinates = Coordinates::fromArray(['latitude' => 40.7128, 'longitude' => -74.0060]);
```

## Value Objects

### Latitude (-90° to +90°)

```php
use JeroenGerits\Coord\ValueObjects\Latitude;

// Create from constructor
$latitude = new Latitude(40.7128);

// Create from float
$latitude = Latitude::fromFloat(40.7128);

// Create from string
$latitude = Latitude::fromString('40.7128');

$latitude->value(); // 40.7128
$latitude->isNorthern(); // true
$latitude->isEquator(); // false
(string) $latitude; // "40.7128"
$latitude->toArray(); // ['latitude' => 40.7128]
```

### Longitude (-180° to +180°)

```php
use JeroenGerits\Coord\ValueObjects\Longitude;

// Create from constructor
$longitude = new Longitude(-74.0060);

// Create from float
$longitude = Longitude::fromFloat(-74.0060);

// Create from string
$longitude = Longitude::fromString('-74.0060');

$longitude->value(); // -74.0060
$longitude->isWestern(); // true
$longitude->isPrimeMeridian(); // false
(string) $longitude; // "-74.0060"
$longitude->toArray(); // ['longitude' => -74.0060]
```

### Coordinates

```php
use JeroenGerits\Coord\ValueObjects\Coordinates;

$coordinates = new Coordinates($latitude, $longitude);

// Geographic analysis
$coordinates->isNorthern(); // true
$coordinates->isWestern(); // true
$coordinates->isEquator(); // false

// Distance calculation
$newYork = Coordinates::fromFloats(40.7128, -74.0060);
$london = Coordinates::fromFloats(51.5074, -0.1278);
$distance = $newYork->distanceTo($london); // ~5570.0 km

// Conversion
(string) $coordinates; // "40.7128,-74.0060"
$coordinates->toArray(); // ['latitude' => 40.7128, 'longitude' => -74.0060]
```

## Distance Calculations

```php
$newYork = Coordinates::fromFloats(40.7128, -74.0060);
$london = Coordinates::fromFloats(51.5074, -0.1278);
$distance = $newYork->distanceTo($london); // ~5570.0 km
```

## Distance Units

The library supports 11 different distance units for calculations:

### Metric Units

- **Kilometers (km)** - Base unit
- **Meters (m)** - 1,000 meters = 1 kilometer
- **Decimeters (dm)** - 10,000 decimeters = 1 kilometer
- **Centimeters (cm)** - 100,000 centimeters = 1 kilometer
- **Millimeters (mm)** - 1,000,000 millimeters = 1 kilometer

### Imperial Units

- **Miles (mi)** - ~0.621 miles = 1 kilometer
- **Yards (yd)** - ~1,094 yards = 1 kilometer
- **Feet (ft)** - ~3,281 feet = 1 kilometer
- **Inches (in)** - ~39,370 inches = 1 kilometer

### Specialized Units

- **Nautical Miles (nmi)** - ~0.540 nautical miles = 1 kilometer
- **Light Years (ly)** - ~1.057e-13 light years = 1 kilometer

### Usage Examples

```php
use JeroenGerits\Coord\Enums\DistanceUnit;

$newYork = Coordinates::fromFloats(40.7128, -74.0060);
$london = Coordinates::fromFloats(51.5074, -0.1278);

// Different distance units
$distanceKm = $newYork->distanceTo($london, DistanceUnit::KILOMETERS);
$distanceMiles = $newYork->distanceTo($london, DistanceUnit::MILES);
$distanceMeters = $newYork->distanceTo($london, DistanceUnit::METERS);
$distanceFeet = $newYork->distanceTo($london, DistanceUnit::FEET);
$distanceInches = $newYork->distanceTo($london, DistanceUnit::INCHES);
$distanceLightYears = $newYork->distanceTo($london, DistanceUnit::LIGHT_YEARS);

// Unit information
$unit = DistanceUnit::MILES;
$unit->getDisplayName(); // "miles"
$unit->getAbbreviation(); // "mi"
$unit->getConversionFactor(); // 0.621371
```

## Geographic Analysis

```php
$coordinates = Coordinates::fromFloats(40.7128, -74.0060);

// Hemisphere detection
$coordinates->isNorthern(); // true
$coordinates->isWestern(); // true

// Special lines
$equator = Coordinates::fromFloats(0.0, -74.0060);
$equator->isEquator(); // true

$primeMeridian = Coordinates::fromFloats(40.7128, 0.0);
$primeMeridian->isPrimeMeridian(); // true
```

## Error Handling

```php
try {
    $latitude = new Latitude(91.0); // Invalid: > 90°
} catch (InvalidArgumentException $e) {
    echo $e->getMessage(); // "Latitude must be between -90 and 90 degrees"
}
```

## Equality

```php
$coordinates1 = Coordinates::fromFloats(40.7128, -74.0060);
$coordinates2 = Coordinates::fromFloats(40.7128, -74.0060);
$coordinates1->equals($coordinates2); // true
```

## Testing

```bash
composer test
composer test:coverage
```

## Development

```bash
composer all  # Run all quality checks
```

## Requirements

- PHP 8.4 or higher

## License

MIT License. See [LICENSE](LICENSE) for details.

## Support

For security issues, email jeroen@gerits.email instead of using the issue tracker.