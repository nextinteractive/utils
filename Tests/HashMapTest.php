<?php
/*
 * Copyright (c) 2011-2014 Lp digital system
 *
 * This file is part of BackBee.
 *
 * BackBee is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BackBee is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BackBee. If not, see <http://www.gnu.org/licenses/>.
 */
namespace BackBee\Utils\Tests;

use BackBee\Utils\Collection\HashMap;
use Symfony\Component\Yaml\Yaml;

/**
 * @author      Mickaël Andrieu <mickael.andrieu@lp-digital.fr>
 */
class HashMapTest extends UtilsTestCase
{
    /**
     * @var array $parameters
     */
    private $parameters;

    /**
     * @var HashMap $hashmap the HashMap class to be tested
     */
    private $hashmap;

    /**
     * Sets up the fixture
     */
    public function setUp()
    {
        $this->parameters = Yaml::parse(file_get_contents($this->getFixturesFolder().'config.yml'));
        $this->hashmap = new HashMap($this->parameters);
    }

    public function testAll()
    {
        $this->assertSame($this->parameters, $this->hashmap->all());
    }

    public function testKeys()
    {
        $this->assertSame(array_keys($this->parameters), $this->hashmap->keys());
    }

    public function testReplace()
    {
        $newParameters = Yaml::parse(file_get_contents($this->getFixturesFolder().'config2.yml'));
        $this->hashmap->replace($newParameters);

        $this->assertNotSame($this->parameters, $this->hashmap->all());
        $this->assertSame($newParameters, $this->hashmap->all());
    }

    public function testAdd()
    {
        $this->markTestSkipped('Hashmap::add() have a weird behavior.');

        $count = count($this->parameters);
        $newParameter = ['debug' => false];
        $this->hashmap->add($newParameter);

        $this->assertEquals($count + 1, count($this->parameters));
        $this->assertFalse($this->parameters->get('debug'));
    }

    public function testGet()
    {
        $this->assertSame($this->parameters['firewalls'], $this->hashmap->get('firewalls'));
        $this->assertSame('backbee', $this->hashmap->get('unknown', 'backbee'));
    }

    public function testSet()
    {
        $this->hashmap->set('debug', false);
        $this->assertFalse($this->hashmap->get('debug'));
    }

    public function testHas()
    {
        $this->assertTrue($this->hashmap->has('firewalls'));
        $this->assertFalse($this->hashmap->has('backbee'));
    }

    public function testRemove()
    {
        $this->hashmap->remove('firewalls');
        $this->assertNull($this->hashmap->get('firewalls'));
        $this->assertFalse($this->hashmap->has('firewalls'));
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('\ArrayIterator', $this->hashmap->getIterator());
    }

    public function testCount()
    {
        $newParameters = Yaml::parse(file_get_contents($this->getFixturesFolder().'config2.yml'));
        $this->hashmap->replace($newParameters);
        $count = count($newParameters);

        $this->assertEquals($count, $this->hashmap->count());
    }

    public function tearDown()
    {
        $this->hashmap = null;
        $this->parameters = null;
    }
}
