<?php

declare(strict_types=1);

namespace Nitsan\NsGoogleMap\Form\Resolver;

use Nitsan\NsGoogleMap\Backend\PremiumStrip;
use Nitsan\NsGoogleMap\Form\Container\PremiumStripFlexFormTabsContainer;
use TYPO3\CMS\Backend\Form\NodeFactory;
use TYPO3\CMS\Backend\Form\NodeResolverInterface;

/**
 * Uses PremiumStripFlexFormTabsContainer for the plugin options (pi_flexform) of the Google Map plugin.
 */
final class PremiumStripFlexFormTabsContainerResolver implements NodeResolverInterface
{
    private array $data;

    /**
     * TYPO3 v12 passes the node factory and data to the constructor, v13+ calls setData().
     */
    public function __construct(?NodeFactory $nodeFactory = null, array $data = [])
    {
        $this->data = $data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function resolve(): ?string
    {
        if (($this->data['tableName'] ?? '') !== 'tt_content'
            || ($this->data['fieldName'] ?? '') !== 'pi_flexform'
            || !empty($this->data['isInlineChild'])
        ) {
            return null;
        }

        $recordType = (string)($this->data['recordTypeValue'] ?? '');
        if ($recordType === PremiumStrip::PLUGIN_SIGNATURE) {
            return PremiumStripFlexFormTabsContainer::class;
        }

        $listType = $this->data['databaseRow']['list_type'] ?? '';
        if (is_array($listType)) {
            $listType = (string)($listType[0] ?? '');
        }

        return $recordType === 'list' && $listType === PremiumStrip::PLUGIN_SIGNATURE
            ? PremiumStripFlexFormTabsContainer::class
            : null;
    }
}
