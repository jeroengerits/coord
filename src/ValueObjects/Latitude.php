<?php

declare(strict_types=1);

namespace Jeroengerits\Coord\ValueObjects;

use InvalidArgumentException;

final readonly class Latitude implements \Stringable
{
    private const float MIN_LATITUDE = -90.0;

    private const float MAX_LATITUDE = 90.0;

    public function __construct(
        private float $value
    ) {
        if ($value < self::MIN_LATITUDE || $value > self::MAX_LATITUDE) {
            throw new InvalidArgumentException(
                'Latitude must be between -90 and 90 degrees'
            );
        }
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equals(Latitude $latitude): bool
    {
        return $this->value === $latitude->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function toArray(): array
    {
        return ['latitude' => $this->value];
    }

    public static function fromString(string $value): self
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException(
                'Invalid latitude value: '.$value
            );
        }

        return new self((float) $value);
    }

    public function isNorthern(): bool
    {
        return $this->value > 0.0;
    }

    public function isSouthern(): bool
    {
        return $this->value < 0.0;
    }

    public function isEquator(): bool
    {
        return $this->value === 0.0;
    }
}
