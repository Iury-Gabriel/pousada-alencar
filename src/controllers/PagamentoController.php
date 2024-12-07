<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Pagamento;

class PagamentoController extends Controller {
    public function inserirPagamento($reservas_id, $cliente_id, $status_pagamento, $data_pagamento, $valor_pago, $metodo_pagamento) {
        $pagamento = new Pagamento(0, $reservas_id, $cliente_id, $status_pagamento, $data_pagamento, $valor_pago, $metodo_pagamento);
        $pagamento->inserirPagamento();
    }
}