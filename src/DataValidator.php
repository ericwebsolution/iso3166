<?php

namespace League\ISO3166;

class DataValidator
{
    use KeyValidators;

    /**
     * @param array $data
     *
     * @return array
     */
    public function validate(array $data)
    {
        foreach ($data as $entry) {
            $this->assertEntryHasRequiredKeys($entry);
        }

        return $data;
    }

    /**
     * @param array $entry
     *
     * @throws \DomainException if given data entry does not have all the required keys.
     */
    private function assertEntryHasRequiredKeys(array $entry)
    {
        if (!isset($entry[ISO3166::KEY_ALPHA2])) {
            throw new \DomainException('Each data entry must have a valid alpha2 key.');
        }

        $this->validateAlpha2($entry[ISO3166::KEY_ALPHA2]);

        if (!isset($entry[ISO3166::KEY_ALPHA3])) {
            throw new \DomainException('Each data entry must have a valid alpha3 key.');
        }

        $this->validateAlpha3($entry[ISO3166::KEY_ALPHA3]);

        if (!isset($entry[ISO3166::KEY_NUMERIC])) {
            throw new \DomainException('Each data entry must have a valid numeric key.');
        }

        $this->validateNumeric(ISO3166::KEY_NUMERIC);
    }
}
