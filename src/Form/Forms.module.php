<?php
	    namespace Drupal\forms\Form;
		
		use Drupal\Core\Form\FormBase;
		use Drupal\Core\Form\FormStateInterface;

		class Forms.module extends FormBase {
			public function getFormId() {
				return 'forms_Forms.module';
			}
			public function buildForm(array $form, FormStateInterface $form_state) {
				$form['email'] = array(
					'#type' => 'email',
					'#title' => $this -> t('E-mail'),
					'#placeholder' => $this -> t('email'),
				);
				$form['text'] = array(
					'#type' => 'text',
					'#title' => $this -> t('text'),
					'#placeholder' => $this -> t('text'),
				);
				return $form;
			}
			public function validateForm(array &$form, FormStateInterface $form_state) {
			}
			public function submitForm(array &$form, FormStateInterface $form_state) {
				
				
    $email = $form_state->getValue('email');
    $firstname = $form_state->getValue('first_name');
    $lastname = $form_state->getValue('last_name');
    $url = "https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email/".$email."/?hapikey=26fac5ce-48aa-4097-91d0-cc55e7d8bbc0";
   $data = array(
      'properties' => [
        [
          'property' => 'firstname',
          'value' => $firstname
        ],
        [
          'property' => 'lastname',
          'value' => $lastname 
        ]
      ]
    );
    $json = json_encode($data,true);
    $response = \Drupal::httpClient()->post($url.'&_format=hal_json', [
      'headers' => [
        'Content-Type' => 'application/json'
      ],
        'body' => $json
    ]);
			}
		}
    
	
