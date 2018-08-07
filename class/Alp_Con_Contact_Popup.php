<?php
require_once(dirname(__FILE__).'/Alp_Con_Popup.php');

class Alp_Con_Contact_Popup extends ALPCONPopup {
	
		public $content;
		public $title;
		public $contactForm;

		public function setContent($content)
		{
			$this->content = $content;
		}

		public function getContent()
		{
			return $this->content;
		}

		public function setTitle($title){
			$this->title = $title;
		}
		public function getTitle() {
			return $this->title;
		}
	
		public function setContactForm($options)
		{
			$this->contactForm = $options;
		}
	
		public function getContactForm()
		{
			return $this->contactForm;
		}
	
		public static function create($data, $obj = null)
		{
			$obj = new self();
			$options = json_decode($data['options'], true);
			$contactForm = $options['contactForm'];
	
			$obj->setContactForm($contactForm);
			$obj->setContent($data['contact']);
	
			return parent::create($data, $obj);
		}
	
		public function save($data = array())
		{
	
			$editMode = $this->getId()?true:false;
	
			$res = parent::save($data);
			if ($res===false) return false;
	
			$alpContactForm = $this->getTitle();
			$contactForm = $this->getContactForm();
	
			global $wpdb;
			if ($editMode) {
				$alpContactForm = stripslashes($alpContactForm);
				$sql = $wpdb->prepare("UPDATE ".$wpdb->prefix."alp_con_contact_popup SET title=%s, options=%s WHERE id=%d",$alpContactForm, $contactForm, $this->getId());
				$res = $wpdb->query($sql);
			}
			else {
	
				$sql = $wpdb->prepare("INSERT INTO ".$wpdb->prefix."alp_con_contact_popup (id, title, options) VALUES (%d, %s, %s)",$this->getId(),$alpContactForm, $contactForm);
				$res = $wpdb->query($sql);
			}
			return $res;
			
		}
	
		protected function alp_setCustomOptions($id)
		{
			global $wpdb;
			$st = $wpdb->prepare("SELECT title, options FROM ".$wpdb->prefix."alp_con_contact_popup WHERE id = %d", $id);
			$arr = $wpdb->get_row($st,ARRAY_A);
			$this->setContent($arr['title']);
			$this->setContactForm($arr['options']);
		}
	
		protected function alp_getExtraRenderOptions()
		{
			$options = json_decode($this->getContactForm(), true);
	
			$firstname = $options['firstname'];			
			$middlename = $options['middlename'];
			$lastname = $options['lastname'];
			$age = $options['age'];
			$mobile = $options['mobile'];
			$gender = $options['gender'];
			$e_mail = $options['e_mail'];
			$subject = $options['subject'];
			$message = $options['message'];
			$address = $options['address'];
			$city = $options['city'];
			$pincode = $options['pincode'];
			//$content = $this->getContent();
			$content =  $this->setContactForm($arr['options']);
		
			
			$content = '<center><h2 class="html-popup-headline">Contact Form</h2></center>';
		
			if($firstname == "on"){					
				$content .= '<span class=""> First Name <input class="formfileds" type="text" name="firstname" placeholder="Enter First Name" id="firstname'.$firstname.'" value="" required/></span><br>';
			}
			if($middlename == "on"){					
				$content .= '<span class="">Middle Name <input class="formfileds" type="text" name="middlename"  placeholder="Enter Middle Name"  id="middlename'.$middlename .'" value="" /> </span><br>';
			}
			if($lastname == "on"){					
				$content .= '<span class="">Lastname Name <input class="formfileds" type="text" name="lastname"  placeholder="Enter Middle Name"  id="lastname'.$lastname .'" value="" required/> </span><br>';
			}
			if($gender == "on"){					
				$content .= '<span class="">Gender : <lable> Male <input class="" type="radio" name="gender"  value="male" checked/></lable><lable> Female <input class="" type="radio" name="gender"  value="female"/></lable> </span><br>';
			}
			if($age == "on"){					
				$content .= '<span class="">Age <input class="formfileds" type="text" name="age"  placeholder="Enter Your Age Here.!"   id="age'.$age .'" value=""/> </span><br>';
			}
			if($mobile == "on"){					
				$content .= '<span class="">Mobile <input class="formfileds" type="number" name="mobile"  placeholder="Enter Your Mobile Number Here.!" min="0"  id="mobile'.$mobile .'" value="" required /> </span><br>';
			}
			if($e_mail == "on"){					
				$content .= '<span class="">E-Mail <input class="formfileds" type="text" name="e_mail"  placeholder="Enter Your E-mail Here.!" min="0"  id="e_mail'.$e_mail .'" value="" required /> </span><br>';
			}
			if($subject == "on"){					
				$content .= '<span class="">Subject  <input class="formfileds" type="text" name="subject"  placeholder="Enter Your Subject Here.!" min="0"  id="mobile'.$mobile .'" value=""/> </span><br>';
			}
			if($message == "on"){					
				$content .= '<span class="">Message <textarea rows="3" class="formfileds" name="message"  placeholder="Enter Your Message Here.!" min="0"  id="mobile'.$mobile .'" value=""/></textara> </span><br>';
			}
			if($address == "on"){					
				$content .= '<span class="">Address <input class="formfileds" type="text" name="address"  placeholder="Enter Your Address Here.!" min="0"  id="address'.$address .'" value=""/> </span><br>';
			}			
			if($city == "on"){					
				$content .= '<span class="">City <input class="formfileds" type="text" name="city"  placeholder="Enter Your City Here.!" min="0"  id="city'.$city .'" value=""/> </span><br>';
			}
			if($pincode == "on"){					
				$content .= '<span class="">Pincode <input class="formfileds" type="text" name="pincode"  placeholder="Enter Your Pincode Here.!" min="0"  id="pincode'.$pincode .'" value=""/> </span><br>';
			}
			$content .= '<button type="submit" class="btn" value="Submit">Submit</button>';
									 
			return array('html'=>"<div class='alp-wp-editor-container'><div class='html-uploader-wrapper'><form>$content</form></div></div>");
		}

		public function render()
		{
			return parent::render();
		}
	}
	// https://www.gkids.com/wp-content/plugins/popup-builder-gold/img/