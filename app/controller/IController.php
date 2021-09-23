<?php
namespace app\controller;
interface IController{
    function index();
    function show($params);
    function update($params);
    function destroy($params);

}
?>