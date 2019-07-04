<?php
/**
 * Created by PhpStorm.
 * User: ronal
 * Date: 22/06/2019
 * Time: 14:55
 */

namespace ChatShopping\Common;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait OnlyTrashed
{
    protected function onlyTrashedIfRequested(Request $request, Builder $query)
    {
        if ($request->get('trashed') == 1){
            $query = $query->onlyTrashed();
        }
        return $query;
    }
}
