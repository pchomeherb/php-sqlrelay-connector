<?php
namespace Mointeng\SQLRelay;

use Mointeng\SQLRelay\Connectors\OracleConnector;

class SqlRelayConnectionFactory 
{
    public static function getInstance($connection, $database, $prefix, $config)
    {
        $database = strtolower(trim($database));
        switch($database) {
            case 'mysql':
                // TODO ....
                break;
            case 'oracle':
                return new OracleConnector($connection, $database, $prefix, $config);
                break;
        }
    }
}
