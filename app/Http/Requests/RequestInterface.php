<?php


namespace App\Http\Requests;


interface RequestInterface
{
    public function authorize() : bool;

    public function rules() : array;
}
