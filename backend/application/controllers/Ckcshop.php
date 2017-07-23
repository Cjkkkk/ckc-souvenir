<?php
/**
 * Created by PhpStorm.
 * User: liuqingyang
 * Date: 2017/2/18
 * Time: 11:36
 */
class Ckcshop extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->load->model('simulation');
        $this->load->database();
    }

    public function login(){


        $this->load->library ( 'form_validation' );

        $this->form_validation->set_rules ( 'email', 'Email', 'required' );
        $this->form_validation->set_rules ( 'password', 'Password', 'required' );

        if ($this->form_validation->run () == FALSE) {
            //$this->load->view ( '' );
            $jsondata=["status"=>"F","message"=>"信息填写不完整"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }
        /*
        if($name == null || $pass == null){
            $this->varerror("参数匹配错误");
            return;
        }
        */
        $email = $this->input->post("email");
        $password = $this->input->post("password");


        $password1 = sha1($password);

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($user == null || $user["password"] != $password1){
            $jsondata=["status"=>"F","message"=>"用户名或密码错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $this->session->set_userdata($user);

        $jsondata=["status"=>"T","message"=>"登录成功"];
        $this->output->set_output(json_encode($jsondata));
        return;
    }



    public function register(){
        /*

         $arr = HttpUtils::parseJson();
        if(!HttpUtils::validation($arr, ["name", "sex", "description", "group_name", "imgurl", "phone", "position", "code"])){
            $this->varerror("参数匹配错误");
            return;
        }
        */


        $this->load->library ( 'form_validation' );

        $this->form_validation->set_rules ( 'email', 'Email', 'required' );
        $this->form_validation->set_rules ( 'password', 'Password', 'required' );
        $this->form_validation->set_rules ( 'confirmation', 'Password Confirmation', 'required' );
        $this->form_validation->set_rules ( 'telephone', 'Telephone', 'required' );
        $this->form_validation->set_rules ( 'address', 'Address', 'required' );
        $this->form_validation->set_rules ( 'name', 'Name', 'required' );

        if ($this->form_validation->run () == FALSE){
            $jsondata = ["status"=>"F","message"=>"信息填写不完整"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $confirmation = $this->input->post("confirmation");
        $telephone = $this->input->post("telephone");
        $address = $this->input->post("address");
        $name = $this->input->post("name");

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();



        //判断用户名是否重复
        /*
        $user = $this->user_model->get_name($arr->name);
        $this->user_model->lock();
        */

        if($user != null){
            $jsondata=["status"=>"F","message"=>"该用户名已被注册"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        if($password != $confirmation){
            $jsondata=["status"=>"F","message"=>"两次输入的密码不匹配"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }
/*
        $this->db->trans_start();
        $this->please_model->update($code);
        $this->user_model->insert($arr);
        $this->db->trans_complete();
*/

 //       $this->user_model->unlock();

        $password1 = sha1($password);

        $newperson = array (
            'email' => $email,
            'password' => $password1,
            'telephone'=>$telephone,
            'address'=>$address,
            'name'=>$name
        );

        $this->db->insert ( 'persons', $newperson );

        $jsondata=["status"=>"T","message"=>"注册成功"];
        $this->output->set_output(json_encode($jsondata));
        return;

    }



    public function update()
    {
        $email = $this->session->userdata('email');
        $id = $this->session->userdata('id');
        if($email == null){
            $jsondata=["status"=>"F","message"=>"登录超时"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($id != $user["id"]){
            $jsondata=["status"=>"F","message"=>"登录状态错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $this->load->library ( 'form_validation' );

        $this->form_validation->set_rules ( 'password', 'Password', 'required' );
        $this->form_validation->set_rules ( 'confirmation', 'Password Confirmation', 'required' );
        $this->form_validation->set_rules ( 'telephone', 'Telephone', 'required' );
        $this->form_validation->set_rules ( 'address', 'Address', 'required' );

        if ($this->form_validation->run () == FALSE){
            $jsondata=["status"=>"F","message"=>"信息填写不完整"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $password = $this->input->post("password");
        $confirmation = $this->input->post("confirmation");
        $telephone = $this->input->post("telephone");
        $address = $this->input->post("address");


        if($password !== $confirmation){
            $jsondata=["status"=>"F","message"=>"两次输入的密码不匹配"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $password1 = sha1($password);

        $newdata = array (
            'password' => $password1,
            'telephone'=>$telephone,
            'address'=>$address
        );

        $this->db->where('id', $id);
        $this->db->update('persons', $newdata);

        //$this->db->replace('table1', $data);

        $jsondata=["status"=>"T","message"=>"信息已修改"];
        $this->output->set_output(json_encode($jsondata));
        return;

    }



    public function getpersoninfo()
    {
        $email = $this->session->userdata('email');
        $id = $this->session->userdata('id');
        if($email == null){
            $jsondata=["status"=>"F","message"=>"登录超时"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($id != $user["id"]){
            $jsondata=["status"=>"F","message"=>"登录状态错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $telephone = $user["telephone"];
        $address = $user["address"];
        $name = $user["name"];
        $email = $user["email"];

        $data = array (
            'telephone'=>$telephone,
            'address'=>$address,
            'name' => $name,
            'email' => $email
        );
        $jsondata = ["data"=>$data,"status"=>"T","message"=>"个人信息"];
        $this->output->set_output(json_encode($jsondata));
        return;
    }



    public function logout()
    {
        $email = $this->session->userdata('email');
        $id = $this->session->userdata('id');
        if($email == null){
            $jsondata=["status"=>"F","message"=>"登录超时"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($id != $user["id"]){
            $jsondata=["status"=>"F","message"=>"登录状态错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $this->session->sess_destroy();
        $jsondata=["status"=>"T","message"=>"注销成功"];
        $this->output->set_output(json_encode($jsondata));
        return;
    }



    public function feedback()
    {
        $this->load->library ( 'form_validation' );

        $this->form_validation->set_rules ( 'name', 'Name', 'required' );
        $this->form_validation->set_rules ( 'email', 'Email', 'required' );
        $this->form_validation->set_rules ( 'telephone', 'Telephone', 'required' );
        $this->form_validation->set_rules ( 'comment', 'Comment', 'required' );


        if ($this->form_validation->run () == FALSE){
            $jsondata=["status"=>"F","message"=>"信息填写不完整"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $name = $this->input->post("name");
        $email = $this->input->post("email");
        $telephone = $this->input->post("telephone");
        $comment = $this->input->post("comment");

        $customer = $email . "  " .$telephone;

                        $this->load->library('email');

                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'smtp.163.com';
                        $config['smtp_user'] = 'ckcshopemail@163.com';
                        $config['smtp_pass'] = '2684ckcshop';
                        $config['mailtype'] = 'html';
                        $config['validate'] = true;
                        $config['priority'] = 1;
                        $config['crlf'] = "\r\n";
                        $config['smtp_port'] = 25;
                        $config['charset'] = 'utf-8';
                        $config['wordwrap'] = TRUE;

                        $this->email->initialize($config);

                        $this->email->from('ckcshopemail@163.com', $name);
                        $this->email->to('ckcshopemail@163.com');
                        //$this->email->cc('another@another-example.com');
                        //$this->email->bcc('them@their-example.com');

                        $this->email->subject($customer);
                        $this->email->message($comment);

                        $this->email->send();
                        echo $this->email->print_debugger();

        $jsondata=["status"=>"T","message"=>"留言已反馈"];
        $this->output->set_output(json_encode($jsondata));
        return;
    }



    public function submitcode()
    {
        /*
        $email = $this->session->userdata('email');
        $id = $this->session->userdata('id');
        if($email == null){
            $jsondata=["status"=>"F","message"=>"登录超时"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($id != $user["id"]){
            $jsondata=["status"=>"F","message"=>"登录状态错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }
*/

        do{
            $ticketid = rand(300000,399999);
            $query = $this->db->get_where('codetable', array('ticketid' => $ticketid));
            $check = $query->row_array();

        }while($check!=null);



          $this->simulation->send_post("http://shop.jiasale.com/do?action=addTicketManage",[
            "CREATE_TYPE"=>"custom",
            "NUM_CUSTOM"=>$ticketid,
            "NAME"=>$ticketid,                               //其实name好像没什么用，就起同一个名字好了
            "ticketAmount"=>"un_limited",
            "AMOUNT"=>"",
            "PAR_VALUE"=>"3",
            "IS_COMMON"=>"1",
            "PAY_MONEY"=>"",
            "TICKET_TIME"=>"day",
            "DAY"=>"15",
            "BEGIN_TIME"=>"",
            "END_TIME"=>"",
            "OK_RETURN_URL"=>"/jiasale/ticket/ticket_ok.jsp?type=add",

        ]);

    /*  表单格式参照
        CREATE_TYPE:custom
        NUM_CUSTOM:1345
        NAME:2223
        ticketAmount:un_limited
        AMOUNT:
        PAR_VALUE:155
        IS_COMMON:1
        PAY_MONEY:
        TICKET_TIME:day
        DAY:15
        BEGIN_TIME:
        END_TIME:
        OK_RETURN_URL:/jiasale/ticket/ticket_ok.jsp?type=add
    */

        $newticketid = array (
            'ticketid' => $ticketid,
            'created' => '0'
        );
        $this->db->insert ( 'codetable', $newticketid );
/*
        $result = send_get("http://shop.jiasale.com/jiasale/ticket/ticket_manage.jsp");

        preg_match_all("ticket_id\d{4}", $result, $matches);
    //    $count = sizeof($matches);
//此处与数据库进行比对
        foreach($matches as $singlematch){
            $singleid = substr($singlematch , 9 , 4);
            $query = $this->db->get_where('idtable', array('webid' => $singleid));
            $idcheck = $query->row_array();

            if($idcheck == null)
            {
                //此处模拟生成优惠券
                $newid = array(
                    'webid'=>$singleid
                );
                $this->db->insert ( 'idtable', $newid );

            }
        }
        $createddata = array(
            'created'=> '1'
        );
        $this->db->where('ticketid', $ticketid);
        $this->db->update('codetable', $createddata);

        $jsondata=["status"=>"T","message"=>"优惠码已生成"];
        $this->output->set_output(json_encode($jsondata));
        return;
        */
    }


    public function goodscomment()
    {
        $email = $this->session->userdata('email');
        $id = $this->session->userdata('id');
        if($email == null){
            $jsondata=["status"=>"F","message"=>"登录超时"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($id != $user["id"]){
            $jsondata=["status"=>"F","message"=>"登录状态错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $this->load->library ( 'form_validation' );

        $this->form_validation->set_rules ( 'goodsname', 'Goodsname', 'required' );
        $this->form_validation->set_rules ( 'name', 'Name', 'required' );
        $this->form_validation->set_rules ( 'comment', 'Comment', 'required' );

        if ($this->form_validation->run () == FALSE){
            $jsondata=["status"=>"F","message"=>"信息不完整"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        date_default_timezone_set('PRC');

        $goodsname = $this->input->post("goodsname");
        $name = $this->input->post("name");
        $comment = $this->input->post("comment");
        $time = date('y-m-d h:i:s',time());

/*
        $query = $this->db->get_where('goods', array('goodsname' => $goodsname));
        $user = $query->row_array();
*/
        $newcomment = array(
            'goodsname'=>$goodsname,
            'name'=>$name,
            'comment'=>$comment,
            'time'=>$time
        );
        $this->db->insert ( 'commenttable', $newcomment );

        $jsondata=["status"=>"T","message"=>"评论成功"];
        $this->output->set_output(json_encode($jsondata));
        return;
    }


    public function getcomment()
    {

        $goodsname = $this->input->get("goodsname");

        $query = $this->db->get_where('commenttable', array('goodsname' => $goodsname));
        $goods = $query->result_array();
 /*       foreach ($goods as $good){
            $
        }
 */
        if ($goods==null)
        {
            $jsondata=["status"=>"F","message"=>"无评论"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

/*
            $data = array(
                'email'=>$email,
                'comment'=>$comment
            );
*/

        //$count = sizeof($goods);
        $goods1 = array_reverse($goods);

        $jsondata=["data"=>$goods1,"status"=>"T","message"=>"评论获取成功"];
        $this->output->set_output(json_encode($jsondata));


        return;
    }

    public function commentreply(){

        $email = $this->session->userdata('email');
        $id = $this->session->userdata('id');
        if($email == null){
            $jsondata=["status"=>"F","message"=>"登录超时"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $query = $this->db->get_where('persons', array('email' => $email));
        $user = $query->row_array();

        if($id != $user["id"]){
            $jsondata=["status"=>"F","message"=>"登录状态错误"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $this->load->library ( 'form_validation' );

        $this->form_validation->set_rules ( 'reply', 'Goodsname', 'required' );

        if ($this->form_validation->run () == FALSE){
            $jsondata=["status"=>"F","message"=>"信息不完整"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $reply = $this->input->post("reply");
        $commentsid = $this->input->post("id");
        $name = $this->input->post("name");
        $time = $this->input->post("time");

        $newreply = array(
            'reply'=>$reply,
            'name'=>$name,
            'commentsid'=>$commentsid,
            'time'=>$time
        );
        $this->db->insert ( 'commentreply', $newreply );

        $jsondata=["status"=>"T","message"=>"回复评论成功"];
        $this->output->set_output(json_encode($jsondata));
        return;
    }

    public function getreply(){
        $commentsid = $this->input->get("commentsid");
        $query = $this->db->get_where('commentreply', array('commentsid' => $commentsid));
        $reply = $query->result_array();

        if ($reply==null)
        {
            $jsondata=["status"=>"F","message"=>"该评论无回复"];
            $this->output->set_output(json_encode($jsondata));
            return;
        }

        $jsondata=["data"=>$reply,"status"=>"T","message"=>"评论回复获取成功"];
        $this->output->set_output(json_encode($jsondata));


        return;

    }
}
