<?php
class Default_Form_CosAdd extends Zend_Form
{
	function init(){
		$this->setMethod('post');
                $this->setAction('/index/index/');
		$this->addAttribs(array('id'=>'formUser', 'class'=>'4'));        

		$username = new Zend_Form_Element_Number('email');
		$username->setLabel('Email:');
		$username->setAttribs(array('class'=>'input text large required validate[required,custom[email]]'));
		$username->setRequired(true);
		$this->addElement($username);
		
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Parola:');
		$password->setAttribs(array('class'=>'input text large required validate[required]'));
		$password->setRequired(true);
		$this->addElement($password);

		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setValue('AUTENTIFICARE');
		$submit->setAttribs(array('class'=>'submit tsSubmitLogin fL btn'));
		$submit->setIgnore(true);
		$this->addElement($submit);		
	}
	
	
}
