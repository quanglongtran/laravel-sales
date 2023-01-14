<?php

namespace App\Traits;

trait PermissionMiddleware
{
    /**
     * setMidleware
     *
     * @param  string $group_name
     * @return void
     */
    public function setMidleware(string $group_name)
    {
        $this->middleware("permission:create-$group_name", ['only' => ['create', 'store']]);
        $this->middleware("permission:show-$group_name", ['only' => ['index']]);
        $this->middleware("permission:update-$group_name", ['only' => ['edit', 'update']]);
        $this->middleware("permission:delete-$group_name", ['only' => ['delete', 'destroy']]);
    }
}
