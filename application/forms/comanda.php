<?php
class Default_Form_Comanda extends Zend_Form
{
	function init(){
		$this->setMethod('post');
                $this->setAction('/cos/comanda/');
		$this->addAttribs(array('id'=>'formUser', 'class'=>'4'));        

                $contact = new Zend_Form_Element_Text('contact');
		$contact->setLabel('Persoana de contact:');
		$contact->setAttribs(array('class'=>'input text large required validate[required]'));
		$contact->setRequired(true);
		$this->addElement($contact);
                
		$username = new Zend_Form_Element_Text('email');
		$username->setLabel('Email:');
		$username->setAttribs(array('class'=>'input text large required validate[required,custom[email]]'));
		$username->setRequired(true);
		$this->addElement($username);
		
		$password = new Zend_Form_Element_Text('tel');
		$password->setLabel('Telefon:');
		$password->setAttribs(array('class'=>'input text large required validate[required,custom[onlyNumber],minSize[10],maxSize[10]]'));
		$password->setRequired(true);
		$this->addElement($password);
                
                $adresa = new Zend_Form_Element_Textarea('adresa');
		$adresa->setLabel('Adresa:');
		$adresa->setAttribs(array('class'=>'rr input text large required validate[required]'));
		$adresa->setRequired(true);
		$this->addElement($adresa);
                
                $true = new Zend_Form_Element_Checkbox('true');
		$true->setLabel('Am citit termenii si conditiile si sunt deacord cu acestea.:');
		$true->setAttribs(array('class'=>'input text large required validate[required]'));
		$true->setRequired(true);
		$this->addElement($true);

		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setValue('TRIMITE COMANDA');
		$submit->setAttribs(array('class'=>'rr submit tsSubmitLogin fL btn'));
		$submit->setIgnore(true);
		$this->addElement($submit);		
	}
	
	
}
