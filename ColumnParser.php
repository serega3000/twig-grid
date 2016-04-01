<?php

namespace Serega3000\TwigGrid;

use Twig_TokenParser;
use Twig_Token;
use Twig_Error_Syntax;

/**
 * Column parser for grids
 */
class ColumnParser extends Twig_TokenParser
{        
    public function parse(Twig_Token $token)
    {
        $inheritanceIndex = 1;        
        
        $stream = $this->parser->getStream();
        
        $nodes = array();
        $classes = array();
        $returnNode = null;        
        
        if($stream->test(Twig_Token::STRING_TYPE)) {
            $classes[$inheritanceIndex] = $this->parser->getExpressionParser()->parseStringExpression();
        } else {
            $classes[$inheritanceIndex] = "col-md-12";
        }                    
        
        $stream->expect(Twig_Token::BLOCK_END_TYPE);            
        
        $continue = true;
        
        while($continue) {
            
            $content = $this->parser->subparse(array($this, 'decideMyTagFork'));
            $nodes[$inheritanceIndex][] = $content;
            $tag = $stream->next()->getValue();                        
            
            switch($tag) {
                case "col":
                    $inheritanceIndex++;
                    if($stream->test(Twig_Token::STRING_TYPE)) {
                        $classes[$inheritanceIndex] = $this->parser->getExpressionParser()->parseStringExpression();
                    } else {
                        $classes[$inheritanceIndex] = "col-md-12";
                    }                                    
                    break;
                case "endcol":
                    $currentNodes = $nodes[$inheritanceIndex];
                    $class = $classes[$inheritanceIndex];
                    unset($nodes[$inheritanceIndex]);
                    unset($classes[$inheritanceIndex]);
                    $inheritanceIndex--;                                        
                    if($inheritanceIndex == 0) {
                        $returnNode = new ColumnNode($currentNodes);
                        $returnNode->setClass($class);       
                        $continue = false;
                    } else {
                        $node = new ColumnNode($currentNodes);
                        $node->setClass($class);
                        $nodes[$inheritanceIndex][] = $node;
                    }
                    break;
                default:
                    throw new Twig_Error_Syntax(sprintf('Unexpected end of template. Twig was looking for the following tags "%s" to close the "%s" block started at line %d)', "endrow", "row", $this->startLine), -1);                                    
            }   
            $stream->expect(Twig_Token::BLOCK_END_TYPE);
        }
        
        return $returnNode;

    }
    
    public function getTag()
    {
        return "col";
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
        return $token->test(array("col", "endcol"));
    }    
}
