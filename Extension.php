<?php

namespace Serega3000\TwigGrid;

class Extension extends \Twig_Extension
{    
    public function getTokenParsers()
    {
        return array(
            new RowParser(),
            new ColumnParser()
        );
    }
    
    public function getName()
    {
        return "serega3000_twig_grid_ext";
    }
}
