<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;

interface SocialRepositoryInterface
{        
    /**
     * Generate a url for the authenticated
     *
     * @param  string $provider
     * @return string
     */
    public function getUrlProvider(string $provider);
    
    /**
     * handleProviderCallback
     *
     * @param  string $provider
     * @return \App\Models\User
     */
    public function handleProviderCallback(string $provider);
}
