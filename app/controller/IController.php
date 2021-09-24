<?php
namespace app\controller;
interface IController{
    function index();
    function show($id);
    function update($id);
    function destroy($id);
    function create();
}
?>