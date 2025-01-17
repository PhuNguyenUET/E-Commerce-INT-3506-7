<?php
/**
 * Copyright 2018 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible usage of 'var' language construction.
 */
class VarSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Use of var class variables is discouraged.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundVar';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_VAR];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
    }
}
