<?php

declare(strict_types=1);

namespace Nitsan\NsGoogleMap\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Escapes a string for safe use inside a JavaScript string literal.
 *
 * Kept for backward compatibility with overridden Fluid templates that still
 * wrap values as: title: '<nsgooglemap:escape>...</nsgooglemap:escape>'
 */
class EscapeViewHelper extends AbstractViewHelper
{
    protected $escapeChildren = false;
    protected $escapeOutput = false;

    public function render(): string
    {
        $value = (string)$this->renderChildren();
        // Strip surrounding quotes from json_encode so callers can keep their own quotes.
        $encoded = json_encode(
            $value,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
        );

        if ($encoded === false) {
            return '';
        }

        return substr($encoded, 1, -1);
    }
}
