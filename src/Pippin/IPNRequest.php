<?php

namespace Pippin;

use Illuminate\Foundation\Http\FormRequest;

use Pippin\IPNValidator;
use Pippin\IPNParser;

class IPNRequest extends FormRequest {

	private $validator;

	private $IPN;

	public function __construct(IPNValidator $validator) {
		$this->validator = $validator;
	}

	public function authorize() {
		if ($this->getMethod() != 'POST') {
			return false;
		}

		$postData = $this->getContent();
		$isValid = $this->validator->isValidIPN($postData);

		if ($isValid) {
			$parser = new IPNParser();
			$this->IPN = $parser->parse($postData);
		}

		return $isValid;
	}

	public function getIPN() {
		return $this->IPN;
	}

}
