<?php
class Form_GuestBook extends Zend_Form {
	public function init() {
		//configura pra form enviado via POST
		$this->setMethod('post');
		
		//adiciona um elemento de email
		$this->addElement('text', 'email', array(
												'label' => 'Seu endereço de e-mail:',
												'required' => true,
												'filters' => array('StringTrim'),
												'validators' => array('EmailAddress')
		));
		
		//adiciona o elemento comentário
		$this->addElement('textarea', 'comment', array(
													'label' => 'Por favor, comente:',
													'required' => true,
													'validators' => array('validator' => 'StringLength', 'options' => array(0,20))
		));
		
		//adiciona CAPTCHA
		$this->addElement('captcha', 'captcha', array(
													'label' => 'Por favor entre com as cinco letras exibidas abaixo:',
													'required' => true,
													'captcha' => array('captcha' => 'Figlet', 'wordLen' => 5, 'timeout' => 300)
		));
		
		//adiciona o botão de submissão
		$this->addElement('submit', 'submit', array(
												'label' => 'Assinar Guestbook',
		));
	}
}
?>