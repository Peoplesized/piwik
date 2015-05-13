<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\UserCountry\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\UserCountry\Columns\City;

class GetCity extends Base
{
    protected function init()
    {
        parent::init();
        $this->dimension      = new City();
        $this->name           = Piwik::translate('UserCountry_City');
        $this->documentation  = Piwik::translate('UserCountry_getCityDocumentation') . '<br/>' . $this->getGeoIPReportDocSuffix();
        $this->metrics        = array('nb_visits', 'nb_uniq_visitors', 'nb_actions');
        $this->hasGoalMetrics = true;
        $this->order = 8;

        $this->createWidget()
             ->setName(Piwik::translate('UserCountry_WidgetLocation') . ' (' . Piwik::translate('UserCountry_City') . ')')
             ->setCategory('General_Visitors')
             ->setSubCategory('UserCountry_SubmenuLocations');
    }

    public function configureView(ViewDataTable $view)
    {
        $view->config->show_exclude_low_population = false;
        $view->config->documentation = $this->documentation;
        $view->config->addTranslation('label', $this->dimension->getName());

        $view->requestConfig->filter_limit = 5;

        $this->checkIfNoDataForGeoIpReport($view);
    }

}
