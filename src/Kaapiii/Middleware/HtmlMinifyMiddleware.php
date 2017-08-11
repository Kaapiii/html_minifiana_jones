<?php

namespace Kaapiii\Middleware;

use Concrete\Core\Http\Middleware\MiddlewareInterface;
use Concrete\Core\Http\Middleware\DelegateInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * HtmlMinifyMiddleware
 *
 * @author Markus Liechti <markus@liechti.io>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class HtmlMinifyMiddleware implements MiddlewareInterface
{
    /**
     * Add or remove cookies from the
     * @param Request $request
     * @param \Concrete\Core\Http\Middleware\DelegateInterface $frame
     * @return Response
     */
    public function process(Request $request, DelegateInterface $frame)
    {
        $response = $frame->next($request);
        $minifiedContent = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$response->getContent()));

        $response->setContent($minifiedContent);

        return $response;
    }
}
