<?php

declare(strict_types=1);

namespace Tests\Kwizer\Hydrator;

use PHPUnit\Framework\TestCase;
use Tests\Kwizer\Hydrator\Hydrator\Model;

use Kwizer\Hydrator\Hydrator;

class HydratorTest extends TestCase
{
    private $hydrator;

    protected function setUp()
    {
        $this->hydrator = new Hydrator();
    }

    public function testHydratePublicProperty()
    {
        $datas = ['public' => 'foo'];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('foo', $model->getPublic());
        $this->assertEquals('foo', $model->public);
    }

    public function testHydratePublicPropertyWithObject()
    {
        $datas = new \stdClass();
        $datas->public = 'bar';
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('bar', $model->getPublic());
        $this->assertEquals('bar', $model->public);
    }

    public function testHydrateWithedProperty()
    {
        $datas = ['withed' => 'foo'];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('foo', $model->getWithed());
    }

    public function testHydrateSettedProperty()
    {
        $datas = ['setted' => 'foo'];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('foo', $model->getSetted());
    }

    public function testHydrateSettedPropertyCallSetter()
    {
        $datas = ['setucase' => 'foo'];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('FOO', $model->getSetucase());
    }

    public function testHydrateProtectedProperty()
    {
        $datas = ['protected' => 'foo'];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('foo', $model->getProtected());
    }

    public function testHydratePrivateProperty()
    {
        $datas = ['private' => 'foo'];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('foo', $model->getPrivate());
    }

    public function testHydrateAllWithArray()
    {
        $datas = [
            'public' => 'one',
            'protected' => 'two',
            'private' => 'three',
            'setted' => 'four',
            'withed' => 'five',
            'setucase' => 'six',
        ];
        $model = $this->hydrator->hydrate(Model::class, $datas);
        $this->assertEquals('one', $model->getPublic());
        $this->assertEquals('two', $model->getProtected());
        $this->assertEquals('three', $model->getPrivate());
        $this->assertEquals('four', $model->getSetted());
        $this->assertEquals('five', $model->getWithed());
        $this->assertEquals('SIX', $model->getSetucase());
    }
}
