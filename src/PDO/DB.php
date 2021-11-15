<?php
declare(strict_types=1);

namespace ToyORMapper\PDO;

use PDO;
use PDOStatement;

/**
 * Class DB
 *
 * @package ToyORMapper\PDO
 */
class DB
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO(
            getenv('DB_DSN') ?: null,
            getenv('DB_USER') ?: '',
            getenv('DB_PASSWORD') ?: '',
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $sql
     * @param array $params
     *
     * @return PDOStatement|false
     */
    private function execute(string $sql, array $params): PDOStatement|false
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    /**
     * @param string $sql
     * @param array $params
     *
     * @return mixed
     */
    final public function fetch(string $sql, array $params = []): mixed
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array $params
     *
     * @return array
     */
    final public function fetchAll(string $sql, array $params = []): array
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}
