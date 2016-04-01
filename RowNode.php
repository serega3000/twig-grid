<?php

namespace Serega3000\TwigGrid;

use Twig_Node;
use Twig_Compiler;

/**
 * Row node
 */
class RowNode extends Twig_Node
{    
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);        
        $compiler->write("echo \"<div class='row'>\";")->raw(PHP_EOL);        
        parent::compile($compiler);
        $compiler->write("echo \"</div>\";")->raw(PHP_EOL);
    }
}
