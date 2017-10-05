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
 * Group news nodes collection
 * TODO - this can be optimized a little further to make it work on grouping of
 * any nodes and not only menu items
 */
class GroupOperation extends  AbstractOperation {
	/**
	 * {@inheritdoc}
	 *
	 * @var string
	 */
	static protected $shortName = 'group';

	/**
	 * {@inheritdoc}
	 *
	 * @var integer
	 */
	static protected $priority = 100;

	/**
	 * {@inheritdoc}
	 *
	 * We can only handle Menu items for now.
	 *
	 * @param mixed $context
	 * @return boolean
	 */
	public function canEvaluate($context) {
		return (isset($context[0]['node']) && ($context[0]['node'] instanceof NodeInterface));
	}

	/**
	 * {@inheritdoc}
	 *
	 * @param FlowQuery $flowQuery the FlowQuery object
	 * @param array $arguments the arguments for this operation
	 * @return mixed
	 */
	public function evaluate(FlowQuery $flowQuery, array $arguments) {
		$items = $flowQuery->getContext();
		$groupedItems = array();
		foreach ($items as $item) {
			if (isset($item['node'])) {
				$dateTime = $item['node']->getProperty('dateTime');
				if ($dateTime instanceof \DateTime) {
					$year = $dateTime->format('Y');
					$month = $dateTime->format('m');
					$groupedItems[$year][$month][] = $item['node'];
				}
			}
		}
		ksort($groupedItems);
		$groupedItems = array_reverse($groupedItems, true);
		$flowQuery->setContext($groupedItems);
	}
}
