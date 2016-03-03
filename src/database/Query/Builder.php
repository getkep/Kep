<?php

namespace KepPHP\Kep\database\Query;

use KepPHP\Kep\database\Connection;

class Builder
{
    /**
     * @acess private
     *
     * @var string
     */
    private $table;

    /**
     * @acess private
     *
     * @var string
     */
    private $create;

    /**
     * @acess private
     *
     * @var array
     */
    private $conn;

    /**
     * @acess private
     *
     * @var array
     */
    private $return;

    /**
     * Responsavel por guarda a nome da tabela desejada a efetuar a ação futura.
     *
     * @acess public
     *
     * @return $this
     */
    public function index($table)
    {
        $this->table = (string) $table;

        return $this;
    }

    /**
     * Seleciona as informações da tabela desejada de acordo o informado.
     *
     * @acess public
     *
     * @return array
     */
    public function select($select = '*')
    {
        $this->create = "SELECT {$select} FROM {$this->table}";
        $this->wrapSelect();

        return $this->return;
    }

    /**
     * COUNT seleciona informações da tabela e mostra o resultado.
     *
     * @acess public
     *
     * @return array
     */
    public function count($count = '*')
    {
        $this->create = "SELECT COUNT({$count}) As Result FROM {$this->table}";
        $this->wrapSelect();

        return $this->return;
    }

    /**
     * Responsavel por embrulhar as informações para serem retorandas.
     *
     * @acess private
     *
     * @return $this
     */
    private function wrapSelect()
    {
        $this->execute();
        $this->return[] = ['fetch_array' => $this->return->fetch_array(MYSQLI_ASSOC)];
        $this->return[] = ['num_rows' => $this->conn->num_rows];
        $this->disconnect();

        return $this;
    }

    /**
     * Realiza o update na tabela.
     *
     * @acess public
     *
     * @return array
     */
    public function update(array $set)
    {
        $Places = implode(' = , ', array_keys($set));
        $Fields = implode(' = , ', array_values($set)).' = ';

        $this->create = "UPDATE {$this->table} SET {$Fields}{$Places}";

        return $this->create;
    }

    /**
     * Responsavel por embrulhar as informações para serem retorandas.
     *
     * @acess private
     *
     * @return array
     */
    private function wrapUpdate()
    {
        $this->execute();
        $this->return[] = ['affected_rows' => $this->conn->affected_rows];
        $this->disconnect();

        return $this;
    }

    /**
     * Insere dados na tabela.
     *
     * @acss public
     *
     * @return array
     */
    public function insert(array $values)
    {
        $Places = implode(', ', array_keys($values));
        $Fields = "'".implode("', '", array_values($values))."'";

        $this->create = "INSERT INTO {$this->table}({$Places}) VALUES({$Fields})";
        $this->wrapInsert();

        return $this->return;
    }

    /**
     * Responsavel por embrulhar as informações para serem retorandas.
     *
     * @acess private
     *
     * @return $this
     */
    private function wrapInsert()
    {
        $this->execute();
        $this->return[] = ['insert_id' => $this->conn->insert_id];
        $this->return[] = ['affected_rows' => $this->conn->affected_rows];
        $this->disconnect();

        return $this;
    }

    /**
     * Deleta a tabela desejada.
     *
     * @acess public
     *
     * @return array
     */
    public function delete()
    {
        $this->create = "DELETE FROM {$this->table}";
        $this->wrapDelete();

        return $this->return;
    }

    /**
     * Responsavel por embrulhar as informações para serem retorandas.
     *
     * @acess private
     *
     * @return $this
     */
    private function wrapDelete()
    {
        $this->execute();
        $this->return[] = ['affected_rows' => $this->conn->affected_rows];
        $this->disconnect();

        return $this;
    }

    /**
     * Responsavel por delimitar os dados;.
     *
     * @acess public
     *
     * @return $this
     */
    public function where(array $where = null)
    {
        $Fileds = implode(' = :, ', array_keys($where)).' = :';
        $Places = implode(' = , ', array_keys($where));
        $this->create = $this->create." WHERE {$Fileds}{$Places} ";

        return $this;
    }

    /**
     * Responsavel por limitar a quantidade de dados.
     *
     * @acess public
     *
     * @return $this
     */
    public function limit($limit = null)
    {
        $this->create = $this->create." LIMIT {$limit} ";

        return $this;
    }

    /**
     * Responsavel por ordenar os dados recebidos.
     *
     * @acess public
     *
     * @return $this
     */
    public function order($order = null)
    {
        $this->create = $this->create." ORDER BY {$order} ";

        return $this;
    }

    /**
     * Efetua a conexão com banco de dados.
     *
     * @acess private
     *
     * @return array
     */
    private function connect()
    {
        $this->conn = new Connection();
        $this->conn = $this->conn->mysqli();
    }

    /**
     * Executa a query.
     *
     * @acess private
     *
     * @return array
     */
    private function execute()
    {
        $this->connect();
        $this->return = $this->conn->query($this->create);

        return $this;
    }

    /**
     * Fecha conexão com o banco de dados.
     *
     * @acess private
     *
     * @return void
     */
    private function disconnect()
    {
        return $this->conn->close();
    }
}
