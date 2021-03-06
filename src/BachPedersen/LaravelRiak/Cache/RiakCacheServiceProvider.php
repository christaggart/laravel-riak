<?php
/*
   Copyright 2013: Kaspar Bach Pedersen

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace BachPedersen\LaravelRiak\Cache;

use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;
use Riak\Connection;
use Cache;

class RiakCacheServiceProvider extends ServiceProvider
{
    const DEFAULT_BUCKET_NAME = 'laravel.cache';

    public function boot()
    {
        $this->package('bach-pedersen/laravel-riak');
        Cache::extend('riak', function($app)
        {
            /** @var $riak Connection */
            $riak = $app['riak'];
            $bucketName = $app['config']['cache.bucket'];
            if (!isset($bucketName)) {
                $bucketName = self::DEFAULT_BUCKET_NAME;
            }
            return new Repository(new RiakStore($riak, $riak->getBucket($bucketName)));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}