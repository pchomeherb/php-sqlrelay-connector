<?php
namespace Mointeng\SQLRelay\Connectors;

class PostgresConnector extends \Illuminate\Database\Connectors\PostgresConnector
{
    protected function getDsn(array $config)
    {
        return "sqlrelay:host={$config['host']};port={$config['port']};socket={$config['socket']};tries=0;retrytime=1;debug=0";
    }
}