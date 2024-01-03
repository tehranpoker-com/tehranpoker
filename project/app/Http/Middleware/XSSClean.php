<?php

namespace App\Http\Middleware;

use Closure;

class XSSClean
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $userInput = $request->all();
        
        array_walk_recursive($userInput, function ($userInput, $key) {
            if(!in_array($key, ['content'])){
                $userInput = $this->clean_input($userInput);
            }
        });
        $request->merge($userInput);
        return $next($request);
    }


    public function clean_input( $input, $safe_level = 0 ) {
        $allowed_tags = array('strong', 'b', 'br', 'hr', 'em', 'hr', 'i', 's', 'span', 'a');
        if($input){
            $output = $input;
            do {
                // Treat $input as buffer on each loop, faster than new var
                $input = $output;
                
                // Remove unwanted tags
                $output = $this->strip_tags( $input );
                $output = $this->strip_encoded_entities( $output );

                // Use 2nd input param if not empty or '0'
                if ( $safe_level !== 0 ) {
                    $output = $this->strip_base64( $output );
                }

            } while ( $output !== $input );

            $output = trim($output);
            $output = unsanitize_text($output);
            $output = strip_tags($output, $allowed_tags);
            $output = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $output);
            return $output;
        }
        else {
            return '';
        }
        
    }

    

    private function strip_encoded_entities( $input ) {

        // Fix &entity\n;
        $input = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $input);
        $input = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $input);
        $input = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $input);
        $input = html_entity_decode($input, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $input = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+[>\b]?#iu', '$1>', $input);

        // Remove javascript: and vbscript: protocols
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $input);

        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $input);

        return $input;

    }

    private function strip_tags( $input ) {
        // Remove tags
        $input = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $input);
        // Remove namespaced elements
        $input = preg_replace('#</*\w+:\w[^>]*+>#i', '', $input);
        return $input;

    }

    private function strip_base64( $input ) {
        $decoded = base64_decode( $input );
        $decoded = $this->strip_tags( $decoded );
        $decoded = $this->strip_encoded_entities( $decoded );
        $output = base64_encode( $decoded );
        return $output;
    }

}
