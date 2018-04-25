<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function home() {
	
		if($this->request->is('post')) {
            //check empty
            if(!empty($this->request->data)) {
				
				$limit = 10;				
				$insta_source = file_get_contents('https://instagram.com/'.$this->request->data['Contact']['username']);
				$shards = explode('window._sharedData = ', $insta_source);
				$insta_json = explode(';</script>', $shards[1]);
				$insta_array = json_decode($insta_json[0], TRUE);

				$data = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];

				$i = 0;
				$array = array();
				foreach ($data as $item) {
					if (!isset($item['node']['thumbnail_src']))
						continue;
					$array[$i]['date'] = $item['node']['taken_at_timestamp'];
					$array[$i]['text'] = isset($item['node']['edge_media_to_caption']['edges'][0]['node']['text']) ? $item['node']['edge_media_to_caption']['edges'][0]['node']['text'] : '';

					// use 150x150, fallback to 640x640
					$array[$i]['image'] = isset($item['node']['thumbnail_resources'][0]['src']) ? $item['node']['thumbnail_resources'][0]['src'] : $item['node']['thumbnail_src'];

					$array[$i]['link'] = "https://instagram.com/p/" . $item['node']['shortcode'];
					$array[$i]['username'] = $item['node']['id'];
					$array[$i]['_feed_source'] = 'instagram';

					if (++$i >= $limit) {
						break;
					}
				}
							
				//pr($array); die; 
				$instagram_feed_data =  $array;
				$this->set(compact('instagram_feed_data'));
			}
		}			
	}
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
