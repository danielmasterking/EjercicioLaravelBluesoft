<?php

namespace App\Http\Controllers;
use App\Cuenta;
use App\Movimientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentaController extends Controller
{
    public function CrearCuenta(Request $request) {
        $errores = [];
        $nombre = $request->post("nombre");
        $saldo = $request->post("saldo");
        $numeroCuenta = null;
        
        if(empty($nombre)) {
            $code = 500;
            $errores[] = 'El nombre es obligatorio';
        }

        if(empty($saldo)) {
            $code = 500;
            $errores[] = 'El saldo es obligatorio';
        }

        if(empty($errores)){
            $numeroCuenta = rand(1,1999999);
            $cuenta = new Cuenta;
            $cuenta->numero_cuenta = $numeroCuenta;
            $cuenta->nombre = $nombre;
            $cuenta->saldo = $saldo;

            
            if($cuenta->save()) {
                $code =200;
            }else {
                $code =500;
                $errores[] ='Error al crear la cuenta';
            }
        }

        return response()->json([
            'code' => $code ,
            'numeroCuenta' => $numeroCuenta,
            'errores' => $errores
        ]);
    }

    public function Consignar(Request $request) {
        $errores = [];
        $numeroCuenta = $request->post("numero_cuenta");
        $valorConsignar = $request->post("valor_consignar");

        if(empty($numeroCuenta)) {
            $code = 500;
            $errores[] = 'numero de cuenta invalido';
        }


        if(empty($valorConsignar)) {
            $code = 500;
            $errores[] = 'valor a aconsignar invalido';
        }

        $nuevoSaldo = null;

        if(empty($errores)){
            $cuenta = Cuenta::where('numero_cuenta',$numeroCuenta)->first();
            
            if(!empty($cuenta)) {
                $saldoActual = $cuenta->saldo;
                $nuevoSaldo = ($valorConsignar + $saldoActual);
            
            
                DB::table('cuenta')
                ->where('numero_cuenta', $numeroCuenta)
                ->update(['saldo' => $nuevoSaldo]);
                

                $movimiento = new Movimientos;
                $movimiento->numero_cuenta = $numeroCuenta;
                $movimiento->valor = $valorConsignar;
                $movimiento->tipo = 'C';

                if($movimiento->save()){
                    $code = 200;
                }else {
                    $code = 500;
                    $errores[] = 'error al crear la consignacion';
                }
            }else{
                $code = 500;
                $errores[] = 'Esta cuenta no existe';
            }
        }

        return response()->json([
            'code' => $code ,
            'numeroCuenta' => $numeroCuenta,
            'nuevoSaldo' => $nuevoSaldo,
            'errores' => $errores

        ]);
    }

    public function Retirar($numeroCuenta = '' , $valor = '') {
        $errores = [];
        $nuevoSaldo = null;
        if(empty($numeroCuenta)){
            $code = 500;
            $errores[] = 'Numero de cuenta invalido';
        }

        if(empty($valor)){
            $code = 500;
            $errores[] = 'valor a retirar invalido';
        }

        if(empty($errores)){

            $cuenta = Cuenta::where('numero_cuenta',$numeroCuenta)->first();

            if(!empty($cuenta)){
                $nuevoSaldo = ($cuenta->saldo - $valor);

                DB::table('cuenta')
                ->where('numero_cuenta', $numeroCuenta)
                ->update(['saldo' => $nuevoSaldo]);

                $movimiento = new Movimientos;
                $movimiento->numero_cuenta = $numeroCuenta;
                $movimiento->valor = $valor;
                $movimiento->tipo = 'R';

                if($movimiento->save()){
                    $code = 200;
                }else {
                    $code = 500;
                    $errores[] = 'Error al realizar el retiro';
                }
            }else {
                $code = 500;
                $errores[] = 'Esta cuenta no existe';
            }
        
        }

        return response()->json([
            'code' => $code ,
            'numeroCuenta' => $numeroCuenta,
            'nuevoSaldo' => $nuevoSaldo,
            'errores' => $errores

        ]);
    }

    public function consultarSaldo($numeroCuenta = '') {
        $errores = [];
        $code = 200;
        if(empty($numeroCuenta)) {
            $errores[] = 'numero de cuenta invalido';
            $code = 500;
        }
        $saldo = null;
        if(empty($errores)) {
            $cuenta = Cuenta::where('numero_cuenta',$numeroCuenta)->first();
            if(!empty($cuenta)) {
                $saldo = $cuenta->saldo;
            }else {
                $errores[] = 'Esta cuenta no existe';
                $code = 500;
            }
        }

        return response()->json([
            'code' => $code ,
            'numeroCuenta' => $numeroCuenta,
            'saldo' => $saldo,
            'errores' => $errores

        ]);
    }
}
