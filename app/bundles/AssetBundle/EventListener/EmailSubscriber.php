<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\AssetBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;

/**
 * Class EmailSubscriber
 */
class EmailSubscriber extends CommonSubscriber
{
    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents ()
    {
        return array(
            EmailEvents::EMAIL_ON_BUILD => array('onEmailBuild', 0),
        );
    }

    /**
     *
     * @param EmailBuilderEvent $event
     */
    public function onEmailBuild (EmailBuilderEvent $event)
    {
        if ($event->abTestWinnerCriteriaRequested()) {
            //add AB Test Winner Criteria
            $formSubmissions = array(
                'group'    => 'mautic.asset.abtest.criteria',
                'label'    => 'mautic.asset.abtest.criteria.downloads',
                'callback' => '\Mautic\AssetBundle\Helper\AbTestHelper::determineDownloadWinner'
            );
            $event->addAbTestWinnerCriteria('asset.downloads', $formSubmissions);
        }
    }
}
