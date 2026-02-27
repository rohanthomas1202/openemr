<?php

/**
 * Bootstrap class for the AgentForge AI Healthcare Assistant module.
 *
 * @package   OpenEMR
 * @link      https://www.open-emr.org
 * @author    Rohan Thomas
 * @copyright Copyright (c) 2026
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Modules\AgentForge;

class Bootstrap
{
    /**
     * @var string The default URL for the AgentForge service
     */
    private const DEFAULT_AGENTFORGE_URL = 'http://localhost:8080';

    /**
     * Get the AgentForge service URL from environment or default.
     *
     * @return string
     */
    public static function getAgentForgeUrl(): string
    {
        return getenv('AGENTFORGE_URL') ?: self::DEFAULT_AGENTFORGE_URL;
    }
}
