<?php

declare(strict_types=1);

namespace Tests\Kwizer\Hydrator\Hydrator;

/**
 * Hydrator
 */
class Model
{
    private $setted;

    private $setucase;

    private $withed;

    private $private;

    protected $protected;

    public $public;

    public function setSetted(string $setted): self
    {
        $this->setted = $setted;
        return $this;
    }

    public function setSetucase(string $setucase)
    {
        $this->setucase = strtoupper($setucase);
        return $this;
    }
    

    public function withWithed(string $withed): Model
    {
        $model = clone $this;
        $model->withed = $withed;
        return $model;
    }

    public function getSetted(): string
    {
        return $this->setted;
    }

    public function getWithed(): string
    {
        return $this->withed;
    }
    
    public function getPrivate(): string
    {
        return $this->private;
    }
    
    public function getProtected(): string
    {
        return $this->protected;
    }
    
    public function getPublic(): string
    {
        return $this->public;
    }

    public function getSetucase(): string
    {
        return $this->setucase;
    }
}
