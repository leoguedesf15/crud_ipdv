<?php
namespace app\model\dao;
interface IDAO{
    function selectAll();
    function where($condition);
    function orderBy($arrayOrderBy);
    function get();
    function execute();
}
?>