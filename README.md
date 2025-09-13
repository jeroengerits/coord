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
use Jeroengerits\Coord\ValueObjects\Coordinates;

// Create coordinates
$coordinates = Coordinates::fromFloats(40.7128, -74.0060);
$coordinates = Coordinates::fromString('40.7128,-74.0060');
$coordinates = Coordinates::fromArray(['latitude' => 40.7128, 'longitude' => -74.0060]);
```

## Value Objects

### Latitude (-90° to +90°)

```php
use Jeroengerits\Coord\ValueObjects\Latitude;

$latitude = new Latitude(40.7128);
$latitude->value(); // 40.7128
$latitude->isNorthern(); // true
$latitude->isEquator(); // false
(string) $latitude; // "40.7128"
$latitude->toArray(); // ['latitude' => 40.7128]
```

### Longitude (-180° to +180°)

```php
use Jeroengerits\Coord\ValueObjects\Longitude;

$longitude = new Longitude(-74.0060);
$longitude->value(); // -74.0060
$longitude->isWestern(); // true
$longitude->isPrimeMeridian(); // false
(string) $longitude; // "-74.0060"
$longitude->toArray(); // ['longitude' => -74.0060]
```

### Coordinates

```php
use Jeroengerits\Coord\ValueObjects\Coordinates;

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