<?php

namespace League\ISO3166;

trait KeyValidators
{
    /**
     * Assert that input looks like an alpha2 key.
     *
     * @param string $alpha2
     *
     * @throws \DomainException if input is not a string.
     * @throws \DomainException if input does not look like an alpha2 key.
     *
     * @return string
     */
    public function validateAlpha2($alpha2)
    {
        if (!is_string($alpha2)) {
            throw new \DomainException(sprintf('Expected $alpha2 to be of type string, got: %s', gettype($alpha2)));
        }

        if (!preg_match('/^[a-zA-Z]{2}$/', $alpha2)) {
            throw new \DomainException(sprintf('Not a valid alpha2: %s', $alpha2));
        }

        return strtoupper($alpha2);
    }

    /**
     * Assert that input looks like an alpha3 key.
     *
     * @param string $alpha3
     *
     * @throws \DomainException if input is not a string.
     * @throws \DomainException if input does not look like an alpha3 key.
     *
     * @return string
     */
    public function validateAlpha3($alpha3)
    {
        if (!is_string($alpha3)) {
            throw new \DomainException(sprintf('Expected $alpha3 to be of type string, got: %s', gettype($alpha3)));
        }

        if (!preg_match('/^[a-zA-Z]{3}$/', $alpha3)) {
            throw new \DomainException(sprintf('Not a valid alpha3: %s', $alpha3));
        }

        return strtoupper($alpha3);
    }

    /**
     * Assert that input looks like a numeric key.
     *
     * @param string $numeric
     *
     * @throws \DomainException if input is not a string.
     * @throws \DomainException if input does not look like a numeric key.
     *
     * @return string
     */
    public function validateNumeric($numeric)
    {
        if (!is_string($numeric)) {
            throw new \DomainException(sprintf('Expected $numeric to be of type string, got: %s', gettype($numeric)));
        }

        if (!preg_match('/^[0-9]{3}$/', $numeric)) {
            throw new \DomainException(sprintf('Not a valid numeric: %s', $numeric));
        }

        return $numeric;
    }
}
