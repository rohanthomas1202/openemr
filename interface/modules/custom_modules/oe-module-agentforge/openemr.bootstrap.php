<?php

/**
 * AgentForge AI Healthcare Assistant Module
 *
 * Integrates an AI-powered clinical assistant into OpenEMR that provides:
 * - Patient summary lookups via FHIR API
 * - Drug interaction checking with safety verification
 * - Symptom-to-condition analysis
 * - Provider search and appointment availability
 * - Multi-step clinical reasoning with hallucination detection
 *
 * The assistant runs as a companion service (Python/FastAPI + Streamlit)
 * and is embedded in the OpenEMR UI via an iframe.
 *
 * @package   OpenEMR
 * @link      https://www.open-emr.org
 * @author    Rohan Thomas
 * @copyright Copyright (c) 2026
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Modules\AgentForge;

use OpenEMR\Events\PatientDemographics\RenderEvent;
use OpenEMR\Menu\MenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @var EventDispatcherInterface $eventDispatcher
 * @var array $module
 */

// Register the menu item for the AI Assistant
$eventDispatcher->addListener(MenuEvent::MENU_UPDATE, function (MenuEvent $event) {
    $menu = $event->getMenu();

    $menuItem = new \stdClass();
    $menuItem->requirement = 0;
    $menuItem->target = 'mod';
    $menuItem->menu_id = 'mod0';
    $menuItem->label = xl('AI Assistant');
    $menuItem->url = '/interface/modules/custom_modules/oe-module-agentforge/templates/agent_frame.php';
    $menuItem->children = [];
    $menuItem->acl_req = [];
    $menuItem->global_req = [];

    // Add under the Modules menu
    foreach ($menu as $item) {
        if ($item->menu_id === 'modimg') {
            $item->children[] = $menuItem;
            break;
        }
    }

    $event->setMenu($menu);
});
