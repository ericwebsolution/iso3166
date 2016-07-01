<?php

/*
 * (c) Rob Bast <rob.bast@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace League\ISO3166;

class ISO3166Test extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    public $foo = [
        ISO3166::KEY_ALPHA2 => 'FO',
        ISO3166::KEY_ALPHA3 => 'FOO',
        ISO3166::KEY_NUMERIC => '001',
    ];

    /** @var array */
    public $bar = [
        ISO3166::KEY_ALPHA2 => 'BA',
        ISO3166::KEY_ALPHA3 => 'BAR',
        ISO3166::KEY_NUMERIC => '002',
    ];

    /** @var ISO3166 */
    public $iso3166;

    public function setUp()
    {
        $this->iso3166 = new ISO3166([$this->foo, $this->bar]);
    }

    /**
     * @testdox Calling getByAlpha2 with bad input throws various exceptions.
     * @dataProvider invalidAlpha2Provider
     *
     * @param string $alpha2
     */
    public function testGetByAlpha2Invalid($alpha2, $expectedException, $exceptionPattern)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessageRegExp($exceptionPattern);

        $this->iso3166->getByAlpha2($alpha2);
    }

    /**
     * @return array
     */
    public function invalidAlpha2Provider()
    {
        return [
            ['Z', \DomainException::class, '/^Not a valid alpha2: .*$/'],
            ['ZZZ', \DomainException::class, '/^Not a valid alpha2: .*$/'],
            [1, \DomainException::class, '/^Expected \$alpha2 to be of type string, got: .*$/'],
            [123, \DomainException::class, '/^Expected \$alpha2 to be of type string, got: .*$/'],
            ['ZZ', \OutOfBoundsException::class, '/^ISO 3166-1 does not contain: .*$/'],
        ];
    }

    /**
     * @testdox Calling getByAlpha2 with a known alpha2 returns matching data array.
     */
    public function testGetByAlpha2()
    {
        $this->assertEquals($this->foo, $this->iso3166->getByAlpha2($this->foo[ISO3166::KEY_ALPHA2]));
        $this->assertEquals($this->bar, $this->iso3166->getByAlpha2($this->bar[ISO3166::KEY_ALPHA2]));
    }

    /**
     * @testdox Calling getByAlpha3 with bad input throws various exceptions.
     * @dataProvider invalidAlpha3Provider
     *
     * @param string $alpha3
     */
     public function testGetByAlpha3Invalid($alpha3, $expectedException, $exceptionPattern)
     {
         $this->expectException($expectedException);
         $this->expectExceptionMessageRegExp($exceptionPattern);

         $this->iso3166->getByAlpha3($alpha3);
     }

    /**
     * @return array
     */
    public function invalidAlpha3Provider()
    {
        return [
            ['ZZ', \DomainException::class, '/^Not a valid alpha3: .*$/'],
            ['ZZZZ', \DomainException::class, '/^Not a valid alpha3: .*$/'],
            [12, \DomainException::class, '/^Expected \$alpha3 to be of type string, got: .*$/'],
            [1234, \DomainException::class, '/^Expected \$alpha3 to be of type string, got: .*$/'],
            ['ZZZ', \OutOfBoundsException::class, '/^ISO 3166-1 does not contain: .*$/'],
        ];
    }

    /**
     * @testdox Calling getByAlpha3 with a known alpha3 returns matching data array.
     */
    public function testGetByAlpha3()
    {
        $this->assertEquals($this->foo, $this->iso3166->getByAlpha3($this->foo[ISO3166::KEY_ALPHA3]));
        $this->assertEquals($this->bar, $this->iso3166->getByAlpha3($this->bar[ISO3166::KEY_ALPHA3]));
    }

    /**
     * @testdox Calling getByNumeric with bad input throws various exceptions.
     * @dataProvider invalidNumericProvider
     *
     * @param string $numeric
     */
    public function testGetByNumericInvalid($numeric, $expectedException, $exceptionPattern)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessageRegExp($exceptionPattern);

        $this->iso3166->getByNumeric($numeric);
    }

    /**
     * @return array
     */
    public function invalidNumericProvider()
    {
        return [
            ['00', \DomainException::class, '/^Not a valid numeric: .*$/'],
            ['0000', \DomainException::class, '/^Not a valid numeric: .*$/'],
            ['ZZ', \DomainException::class, '/^Not a valid numeric: .*$/'],
            ['ZZZ', \DomainException::class, '/^Not a valid numeric: .*$/'],
            ['ZZZZ', \DomainException::class, '/^Not a valid numeric: .*$/'],
            [1, \DomainException::class, '/^Expected \$numeric to be of type string, got: .*$/'],
            [12, \DomainException::class, '/^Expected \$numeric to be of type string, got: .*$/'],
            [123, \DomainException::class, '/^Expected \$numeric to be of type string, got: .*$/'],
            ['000', \OutOfBoundsException::class, '/^ISO 3166-1 does not contain: .*$/'],
        ];
    }

    /**
     * @testdox Calling getByNumeric with a known numeric returns matching data array.
     */
    public function testGetByNumeric()
    {
        $this->assertEquals($this->foo, $this->iso3166->getByNumeric($this->foo[ISO3166::KEY_NUMERIC]));
        $this->assertEquals($this->bar, $this->iso3166->getByNumeric($this->bar[ISO3166::KEY_NUMERIC]));
    }

    /**
     * @testdox Calling getAll returns an array with all elements.
     */
    public function testGetAll()
    {
        $this->assertInternalType('array', $this->iso3166->getAll(), 'getAll() should return an array.');
    }

    /**
     * @testdox Iterating over $instance should behave as expected.
     */
    public function testIterator()
    {
        $i = 0;
        foreach ($this->iso3166 as $key => $value) {
            ++$i;
        }

        $this->assertEquals(count($this->iso3166->getAll()), $i, 'Compare iterated count to count(getAll()).');
    }

    /**
     * @testdox Iterating over $instance->listBy() should behave as expected.
     */
    public function testListBy()
    {
        try {
            foreach ($this->iso3166->listBy('foo') as $key => $value) {
                // void
            }
        } catch (\Exception $e) {
            $this->assertInstanceOf('DomainException', $e);
            $this->assertRegExp('{Invalid value for \$indexBy, got "\w++", expected one of:(?: \w++,?)+}', $e->getMessage());
        } finally {
            $this->assertTrue(isset($e));
        }

        $i = 0;
        foreach ($this->iso3166->listBy(ISO3166::KEY_ALPHA3) as $key => $value) {
            ++$i;
        }

        $this->assertEquals(count($this->iso3166), $i, 'Compare iterated count to count($iso3166).');
    }
}
