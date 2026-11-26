<?php

declare(strict_types=1);

namespace Nitsan\NsGoogleMap\Controller;

use Nitsan\NsGoogleMap\Domain\Repository\AddressRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * AddressController
 */
class AddressController extends ActionController
{
    protected AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function listAction(): ResponseInterface
    {
        $this->includeFrontendAssets();

        $contentObject = $this->request->getAttribute('currentContentObject');
        $data = $contentObject?->data ?? [];

        $addressSetting = trim((string)($this->settings['address'] ?? ''));
        if ($addressSetting === '') {
            $address = $this->addressRepository->findAll()->toArray();
        } else {
            $addressIds = GeneralUtility::intExplode(',', $addressSetting, true);
            $address = $addressIds === []
                ? []
                : $this->addressRepository->findAddress($addressIds)->toArray();
        }

        $this->view->assignMultiple([
            'locations' => $address,
            'data' => $data,
        ]);

        return $this->htmlResponse();
    }

    /**
     * Load Maps/plugin JS only when this plugin renders (not site-wide).
     */
    protected function includeFrontendAssets(): void
    {
        static $included = false;
        if ($included) {
            return;
        }
        $included = true;

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

        if (!empty($this->settings['jquery'])) {
            $pageRenderer->addJsLibrary(
                'nsGoogleMapJquery',
                'EXT:ns_google_map/Resources/Public/Js/jquery.min.js',
                'text/javascript',
                null,
                true
            );
        }

        $pageRenderer->addJsFooterFile('EXT:ns_google_map/Resources/Public/Js/map.js');
        $pageRenderer->addJsFooterFile('EXT:ns_google_map/Resources/Public/Js/custom.js');
        $pageRenderer->addJsFooterFile('EXT:ns_google_map/Resources/Public/Js/markerclusterer.js');

        $apiKey = trim((string)($this->settings['apiKey'] ?? ''));
        if ($apiKey === '') {
            return;
        }

        $language = trim((string)($this->settings['language'] ?? 'en'));
        $mapsUrl = 'https://maps.googleapis.com/maps/api/js?' . http_build_query([
            'key' => $apiKey,
            'language' => $language !== '' ? $language : 'en',
            'libraries' => 'places',
            'loading' => 'async',
            'callback' => 'nsGoogleMapInit',
        ], '', '&', PHP_QUERY_RFC3986);

        $pageRenderer->addJsFooterLibrary(
            'nsGoogleMapsApi',
            $mapsUrl,
            'text/javascript',
            null,
            false,
            '',
            null,
            '|',
            true,
            '',
            true
        );
    }
}
