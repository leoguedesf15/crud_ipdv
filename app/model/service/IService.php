<?php
namespace app\model\service;
interface IService{
    public static function all();
    public static function find($id);
    public static function update($id, $payload);
    public static function validaPayload($payload);
    public static function destroy($id);
    public static function create($payload);
}
?>