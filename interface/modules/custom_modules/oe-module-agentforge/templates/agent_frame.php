<?php

/**
 * AgentForge AI Assistant iframe container.
 *
 * Embeds the Streamlit chat UI from the companion AgentForge service
 * into the OpenEMR interface.
 *
 * @package   OpenEMR
 * @link      https://www.open-emr.org
 * @author    Rohan Thomas
 * @copyright Copyright (c) 2026
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once dirname(__FILE__, 5) . '/globals.php';

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Modules\AgentForge\Bootstrap;

$agentforgeUrl = Bootstrap::getAgentForgeUrl();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo xlt('AI Assistant'); ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #0e1117;
        }
        .header {
            background-color: #262730;
            color: #fafafa;
            padding: 10px 20px;
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h3 {
            margin: 0;
            font-size: 16px;
        }
        .status {
            color: #00d26a;
            font-size: 12px;
        }
        iframe {
            width: 100%;
            height: calc(100vh - 45px);
            border: none;
        }
        .error-container {
            display: none;
            color: #fafafa;
            text-align: center;
            padding: 60px 20px;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .error-container h2 {
            color: #ff4b4b;
        }
        .error-container p {
            color: #808495;
            max-width: 500px;
            margin: 10px auto;
        }
        .error-container code {
            background: #262730;
            padding: 2px 8px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>AgentForge AI Healthcare Assistant</h3>
        <span class="status" id="status">Connecting...</span>
    </div>

    <iframe id="agent-frame"
            src="<?php echo attr($agentforgeUrl); ?>"
            title="AI Assistant"
            sandbox="allow-scripts allow-same-origin allow-forms allow-popups">
    </iframe>

    <div class="error-container" id="error-msg">
        <h2>AI Assistant Unavailable</h2>
        <p>The AgentForge service is not running. Start it with:</p>
        <p><code>docker-compose -f docker-compose.yml -f docker-compose.agentforge.yml up</code></p>
        <p>Or set the <code>AGENTFORGE_URL</code> environment variable to point to your running instance.</p>
    </div>

    <script>
        const frame = document.getElementById('agent-frame');
        const status = document.getElementById('status');
        const errorMsg = document.getElementById('error-msg');

        frame.onload = function() {
            status.textContent = 'Connected';
        };

        frame.onerror = function() {
            frame.style.display = 'none';
            errorMsg.style.display = 'block';
            status.textContent = 'Disconnected';
            status.style.color = '#ff4b4b';
        };

        // Timeout check
        setTimeout(function() {
            if (status.textContent === 'Connecting...') {
                status.textContent = 'Connected';
            }
        }, 5000);
    </script>
</body>
</html>
