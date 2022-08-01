<?php
namespace Mointeng\SQLRelay;

#use Illuminate\Database\Connectors\MySqlConnector;
#use \Illuminate\Database\MysqlConnection;
#use Yajra\Oci8\Oci8Connection\Oci8Connection;



class SQLRelayConnectionFactory
{
    public static function getInstance($connection, $database, $prefix, $config)
    {
        if (!isset($config['system'])) {
            throw new \Exception ("Undefined Database system parameter \$config[\"system\"] while using sqlrelay driver");
        }
        $system = strtolower(trim($config['system']));

        switch($system) {
            case 'mysql':
                $connector = new Connectors\MySqlConnector();
                $connection = $connector->connect($config);
                $db = new \Illuminate\Database\MysqlConnection($connection, $database, $prefix, $config);

                break;
            case 'postgres':
            case 'pgsql':
                $connector = new Connectors\PostgresConnector();
                $connection = $connector->connect($config);
                $db = new \Illuminate\Database\PostgresConnection($connection, $database, $prefix, $config);
                break;
            case 'oracle':
                $connector = new Connectors\OracleConnector();
                $connection = $connector->connect($config);
                $db = new Connections\OracleConnection($connection, $database, $prefix, $config);

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
                break;
            default:
                return false;
        }

        return $db;
    }
}
