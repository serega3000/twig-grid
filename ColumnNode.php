<?php

namespace Serega3000\TwigGrid;

use Twig_Node;
use Twig_Compiler;

/**
 * Column node
 */
class ColumnNode extends Twig_Node
{    
    private $class = "";
    
    public function setClass($class)
    {
        $this->class = $class;
    }
    
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);        
        $compiler->write("echo \"<div class='col ");
        
        $class = "col-md-12";
        if($this->class instanceof \Twig_Node_Expression_Constant) {                                    
            $class = preg_replace("/\b(lg|md|sm|xs)([0-9]+)\b/", 'col-$1-$2', $this->class->getAttribute("value"));            
        }
        $compiler->raw($class);
        
        $compiler->raw("'>\";")->raw(PHP_EOL);        
        parent::compile($compiler);
        $compiler->write("echo \"</div>\";")->raw(PHP_EOL);
    }
}
