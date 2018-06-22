<?php
namespace Mointeng\SQLRelay;

use Mointeng\SQLRelay\Connectors\OracleConnector;
use Yajra\Oci8\Oci8Connection;

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
                $connector = new OracleConnector();
                $connection = $connector->connect($config);
                $db = new Oci8Connection($connection, $database, $prefix, $config);

                // set oracle session variables
                $sessionVars = [
                    'NLS_TIME_FORMAT'         => 'HH24:MI:SS',
                    'NLS_DATE_FORMAT'         => 'YYYY-MM-DD HH24:MI:SS',
                    'NLS_TIMESTAMP_FORMAT'    => 'YYYY-MM-DD HH24:MI:SS',
                    'NLS_TIMESTAMP_TZ_FORMAT' => 'YYYY-MM-DD HH24:MI:SS TZH:TZM',
                    'NLS_NUMERIC_CHARACTERS'  => '.,',
                ];

                if (isset($config['schema'])) {
                    $sessionVars['CURRENT_SCHEMA'] = $config['schema'];
                }

                if (isset($config['session'])) {
                    $sessionVars = array_merge($sessionVars, $config['session']);
                }

                $db->setSessionVars($sessionVars);

                return $db;
            default:
                return false;
        }


    }
}
