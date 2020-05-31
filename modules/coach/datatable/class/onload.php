<?php
include('../db.php');
include('function.php');

$output = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $statement = $connection->prepare(
        "SELECT CC.clc_name, CC.clc_id
        FROM tbl_staffclass SC
        INNER JOIN tbl_classcategory CC ON SC.clc_id = CC.clc_id
        WHERE SC.stf_id = $id"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    
    $output['list_nav'] = '';
    foreach($result as $category){
        $clc_id = $category['clc_id'];
        
        $statement2 = $connection->prepare(
            "SELECT C.cls_name, C.cls_id
            FROM tbl_staffclass SC
            INNER JOIN tbl_classcategory CC ON SC.clc_id = CC.clc_id
            INNER JOIN tbl_class C ON CC.clc_id = C.clc_id
            WHERE SC.stf_id = $id AND CC.clc_id = $clc_id
            ORDER BY cls_name ASC"
        );
        $statement2->execute();
        $result2 = $statement2->fetchAll();

        $output['list_nav'] .= '<ul class="list-nav"><h4>'.$category['clc_name'].'</h4>';
        foreach($result2 as $row){
            $output['list_nav'] .= '<a href="index.php?mod=class&sub='.$row['cls_id'].'"><li>'.$row['cls_name'].'</li></a>';
        }
        $output['list_nav'] .= '</ul>';
    }
    
    if(isset($_POST['cls_id'])){
        if($_POST['cls_id'] == '')
            $output['cls_name'] = 'Classes > Select A Class';
        else
            $output['cls_name'] = 'Classes > '.get_classname($_POST['cls_id']);
    }
        
}

echo json_encode($output);