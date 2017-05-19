<?php
class Magedoc_Like_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
//        $this->loadLayout()->renderLayout();
        echo "It's action for likes output";

    }

    public function addLikeAction()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, TRUE);

        $addmodel = Mage::getModel('like/adding')->addLike($data['product_Id']);

        if ($addmodel) {
            $record = Mage::getModel('like/like')->getResource()->getLikesRecord($data['product_Id'], $data['store_Id']);
            if ($record) {
                $mod = Mage::getModel('like/like')->load($record['id']);
                $mod->setData('like_count', $record['like_count']+1)->save();
                echo $record['like_count']+1;
            } else {
                $data = array('product_id'=> $data['product_Id'],'store_id' => $data['store_Id'], 'like_count' => 1);
                $model = Mage::getModel('like/like')->setData($data)->save();
                echo 1;
            }
        } else {
            echo 0;
        }
    }
}
