<?php
namespace Mointeng\SQLRelay\Connectors;

class MySqlConnector extends \Illuminate\Database\Connectors\MySqlConnector
{
    protected function getDsn(array $config)
    {
        return "sqlrelay:host={$config['host']};port={$config['port']};socket={$config['socket']};tries=0;retrytime=1;debug=0";
    }
}