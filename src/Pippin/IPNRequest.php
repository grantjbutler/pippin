<?php

namespace Pippin;

use Illuminate\Foundation\Http\FormRequest;

use Pippin\IPNValidator;
use Pippin\IPNParser;

class IPNRequest extends FormRequest {

	private $ipnValidator;

	private $IPN;

	public function __construct(IPNValidator $ipnValidator) {
		$this->ipnValidator = $ipnValidator;
	}

	public function authorize() {
		if ($this->getMethod() != 'POST') {
			return false;
		}

		$postData = $this->getContent();
		$isValid = $this->ipnValidator->isValidIPN($postData);

		if ($isValid) {
			$parser = new IPNParser();
			$this->IPN = $parser->parse($postData);

			$isValid = count($this->IPN->getTransactions()) >= 0;
		}

		return $isValid;
	}

	public function getIPN() {
		return $this->IPN;
	}
	
	public function rules() {
		return [];
	}

}
