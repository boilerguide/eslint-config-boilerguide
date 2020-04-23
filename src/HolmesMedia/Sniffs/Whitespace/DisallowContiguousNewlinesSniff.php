<?php
namespace HolmesMedia\Snifs\Whitespace;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * This is different from the Squiz superfluous whitespace sniff in that it detects contiguous newlines outside
 * of functions as well as inside them
 */

class DisallowContiguousNewlinesSniff implements Sniff
{
    public function register()
    {
        return [T_WHITESPACE];
    }
    
    /**
     * 
     * @param array $tokens
     * @param int $stackPtr
     * @return bool
     */
    private function isThisTheLastTokenOnLine(array $tokens, $stackPtr)
    {
        $currentLineNumber = $tokens[$stackPtr]['line'];
        
        $isThisTheSecondToLastTokenInFile = count($tokens) == $stackPtr + 1;
        
        if ($isThisTheSecondToLastTokenInFile) {
            return true;
        }
        
        $nextTokensLineNumber = $tokens[$stackPtr + 1]['line'];
        
        return $nextTokensLineNumber > $currentLineNumber;
    }
    
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        
        if (!$this->isThisTheLastTokenOnLine($tokens, $stackPtr)) {
            return;
        }
        
        $prevNonWhitespaceTokenIndex = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        $currentLineNumber = $tokens[$stackPtr]['line'];

        $prevNonWhitespaceToken = $tokens[$prevNonWhitespaceTokenIndex];

        $numberOfLinesBetweenLastNonWhiteSpaceTokenAndThisOne
            = $currentLineNumber - $prevNonWhitespaceToken['line'];

        if ($numberOfLinesBetweenLastNonWhiteSpaceTokenAndThisOne > 1) {
            $phpcsFile->addFixableError("Contiguous blank lines found", $stackPtr, 'ContiguousNewlines');
            $phpcsFile->fixer->beginChangeset();
            $start = $stackPtr-$numberOfLinesBetweenLastNonWhiteSpaceTokenAndThisOne;
            for ($i = $start; $i < $stackPtr - 1; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }

            $phpcsFile->fixer->endChangeset();
        }
    }
    
}
