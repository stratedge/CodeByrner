<?php

class CodeByrner extends CI_Controller {
    
    function loadCodeByrner(Array $classes)
    {
        foreach($classes as $class)
        {
            $this->load->library($class);
        }
    }
    
}
