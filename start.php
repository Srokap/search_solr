<?php
function search_solr_get_config() {
	$config = array(
		'endpoint' => array(
			'localhost' => array(
				'host' => '127.0.0.1',
				'port' => 8983,
				'path' => '/solr/',
			)
		)
	);
	return $config;
}

function search_solr_init() {
	$client = new Solarium\Client(search_solr_get_config());
	
	$ping = $client->createPing();
	
	try{
		$mt = microtime(true);
		$result = $client->ping($ping);
		FB::log(microtime(true)-$mt);
		FB::log('Ping query successful');
		FB::log($result->getData());
	}catch(Solarium\Exception $e){
		FB::log('Ping query failed1');
	} catch(Solarium\Exception\HttpException $e){
		FB::log('Ping query failed2: '.$e->getMessage());
	}
}

elgg_register_event_handler('init', 'system', 'search_solr_init');