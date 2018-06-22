<?php
namespace Mointeng\SQLRelay\Connectors;

use PDO;
use Yajra\Pdo\Oci8;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class OracleConnector extends Connector implements ConnectorInterface
{
    /**
    * The Defautl PDO connection options.
    *
    * @var array
    */

    protected $options = [
        PDO::ATTR_CASE          => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
    ];

    public function connect(array $config)
    {
        $tns = ! empty($config['tns']) ? $config['tns'] : $this->getDsn($config);

        $options = $this->getOptions($config);

        $connection = $this->createConnection($tns, $config, $options);

        return $connection;
    }

    public function getDsn(array $config)
    {
        return "sqlrelay:host={$config['host']};port={$config['port']};socket={$config['socket']};tries=0;retrytime=1;debug=0";
    }

    protected function setCharset(array $config)
    {
        if (! isset($config['charset'])) {
            $config['charset'] = 'AL32UTF8';
        }

        return $config;
    }
}
