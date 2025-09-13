<?php

declare(strict_types=1);

namespace Jeroengerits\Coord\ValueObjects;

use InvalidArgumentException;

final readonly class Coordinates implements \Stringable
{
    public function __construct(
        private Latitude $latitude,
        private Longitude $longitude
    ) {}

    public function latitude(): Latitude
    {
        return $this->latitude;
    }

    public function longitude(): Longitude
    {
        return $this->longitude;
    }

    public static function fromFloats(float $latitude, float $longitude): self
    {
        return new self(
            new Latitude($latitude),
            new Longitude($longitude)
        );
    }

    public static function fromArray(array $data): self
    {
        if (! array_key_exists('latitude', $data) || ! array_key_exists('longitude', $data)) {
            throw new InvalidArgumentException(
                'Array must contain both latitude and longitude keys'
            );
        }

        return new self(
            new Latitude($data['latitude']),
            new Longitude($data['longitude'])
        );
    }

    public static function fromString(string $coordinates): self
    {
        $parts = explode(',', $coordinates);

        if (count($parts) !== 2) {
            throw new InvalidArgumentException(
                'Invalid coordinates format. Expected "latitude,longitude"'
            );
        }

        $latitude = trim($parts[0]);
        $longitude = trim($parts[1]);

        return new self(
            new Latitude((float) $latitude),
            new Longitude((float) $longitude)
        );
    }

    public function equals(Coordinates $coordinates): bool
    {
        return $this->latitude->equals($coordinates->latitude) &&
               $this->longitude->equals($coordinates->longitude);
    }

    public function __toString(): string
    {
        return $this->latitude->value().','.$this->longitude->value();
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude->value(),
            'longitude' => $this->longitude->value(),
        ];
    }

    public function isNorthern(): bool
    {
        return $this->latitude->isNorthern();
    }

    public function isSouthern(): bool
    {
        return $this->latitude->isSouthern();
    }

    public function isEastern(): bool
    {
        return $this->longitude->isEastern();
    }

    public function isWestern(): bool
    {
        return $this->longitude->isWestern();
    }

    public function isEquator(): bool
    {
        return $this->latitude->isEquator();
    }

    public function isPrimeMeridian(): bool
    {
        return $this->longitude->isPrimeMeridian();
    }

    public function isInternationalDateLine(): bool
    {
        return $this->longitude->isInternationalDateLine();
    }

    public function isGreenwichMeridian(): bool
    {
        return $this->longitude->isPrimeMeridian();
    }

    public function distanceTo(Coordinates $coordinates): float
    {
        if ($this->equals($coordinates)) {
            return 0.0;
        }

        $lat1 = deg2rad($this->latitude->value());
        $lon1 = deg2rad($this->longitude->value());
        $lat2 = deg2rad($coordinates->latitude->value());
        $lon2 = deg2rad($coordinates->longitude->value());

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        // Earth's radius in kilometers
        $earthRadius = 6371.0;

        return $earthRadius * $c;
    }
}
