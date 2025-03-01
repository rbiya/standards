<?php
declare(strict_types=1);

namespace PrinsFrank\Standards;

/** @internal This class or its methods may change between minor versions */
class UnitEnum
{
    /**
     * @template T of \UnitEnum
     * @param class-string<T> $fqn
     * @return T
     * @throws KeyNotFoundException
     * @throws InvalidArgumentException
     */
    public static function fromKey(string $fqn, string $keyName): \UnitEnum
    {
        return self::tryFromKey($fqn, $keyName) ?? throw new KeyNotFoundException('Key "' . $keyName . '" not found in "' . $fqn . '"');
    }

    /**
     * @template T of \UnitEnum
     * @param class-string<T> $fqn
     * @return T|null
     * @throws InvalidArgumentException
     */
    public static function tryFromKey(string $fqn, string $keyName): ?\UnitEnum
    {
        if (is_a($fqn, \UnitEnum::class, true) === false) {
            throw new InvalidArgumentException('It is only possible to get names of unitEnums, "' . $fqn . '" provided');
        }

        if (!defined("$fqn::$keyName")) {
            return null;
        }

        /** @var T $itemValue */
        $itemValue = constant("$fqn::$keyName");

        return $itemValue;
    }

    /**
     * @template T of \UnitEnum
     * @param class-string<T> $fqn
     * @return array<int, string>
     * @throws InvalidArgumentException
     */
    public static function names(string $fqn): array
    {
        if (is_a($fqn, \UnitEnum::class, true) === false) {
            throw new InvalidArgumentException('It is only possible to get names of unitEnums, "' . $fqn . '" provided');
        }

        return array_column($fqn::cases(), 'name');
    }
}
