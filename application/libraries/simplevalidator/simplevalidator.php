<?php namespace SimpleValidator;
/**
 * Validator class based on anonymous functions.
 *
 * @see http://php.net/manual/en/functions.anonymous.php
 */
class SimpleValidator
{
	public $errors;

	/**
	 * Validate the given array of data using the functions set
	 *
	 * @param array $data to validate
	 * @return array
	 */
	public function __invoke(array $data)
	{
		unset($this->errors);

		$errors = array();
		foreach((array) $this as $key => $function)
		{
			$value = NULL;

			if(isset($data[$key]))
			{
				$value = $data[$key];
			}

			$error = $function($value, $key, $this);

			if($error)
			{
				$errors[$key] = $error;
			}
		}

		$this->errors = $errors;
		return ! $errors;
	}


	/**
	 * Return the validator errors
	 *
	 * @return array
	 */
	public function errors()
	{
		return $this->errors;
	}
}
