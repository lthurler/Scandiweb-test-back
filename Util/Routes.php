<?php

namespace Util;


class Routes
{
    public function getRoutes()
     {
        $uri = str_replace( '/' . DIR_PROJECT, '', $_SERVER['REQUEST_URI']);
        $url = explode('/', trim($uri,'/'));

        $request = [];
        $request['route'] = $url[0];
        $request['resource'] = $url[1] ?? null;        
        $request['method'] = $_SERVER['REQUEST_METHOD'];

        return $request;
    }    
}
