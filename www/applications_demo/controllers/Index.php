<?php
/*================================================================
 *  File Name：Index.php
 *  Author：carlziess, chengmo9292@126.com
 *  Create Date：2018-06-12 10:43:24
 *  Description：
 *  Controller不做任何的实际业务逻辑处理，业务逻辑由Service完成以此实现代码级复用。
 ===============================================================*/
class IndexController extends Controller
{

    public function beforeInit()
    {
        Yaf\Registry::set('responseType','json'); 
    }

    public function indexAction()
    {
        echo 'hello,world';
    }

    /**
     * 新增/编辑
     * @param array $args 
     * @return json
     * @description 支持Json入参
     */
    public function saveAction()
    {
        if (true === Request::getInstance()->isPost()) {
            $args = 'application/json' === Request::getInstance()->getContentType() ? json_decode(Request::getInstance()->getRawBody(), true) : $this->getRequest()->getPost();  
            if (empty($args['params'])) {
                throw new Exception('请求参数无效', 400);
            }
            $result =  (new CommonCompanyService())->save($args['params']);
            Response::getInstance()->send($result);  
        }
        throw new Exception('请求无效', 400);
    }

    public function getAction()
    {
        if (true === Request::getInstance()->isPost()) {
            $args = 'application/json' === Request::getInstance()->getContentType() ? json_decode(Request::getInstance()->getRawBody(), true) : $this->getRequest()->getPost();  
        }


    }

    public function queryAction()
    {
        if (true === Request::getInstance()->isPost()) {
            $args = 'application/json' === Request::getInstance()->getContentType() ? json_decode(Request::getInstance()->getRawBody(), true) : $this->getRequest()->getPost();  
        }



    }

    public function deleteAction()
    {
        if (true === Request::getInstance()->isPost()) {
            $args = 'application/json' === Request::getInstance()->getContentType() ? json_decode(Request::getInstance()->getRawBody(), true) : $this->getRequest()->getPost();  
        }



    }

}

