<?php

declare(strict_types=1);

namespace Jeroengerits\Coord\ValueObjects;

use InvalidArgumentException;

final readonly class Longitude implements \Stringable
{
    private const float MIN_LONGITUDE = -180.0;

    private const float MAX_LONGITUDE = 180.0;

    public function __construct(
        private float $value
    ) {
        if ($value < self::MIN_LONGITUDE || $value > self::MAX_LONGITUDE) {
            throw new InvalidArgumentException(
                'Longitude must be between -180 and 180 degrees'
            );
        }
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equals(Longitude $longitude): bool
    {
        return $this->value === $longitude->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function toArray(): array
    {
        return ['longitude' => $this->value];
    }

    public static function fromString(string $value): self
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException(
                'Invalid longitude value: '.$value
            );
        }

        return new self((float) $value);
    }

    public function isEastern(): bool
    {
        return $this->value > 0.0;
    }

    public function isWestern(): bool
    {
        return $this->value < 0.0;
    }

    public function isPrimeMeridian(): bool
    {
        return $this->value === 0.0;
    }

    public function isInternationalDateLine(): bool
    {
        return $this->value === 180.0 || $this->value === -180.0;
    }
}
