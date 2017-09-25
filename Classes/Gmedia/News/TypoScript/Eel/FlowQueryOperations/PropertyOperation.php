<?php
namespace Gmedia\News\TypoScript\Eel\FlowQueryOperations;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Lelesys.News".          *
 *                                                                        *
 *                                                                        */

use TYPO3\Eel\FlowQuery\Operations\AbstractOperation;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\Eel\FlowQuery\FlowQuery;

/**
 * Extended EEL property() operation for News
 */
class PropertyOperation extends AbstractOperation {
	/**
	 * {@inheritdoc}
	 *
	 * @var string
	 */
	static protected $shortName = 'property_array';

	/**
	 * {@inheritdoc}
	 *
	 * @var integer
	 */
	static protected $priority = 100;

	/**
	 * {@inheritdoc}
	 *
	 * @var boolean
	 */
	static protected $final = TRUE;

	/**
	 * {@inheritdoc}
	 *
	 * We can only handle TYPO3CR Nodes.
	 *
	 * @param mixed $context
	 * @return boolean
	 */
	public function canEvaluate($context) {
		return (isset($context[0]) && ($context[0] instanceof NodeInterface) && $context[0]->getNodeType()->isOfType('Gmedia.News:List'));
	}

	/**
	 * {@inheritdoc}
	 *
	 * @param FlowQuery $flowQuery the FlowQuery object
	 * @param array $arguments the arguments for this operation
	 * @return mixed
	 */
	public function evaluate(FlowQuery $flowQuery, array $arguments) {
		if (!isset($arguments[0]) || empty($arguments[0])) {
			throw new \TYPO3\Eel\FlowQuery\FlowQueryException('property_array() does not support returning all attributes yet', 1332492263);
		} else {
			$context = $flowQuery->getContext();
			$propertyPath = $arguments[0];

			if (!isset($context[0])) {
				return NULL;
			}

			$element = $context[0];
			if ($propertyPath[0] === '_') {
				return \TYPO3\Flow\Reflection\ObjectAccess::getPropertyPath($element, substr($propertyPath, 1));
			} else {
				return $element->getProperty($propertyPath, TRUE);
			}
		}
	}
}
