<?php

class YXssFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        // Filter GET and POST data
        $this->filterRequestData($_GET);
        $this->filterRequestData($_POST);
        
        return true;
    }
    
    protected function filterRequestData(&$data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $this->filterRequestData($data[$key]);
                } else {
                    // Strip HTML tags and encode special characters
                    $data[$key] = htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
                }
            }
        }
    }
} 