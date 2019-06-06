<?php
/*
 * Copyright 2018 Alexey Kopytko <alexey@kopytko.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace RussianPostIndex\Util;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

final class Deserializer
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->build();

        if (method_exists(AnnotationRegistry::class, 'registerUniqueLoader')) {
            AnnotationRegistry::registerUniqueLoader('class_exists');
        } elseif (method_exists(AnnotationRegistry::class, 'registerLoader')) {
            AnnotationRegistry::registerUniqueLoader('class_exists');
        }
    }

    /**
     * @param mixed $data
     *
     * @return \RussianPostIndex\Record|null
     */
    public function deserialize($data)
    {
        return $this->serializer->deserialize((string) $data, ConcreteRecord::class, 'json');
    }
}
