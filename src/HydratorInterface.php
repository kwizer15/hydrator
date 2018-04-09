<?php
/*
 * This file is part of Hydrator
 *
 * (c) Emmanuel Bernaszuk <kwizer15@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


declare(strict_types=1);

namespace Kwizer\Hydrator;

/**
 * Undocumented interface
 */
interface HydratorInterface
{
    /**
     * Hydrate un objet
     *
     * @param object|string $destination Object or class name to hydrate
     * @param array|object $source Data source
     * @return object Hydrated object
     */
    public function hydrate($destination, $source);
}
