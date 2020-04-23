<?php
namespace HolmesMedia\Snifs\Whitespace;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class SuperfluousNewlinesSniff implements Sniff
{
    
    public function register()
    {
        return [
            T_OPEN_CURLY_BRACKET,
            T_CLOSE_CURLY_BRACKET
        ];
    }
    
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        
        $currentToken = $tokens[$stackPtr];
        
        if ($currentToken['code'] == T_OPEN_CURLY_BRACKET) {
            $nextNonWhitespaceIndex = $phpcsFile->findNext([T_WHITESPACE], $stackPtr + 1, null, true);
        } else {
            $nextNonWhitespaceIndex = $phpcsFile->findPrevious([T_WHITESPACE], $stackPtr - 1, null, true);
        }
        
        if ($this->tokenIndexIsInsideFunction($phpcsFile, $nextNonWhitespaceIndex)) {
            $nextNonWhitespaceToken = $tokens[$nextNonWhitespaceIndex];
            
            if (abs($nextNonWhitespaceToken['line'] - $currentToken['line']) > 1) {
                $phpcsFile->addFixableError(
                    "Superfluous newlines found before/after scope start/end",
                    $stackPtr,
                    'SuperfluousNewlines'
                );
                $phpcsFile->fixer->beginChangeset();
                $phpcsFile->fixer->replaceToken($stackPtr + 1, '');
                $phpcsFile->fixer->endChangeset();
            }
        }
    }
    
    private function tokenIndexIsInsideFunction(File $phpcsFile, $index)
    {
        $tokens = $phpcsFile->getTokens();
        
        $tokenIndex = $phpcsFile->findPrevious(
            [
                T_FUNCTION,
                T_CLOSE_CURLY_BRACKET,
                T_OPEN_CURLY_BRACKET
            ],
            $index
        );
        
        $bracketCount = 0;
        while ($tokenIndex) {
            $token = $tokens[$tokenIndex];
            
            switch ($token['code']) {
                case T_CLOSE_CURLY_BRACKET:
                    $bracketCount++;
                    break;
                case T_OPEN_CURLY_BRACKET:
                    $bracketCount--;
                    break;
                case T_FUNCTION:
                    if ($bracketCount < 0) {
                        return true;
                    }
                    break;
            }

            $tokenIndex = $phpcsFile->findPrevious(
                [
                    T_FUNCTION,
                    T_CLOSE_CURLY_BRACKET,
                    T_OPEN_CURLY_BRACKET
                ],
                $tokenIndex - 1
            );
        }
        
        return false;
    }
    
}