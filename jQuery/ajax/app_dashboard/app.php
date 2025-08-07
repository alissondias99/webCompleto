<?php
class Dashboard
{
    public $data_inicio;
    public $data_fim;
    public $numeroVendas;
    public $totalVendas;
    public $clienteAtivo;
    public $clienteInativo;
    public $totalElogios;
    public $totalReclamacao;
    public $totalDespesa;
    public $totalSugestao;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $valor){
        $this->$attr = $valor;
        return $this;
    }
}

class Conexao
{
    private $host = 'localhost';
    private $dbname = 'dashboard';
    private $user = 'root';
    private $pass = '';

    public function conectar(){
        try {

            $conexao = new PDO(
                "mysql:host=$this->host; 
                dbname=$this->dbname",
                "$this->user",
                "$this->pass"
            );

            return $conexao;
        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }
}

class Bd
{
    private $conexao;
    private $dashBoard;

    public function __construct(Conexao $conexao, Dashboard $dashBoard){
        $this->conexao = $conexao->conectar();
        $this->dashBoard = $dashBoard;
    }

    public function getNumeroVendas(){

        $query = 'SELECT
                     COUNT(*) as numero_vendas 
                     from tb_vendas 
                     where data_venda BETWEEN :data_inicio and :data_fim';

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashBoard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashBoard->__get('data_fim'));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;
    }

    public function getTotalVendas(){

        $query = 'SELECT
                     sum(total) as total_vendas 
                     from tb_vendas 
                     where data_venda BETWEEN :data_inicio and :data_fim';

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashBoard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashBoard->__get('data_fim'));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;
    }

    public function getclienteAtivo(){

        $query = 'SELECT
                     count(cliente_ativo) as total_clientes_ativos 
                     from tb_clientes 
                     where cliente_ativo =1';

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_clientes_ativos;
    }

    public function getclienteInativo()
    {

        $query = 'SELECT
                     count(cliente_ativo) as total_clientes_inativos 
                     from tb_clientes 
                     where cliente_ativo != 1';

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_clientes_inativos;
    }

    public function getTotalReclamacao()
    {

        $query = 'SELECT
                     count(tipo_contato) as total_reclamacao
                     from tb_contatos 
                     where tipo_contato = 1';

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_reclamacao;
    }

    public function getTotalElogio()
    {

        $query = 'SELECT
                     count(tipo_contato) as total_elogio
                     from tb_contatos 
                     where tipo_contato = 2';

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_elogio;
    }

    public function getTotalSugestao()
    {

        $query = 'SELECT
                     count(tipo_contato) as total_sugestao
                     from tb_contatos 
                     where tipo_contato = 3';

        $stmt = $this->conexao->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_sugestao;
    }

   

    public function getTotalDespesas(){

        $query = 'SELECT
                     sum(total) as total_despesas
                     from tb_despesas
                      where data_despesa BETWEEN :data_inicio and :data_fim';

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio', $this->dashBoard->__get('data_inicio'));
        $stmt->bindValue(':data_fim', $this->dashBoard->__get('data_fim'));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->total_despesas;
    }
}

$dashBoard = new Dashboard();
$conexao = new Conexao();
$bd = new Bd($conexao, $dashBoard);

$competencia = explode('-', $_GET['competencia']);
$ano = $competencia[0];
$mes = $competencia[1];

$dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

$dashBoard->__set('data_inicio', $ano.'-'.$mes.'-01');
$dashBoard->__set('data_fim', $ano.'-'.$mes.'-'.$dias_do_mes);

$dashBoard->__set('numeroVendas', $bd->getNumeroVendas());
$dashBoard->__set('totalVendas', $bd->getTotalVendas());

$dashBoard->__set('clienteAtivo', $bd->getclienteAtivo());
$dashBoard->__set('clienteInativo', $bd->getclienteInativo());

$dashBoard->__set('total_reclamacao', $bd->getTotalReclamacao());
$dashBoard->__set('total_elogio', $bd->getTotalElogio());
$dashBoard->__set('total_sugestao', $bd->getTotalSugestao());


$dashBoard->__set('total_despesas', $bd->getTotalDespesas());

echo json_encode($dashBoard);