<?php
namespace app\model\service;
interface IService{
    public function all();
    public function find($id);
    public function update($id, $payload);
    public function validaPayload($payload);
    public function destroy($id);
    public function create($payload);
}
?>