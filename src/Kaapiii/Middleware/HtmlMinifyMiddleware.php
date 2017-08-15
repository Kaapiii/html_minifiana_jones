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
        
        $html = $response->getContent();
        
        // Remove Comments 
        // - Single line //
        // - Multiline on one line /* */
        // - Multiline comments on multiple lines
        $commentPattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/';
        $html = preg_replace($commentPattern, '', $html);
        
        // Remove line breaks
        $html = str_replace(array("\n","\r","\t"),' ',$html);
        
        // Remove multiple white spaces
        $html = preg_replace('/[[:blank:]]+/', ' ', $html);
        
        // Remove white space between html tags; shorten multiple whitespaces to one
        $html = preg_replace('/(\>)\s*(\<)/m', '$1$2', $html);

        $response->setContent($html);
        return $response;
    }
}
