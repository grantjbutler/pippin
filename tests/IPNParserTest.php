<?php

use Pippin\IPNParser;

use PHPUnit\Framework\TestCase;

class IPNParserTest extends TestCase {

	function testParserParsesIPN() {
		$parser = new IPNParser();
		$ipn = $parser->parse('mc_gross=19.95&protection_eligibility=Eligible&address_status=confirmed&payer_id=LPLWNMTBWMFAY&tax=0.00&address_street=1+Main+St&payment_date=20%3A12%3A59+Jan+13%2C+2009+PST&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=Test&mc_fee=0.88&address_country_code=US&address_name=Test+User&notify_version=2.6&custom=&payer_status=verified&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=AtkOfCXbDm2hu0ZELryHFjY-Vb7PAUvS6nMXgysbElEn9v-1XcmSoGtf&payer_email=gpmac_1231902590_per%40paypal.com&txn_id=61E67681CH3238416&payment_type=instant&last_name=User&address_state=CA&receiver_email=gpmac_1231902686_biz%40paypal.com&payment_fee=0.88&receiver_id=S8XGHLYDW9T3S&txn_type=express_checkout&item_name=&mc_currency=USD&item_number=&residence_country=US&test_ipn=1&handling_amount=0.00&transaction_subject=&payment_gross=19.95&shipping=0.00');
		$ipnData = $ipn->getData();

		$this->assertNotNull($ipnData);
		$this->assertEquals($ipnData['mc_gross'], '19.95');
		$this->assertEquals($ipnData['protection_eligibility'], 'Eligible');
		$this->assertEquals($ipnData['address_status'], 'confirmed');
		$this->assertEquals($ipnData['payer_id'], 'LPLWNMTBWMFAY');
		$this->assertEquals($ipnData['tax'], '0.00');
		$this->assertEquals($ipnData['address_street'], '1 Main St');
		$this->assertEquals($ipnData['payment_date'], '20:12:59 Jan 13, 2009 PST');
		$this->assertEquals($ipnData['payment_status'], 'Completed');
		$this->assertEquals($ipnData['charset'], 'windows-1252');
		$this->assertEquals($ipnData['address_zip'], '95131');
		$this->assertEquals($ipnData['first_name'], 'Test');
		$this->assertEquals($ipnData['mc_fee'], '0.88');
		$this->assertEquals($ipnData['address_country_code'], 'US');
		$this->assertEquals($ipnData['address_name'], 'Test User');
		$this->assertEquals($ipnData['notify_version'], '2.6');
		$this->assertEquals($ipnData['custom'], '');
		$this->assertEquals($ipnData['payer_status'], 'verified');
		$this->assertEquals($ipnData['address_country'], 'United States');
		$this->assertEquals($ipnData['address_city'], 'San Jose');
		$this->assertEquals($ipnData['quantity'], '1');
		$this->assertEquals($ipnData['verify_sign'], 'AtkOfCXbDm2hu0ZELryHFjY-Vb7PAUvS6nMXgysbElEn9v-1XcmSoGtf');
		$this->assertEquals($ipnData['payer_email'], 'gpmac_1231902590_per@paypal.com');
		$this->assertEquals($ipnData['txn_id'], '61E67681CH3238416');
		$this->assertEquals($ipnData['payment_type'], 'instant');
		$this->assertEquals($ipnData['last_name'], 'User');
		$this->assertEquals($ipnData['address_state'], 'CA');
		$this->assertEquals($ipnData['receiver_email'], 'gpmac_1231902686_biz@paypal.com');
		$this->assertEquals($ipnData['payment_fee'], '0.88');
		$this->assertEquals($ipnData['receiver_id'], 'S8XGHLYDW9T3S');
		$this->assertEquals($ipnData['txn_type'], 'express_checkout');
		$this->assertEquals($ipnData['item_name'], '');
		$this->assertEquals($ipnData['mc_currency'], 'USD');
		$this->assertEquals($ipnData['item_number'], '');
		$this->assertEquals($ipnData['residence_country'], 'US');
		$this->assertEquals($ipnData['test_ipn'], '1');
		$this->assertEquals($ipnData['handling_amount'], '0.00');
		$this->assertEquals($ipnData['transaction_subject'], '');
		$this->assertEquals($ipnData['payment_gross'], '19.95');
		$this->assertEquals($ipnData['shipping'], '0.00');

		$transactions = $ipn->getTransactions();
		$this->assertEquals(count($transactions), 1);
		
		$transaction = $transactions[0];
		$this->assertEquals($transaction->getID(), '61E67681CH3238416');
		$this->assertEquals($transaction->getStatus(), 'Completed');
		$this->assertEquals($transaction->getReceiver(), 'gpmac_1231902686_biz@paypal.com');
		$this->assertEquals($transaction->getAmount(), '19.95');
		$this->assertEquals($transaction->getCurrency(), 'USD');
	}

	function testParserConvertsToUTF8() {
		$parser = new IPNParser();
		$ipn = $parser->parse('mc_gross=19.95&protection_eligibility=Eligible&address_status=confirmed&payer_id=LPLWNMTBWMFAY&tax=0.00&address_street=1+Main+St&payment_date=20%3A12%3A59+Jan+13%2C+2009+PST&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=%DFTest&mc_fee=0.88&address_country_code=US&address_name=Test+User&notify_version=2.6&custom=&payer_status=verified&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=AtkOfCXbDm2hu0ZELryHFjY-Vb7PAUvS6nMXgysbElEn9v-1XcmSoGtf&payer_email=gpmac_1231902590_per%40paypal.com&txn_id=61E67681CH3238416&payment_type=instant&last_name=User&address_state=CA&receiver_email=gpmac_1231902686_biz%40paypal.com&payment_fee=0.88&receiver_id=S8XGHLYDW9T3S&txn_type=express_checkout&item_name=&mc_currency=USD&item_number=&residence_country=US&test_ipn=1&handling_amount=0.00&transaction_subject=&payment_gross=19.95&shipping=0.00');
		$ipnData = $ipn->getData();

		$this->assertNotNull($ipnData);
		$this->assertEquals($ipnData['mc_gross'], '19.95');
		$this->assertEquals($ipnData['protection_eligibility'], 'Eligible');
		$this->assertEquals($ipnData['address_status'], 'confirmed');
		$this->assertEquals($ipnData['payer_id'], 'LPLWNMTBWMFAY');
		$this->assertEquals($ipnData['tax'], '0.00');
		$this->assertEquals($ipnData['address_street'], '1 Main St');
		$this->assertEquals($ipnData['payment_date'], '20:12:59 Jan 13, 2009 PST');
		$this->assertEquals($ipnData['payment_status'], 'Completed');
		$this->assertEquals($ipnData['charset'], 'windows-1252');
		$this->assertEquals($ipnData['address_zip'], '95131');
		$this->assertEquals($ipnData['first_name'], 'ßTest');
		$this->assertEquals($ipnData['mc_fee'], '0.88');
		$this->assertEquals($ipnData['address_country_code'], 'US');
		$this->assertEquals($ipnData['address_name'], 'Test User');
		$this->assertEquals($ipnData['notify_version'], '2.6');
		$this->assertEquals($ipnData['custom'], '');
		$this->assertEquals($ipnData['payer_status'], 'verified');
		$this->assertEquals($ipnData['address_country'], 'United States');
		$this->assertEquals($ipnData['address_city'], 'San Jose');
		$this->assertEquals($ipnData['quantity'], '1');
		$this->assertEquals($ipnData['verify_sign'], 'AtkOfCXbDm2hu0ZELryHFjY-Vb7PAUvS6nMXgysbElEn9v-1XcmSoGtf');
		$this->assertEquals($ipnData['payer_email'], 'gpmac_1231902590_per@paypal.com');
		$this->assertEquals($ipnData['txn_id'], '61E67681CH3238416');
		$this->assertEquals($ipnData['payment_type'], 'instant');
		$this->assertEquals($ipnData['last_name'], 'User');
		$this->assertEquals($ipnData['address_state'], 'CA');
		$this->assertEquals($ipnData['receiver_email'], 'gpmac_1231902686_biz@paypal.com');
		$this->assertEquals($ipnData['payment_fee'], '0.88');
		$this->assertEquals($ipnData['receiver_id'], 'S8XGHLYDW9T3S');
		$this->assertEquals($ipnData['txn_type'], 'express_checkout');
		$this->assertEquals($ipnData['item_name'], '');
		$this->assertEquals($ipnData['mc_currency'], 'USD');
		$this->assertEquals($ipnData['item_number'], '');
		$this->assertEquals($ipnData['residence_country'], 'US');
		$this->assertEquals($ipnData['test_ipn'], '1');
		$this->assertEquals($ipnData['handling_amount'], '0.00');
		$this->assertEquals($ipnData['transaction_subject'], '');
		$this->assertEquals($ipnData['payment_gross'], '19.95');
		$this->assertEquals($ipnData['shipping'], '0.00');

		$transactions = $ipn->getTransactions();
		$this->assertEquals(count($transactions), 1);
		
		$transaction = $transactions[0];
		$this->assertEquals($transaction->getID(), '61E67681CH3238416');
		$this->assertEquals($transaction->getStatus(), 'Completed');
		$this->assertEquals($transaction->getReceiver(), 'gpmac_1231902686_biz@paypal.com');
		$this->assertEquals($transaction->getAmount(), '19.95');
		$this->assertEquals($transaction->getCurrency(), 'USD');
	}

}
