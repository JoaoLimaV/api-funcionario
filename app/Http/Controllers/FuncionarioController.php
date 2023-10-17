<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;

use App\Mail\EmailController;

class FuncionarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $model;  

    public function __construct(Funcionario $func)
    {   
        $this->model = $func;  
    }

    public function teste(){
        return "Request PUT";
    }
}

