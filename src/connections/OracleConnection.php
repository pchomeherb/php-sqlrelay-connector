<?php
namespace Mointeng\SQLRelay\Connections;

use \Yajra\Oci8\Oci8Connection;

class OracleConnection extends Oci8Connection
{

    /**
     * Over write \Yajra\Oci8\Oci8Connection::bindValues();
     *
     * @param PDOStatement $statement
     * @param array        $bindings
     */
    public function bindValues($statement, $bindings)
    {
        foreach ($bindings as $key => $value) {
            $statement->bindParam($key + 1, $bindings[$key]);
        }
    }
}
