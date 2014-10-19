<?php
class EmailForm extends CFormModel {
	public $action;
	
	public $existingEmails;
	
	public $emails;
	
	public $id;
	
	public function rules() {
		return array(
			array('action, emails, id', 'safe'),
		);
	}
	
	public function populate($post) {
		$this->attributes = $post['EmailForm'];
		
		if (isset($post['Email'])) {
			$this->emails = array();
			foreach($post['Email'] as $idx=>$value) {
				$email = new Email();
				$email->email_address = $value['email_address'];
				$this->emails[] = $email;
			}
		}
	}
	
	public function init() {
		$this->existingEmails = Email::model()->findAll();
		
		$this->emails = array();
	}
	
	public function save() {
		foreach ($this->emails as $email) {
			if ($email->email_address != '') {
				$email->save();
			}
		}
		
		$this->init();
	}
	
	public function delete() {
		$email = Email::model()->findByPk($this->id);
		$email->delete();
		
		$this->init();
	}
}