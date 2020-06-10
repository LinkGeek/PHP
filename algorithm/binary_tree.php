<?php

class TreeNode{
    var $val;
    var $left = NULL;
    var $right = NULL;
    function __construct($val){
        $this->val = $val;
    }
}

class Test {

    private $pRoot = null;

    /**
     * 构建二叉树测试数据
     */
    public function __construct()
    {
        $this->pRoot = new TreeNode(3);
        $node1 = new TreeNode(9);
        $node2 = new TreeNode(2);
        $node3 = new TreeNode(1);
        $node4 = new TreeNode(7);

        $this->pRoot->left  = $node1;
        $this->pRoot->right = $node2;
        $node2->left  = $node3;
        $node2->right = $node4;
    }

    /**
     * 计算树的深度
     */
    function treeDepth()
    {
        $res = 0;            // 树的深度
        $queue[] = $this->pRoot;   // 存放每层的节点，初始化为根节点

        while (!empty($queue)) {
            $tmp = [];       // 临时存放当前层的下一层的所有节点
            foreach ($queue as $k) {
                if ($k->left != NULL) $tmp[] = $k->left;
                if ($k->right != NULL) $tmp[] = $k->right;
            }

            $queue = $tmp;   // 当前层往下一层走
            $res++;          // 记录层数
        }

        return $res;
    }
}

$obj = new Test();
$result = $obj->treeDepth();
var_dump($result);




