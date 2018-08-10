<?php

require_once ('../intr-sdk-test/autoload.php');

function countBudgetSuccessLeads($api, $dateFrom, $dateTo) {

	$crm_user_id = null; // int[] | фильтр по id ответственного
	$status = array(142); // int[] | фильтр по id статуса
	$budget = 0;

	try {
	    $result = $api->lead->getAll($crm_user_id, $status);
	    foreach ($result['result'] as $key => $value) {
	    	if ( ($value['date_close'] >= $dateFrom) && ($value['date_close'] <= $dateTo) && ( !is_null($value['price']) ) ) {
	            $budget += (int)$value['price'];
	    	}
	    }
	    return $budget;
	} catch (Exception $e) {
	    $data = array('Exception when calling lead->getAll: ', $e->getMessage(), PHP_EOL);
		file_put_contents('log.txt', $data, FILE_APPEND | LOCK_EX);
	    return -1;
	}
} // Бюджет за определенный период времени

function getClients() {
    return [
        [
            'id' => 1,
            'name' => 'CLIENT_NAME',
            'api' => 'API_KEY',
        ]
    ];
} // Получение списка клиентов

$dateFrom = htmlspecialchars($_GET['date_from']);
$dateTo = htmlspecialchars($_GET['date_to']);
$clients = getClients();

echo '<table>' . 
		'<tr>' .
			'<th>ID клиента в Ядре</th>' .
			'<th>Название клиента</th>' .
			'<th>Сумма сделок клиента за период</th>' .
		'</tr>';
foreach ($clients as $value) {
	Introvert\Configuration::getDefaultConfiguration()->setApiKey('key', $value['api']);

	$api = new Introvert\ApiClient();
	$budget = 0; $totalBudget = 0;

	try {
	   	$result = $api->account->info();
	    if (!is_null($result)) {
	    	$budget = countBudgetSuccessLeads($api, $dateFrom, $dateTo);
	    	$totalBudget += $budget;
			echo 
				'<tr>' . 
					'<td>' . $value['id'] . '</td>' .
					'<td>' . $value['name'] . '</td>' .
					'<td>' . $budget . '</td>' .
			 	'<tr>';
	    }
	} catch (Exception $e) {
		$data = array('Exception when calling account->info: ', $e->getMessage(), PHP_EOL);
		file_put_contents('log.txt', $data, FILE_APPEND | LOCK_EX);
	}
}
echo '</table>';

echo '<br>Сумма по всем клиентам за период: ' . $totalBudget;
