<?php
namespace Mointeng\SQLRelay;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Mointeng\SQLRelay\SqlRelayConnectionFactory;
use Mointeng\SQLRelay\Connectors\OracleConnector;

class SQLRelayServiceProvider extends ServiceProvider
{
    /**
    * Register ther application services.
    * @return void
    */

    public function register()
    {
        app()->bind('db.connector.sqlrelay', SQLRelayConnector::class);

        Connection::resolverFor('sqlrelay', function ($connection, $database, $prefix, $config) {
            return SqlRelayConnectionFactory::getInstance($connection, $database, $prefix, $config);
        });
    }
}
