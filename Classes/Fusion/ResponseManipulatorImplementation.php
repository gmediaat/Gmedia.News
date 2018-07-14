<?php
namespace Gmedia\News\Fusion;
/*                                                                        *
 * This script belongs to the Flow package "Gmedia.News".           *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 * Fusion Response Manupulator
 *
 * @api
 */
class ResponseManipulatorImplementation extends AbstractFusionObject {

	/**
	 * Inject bootstrap
	 *
	 * @Flow\Inject
	 * @var Bootstrap
	 */
	protected $bootstrap;

	/**
	 * {@inheritdoc}
	 *
	 * @return string
	 */
	public function evaluate() {
		$response = $this->bootstrap->getActiveRequestHandler()->getHttpResponse();
		$response->setHeader('Content-Type', 'application/xml');
	}

}
