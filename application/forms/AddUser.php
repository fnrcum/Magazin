<?php
class Default_Form_AddUser extends Zend_Form
{
	function init(){
		$this->setMethod('post');
                $this->setAction('/user/index/');
		$this->addAttribs(array('id'=>'formUser', 'class'=>'4'));        

		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Email');
                $email->addValidator('EmailAddress',  TRUE  );
                $email->addErrorMessage('Invalid email address!');
		$email->setAttribs(array('class'=>'input-req text large required validate[required,custom[email]]'));
		$email->setRequired(true);
		$this->addElement($email);
                
                $password = new Zend_Form_Element_Password('password');
		$password->setLabel('Password');
		$password->setAttribs(array('class'=>'input-req text large required validate[required]'));
		$password->setRequired(true);
		$this->addElement($password);
		
		$nume = new Zend_Form_Element_Text('nume');
		$nume->setLabel('Nume Complet');
		$nume->setAttribs(array('class'=>'input-nreq text large required'));
		$nume->setRequired(false);
		$this->addElement($nume);
		
                $adresa = new Zend_Form_Element_Textarea('adresa');
		$adresa->setLabel('Adresa');
		$adresa->setAttribs(array('class'=>'input-nreq-ad text large required ',
                    'cols'=>"40", 
                    'rows'=>"40"));
		$adresa->setRequired(FALSE);
		$this->addElement($adresa);
                
                $nr = new Zend_Form_Element_Text('tel');
		$nr->setLabel('Numar de Telefon');
		$nr->setAttribs(array('class'=>'input-req text large required validate[required,custom[onlyNumber],minSize[10],maxSize[10]]'));
		$nr->setRequired(TRUE);
		$this->addElement($nr);
		
                $firma = new Zend_Form_Element_Text('firma');
		$firma->setLabel('Firma');
		$firma->setAttribs(array('class'=>'input-req text large required validate[required]'));
		$firma->setRequired(true);
		$this->addElement($firma);
                
                $label = new Zend_Form_Element_Text('label');
		$label->setLabel('Cod de verificare');
		$label->setAttribs(array('class'=>'input-req text large required validate[required]'));
		$label->setRequired(false);
		$this->addElement($label);
                
                $captcha = new Zend_Form_Element_Captcha('captcha', array(
                    //'label' => "Cod de verificare",
                    'name'=>'captcha',
                    'captcha' => 'image',
                    'captchaOptions' => array(
                        'captcha' => 'image',
                        'wordLen' => 6,
                        'timeout' => 300,
                        'font' => '/home/nicu/arial_narrow_7.ttf',
                        'fontSize' => '22',
                        'wordLen' => 5,
                        'height' => '40',
                        'width' => '129',
                        'imgDir' => APPLICATION_PATH.'/../public/captcha',
                        'imgUrl' => Zend_Controller_Front::getInstance()->getBaseUrl().'/captcha',
                        'dotNoiseLevel' => 30,
                        'lineNoiseLevel' => 2,
                        'messages' => array(
                        'badCaptcha' => 'Invalid captcha')
                        ),
                ));
                $captcha->setAttribs(array('class'=>'error bullet captcha validate[required]'));
                $this->addElement($captcha);


                
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setValue('CREAZA CONT');
		$submit->setAttribs(array('class'=>'reg-btn submit tsSubmitLogin fL','style'=>'margin: 5px 0 0 20px;'));
		$submit->setIgnore(true);
		$this->addElement($submit);		
	}
	
	
}
