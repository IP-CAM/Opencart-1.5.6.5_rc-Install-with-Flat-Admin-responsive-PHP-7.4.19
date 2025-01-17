<?php
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ControllerModulepavblogcomment 
 */
class ControllerModulepavblogcomment extends Controller {
	private $error = array(); 
	
	public function index() {   
		
		$this->language->load('module/pavblogcomment');
		
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
	

			$this->model_setting_setting->editSetting('pavblogcomment', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_content_bottom_2'] = $this->language->get('text_content_bottom_2');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['entry_banner'] = $this->language->get('entry_banner');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension'); 
		$this->data['entry_carousel'] = $this->language->get('entry_carousel'); 
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['blog_manage_link'] = $this->url->link('module/pavblog', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['positions'] = array( 'mainmenu',
										  'slideshow',
										  'promotion',
										  'content_top',
										  'column_left',
										  'column_right',
										  'content_bottom',
										  'content_bottom_2',
										  'footer_top',
										  'footer_center',
										  'footer_bottom'
		);
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['dimension'])) {
			$this->data['error_dimension'] = $this->error['dimension'];
		} else {
			$this->data['error_dimension'] = array();
		}
		$this->data['entry_tabs'] = $this->language->get('entry_tabs');
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/pavblogcomment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/pavblogcomment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['pavblogcomment_module'])) {
			$this->data['modules'] = $this->request->post['pavblogcomment_module'];
		} elseif ($this->config->get('pavblogcomment_module')) { 
			$this->data['modules'] = $this->config->get('pavblogcomment_module');
		}	
						
		$this->load->model('design/layout');
		$this->load->model('localisation/language');
		$this->data['tab_module'] = $this->language->get('tab_module');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['layouts'] = array();
		$this->data['layouts'][] = array('layout_id'=>99999, 'name' => $this->language->get('all_page') );
		
		$this->data['layouts'] = array_merge($this->data['layouts'],$this->model_design_layout->getLayouts());

		$this->load->model('design/banner');
		$this->data['token'] = $this->session->data['token'];

		$this->data['banners'] = $this->model_design_banner->getBanners();
		$tabs = array(
			'latest' 	 => $this->language->get('text_latest'),
			'featured'   => $this->language->get('text_featured'),
			
			'mostviewed' => $this->language->get('text_mostviewed')
		);	
		
		$this->data['tabs'] = $tabs;
		$this->template = 'module/pavblogcomment.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/pavblogcomment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['pavblogcomment_module'])) {
			foreach ($this->request->post['pavblogcomment_module'] as $key => $value) {
				 

				if (!$value['limit']     ) {
					$this->error['dimension'][$key] = $this->language->get('error_carousel');
				}			
			}
		}	
						
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
