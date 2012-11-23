<?php

class Mandrill
{
	const BASE_API_URL = "https://mandrillapp.com/api/1.0/";
	
	public function messages() {
		return new Mandrill_Type_Messages();
	}
	
}