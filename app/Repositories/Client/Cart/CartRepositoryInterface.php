<?php

namespace App\Repositories\Client\Cart;

use App\Repositories\RepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Request;

interface CartRepositoryInterface extends RepositoryInterface
{
    /**
     * firstOrCreate
     *
     * @return self
     */
    public function firstOrCreate();

    /**
     * getRelationships
     *
     * @return array
     */
    public function getRelationships();

    /**
     * Execute the query
     *
     * @return Cart
     */
    public function execute();

    /**
     * Render the checkout view
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function checkout();

    /**
     * checkoutHandle
     *
     * @param  Request $request
     * @return void
     */
    public function checkoutHandle(Request $request);
}
