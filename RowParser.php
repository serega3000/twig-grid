<?php

namespace Serega3000\TwigGrid;

use Twig_TokenParser;
use Twig_Token;
use Twig_Error_Syntax;

/**
 * Row parser for grids
 */
class RowParser extends Twig_TokenParser
{        
    public function parse(Twig_Token $token)
    {
        $stream = $this->parser->getStream();
        $stream->expect(Twig_Token::BLOCK_END_TYPE);     

        $inheritanceIndex = 1;
        $nodes = array();
        $returnNode = null;
        
        while(true) {
            
            $content = $this->parser->subparse(array($this, 'decideMyTagFork'));
            $nodes[$inheritanceIndex][] = $content;
            $tag = $stream->next()->getValue();
            $stream->expect(Twig_Token::BLOCK_END_TYPE);            
            switch($tag) {
                case "row":
                    $inheritanceIndex++;
                    break;
                case "endrow":
                    $currentNodes = $nodes[$inheritanceIndex];
                    unset($nodes[$inheritanceIndex]);
                    $inheritanceIndex--;                                        
                    if($inheritanceIndex == 0) {
                        $returnNode = new RowNode($currentNodes);
                        break 2;
                    } else {
                        $nodes[$inheritanceIndex][] = new RowNode($currentNodes);
                    }
                    break;
                default:
                    throw new Twig_Error_Syntax(sprintf('Unexpected end of template. Twig was looking for the following tags "%s" to close the "%s" block started at line %d)', "endrow", "row", $this->startLine), -1);
            }                               
        }
        
        return $returnNode;

    }
    
    public function getTag()
    {
        return "row";
    }
    
    /**
     * Callback called at each tag name when subparsing, must return
     * true when the expected end tag is reached.
     *
     * @param \Twig_Token $token
     * @return bool
     */
    public function decideMyTagFork(Twig_Token $token)
    {
        return $token->test(array("row", "endrow"));
    }    
}
