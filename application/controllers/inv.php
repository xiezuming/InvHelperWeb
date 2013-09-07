<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property Inv_item_model $inv_item_model
 * @property Inv_user_model $inv_user_model
*/
class Inv extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('inv_item_model');
		$this->load->model('inv_user_model');
	}

	public function get_user()
	{
		$user = $this->inv_user_model->get_user($this->input->post('userName'));
		$data['result'] = $user ? 1 : 0;
		if ($user) {
			unset($user['password']);
			$data['data'] = $user;
		} else {
			$data['message'] = 'The user does not exist.';
		}

		echo json_encode($data);
	}

	public function add_item()
	{
		$input_data = $this->get_input_data();
		$data['result'] = $this->inv_item_model->add_inv_item($input_data) ? 1 : 0;
		echo json_encode($data);
	}

	public function add_item_page()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['field_names'] = $this->get_field_names();
		$this->load->view('inv/add', $data);
	}

	private function get_field_names() {
		$field_names = array(
				"userId"	=>	"userId",
				"itemId"	=>	"itemId",
				"title"		=>	"title",
				"barcode"	=>	"barcode",
				"category"	=>	"category",
				"condition"	=>	"condition",
				"price"		=>	"price",
				"quantity"	=>	"quantity",
				"size"		=>	"size",
				"weight"	=>	"weight",
				"latitude"	=>	"latitude",
				"longitude"	=>	"longitude",
				"desc"		=>	"desc",
				"photoname1"=>	"photoname1",
				"photoname2"=>	"photoname2",
				"photoname3"=>	"photoname3",
				"createDate"=>	"createDate",
				"updateDate"=>	"updateDate",
		);
		return $field_names;
	}

	private function get_input_data() {
		$input_data = array();
		foreach ($this->get_field_names() as $field_name) {
			$field_value = $this->input->post($field_name);
			if (empty($field_value)) {
				$input_data[$field_name] = NULL;
			} else {
				// change
				if ($this->endsWith($field_name, 'Date')) {
					$field_value = date('Y-m-d H:i:s', $field_value);
				}
				$input_data[$field_name] = $field_value;
			}
		}
		return $input_data;
	}

	private function endsWith($haystack, $needle)
	{
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}
}

?>
