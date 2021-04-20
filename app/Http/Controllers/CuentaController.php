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
            \Log::info("El nombre es obligatorio ");
        }

        if(empty($saldo)) {
            $code = 500;
            $errores[] = 'El saldo es obligatorio';

            \Log::info("El saldo es obligatorio ");
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
                \Log::info("Error al crear la cuenta ");
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
            \Log::info("numero de cuenta invalido " . $numeroCuenta);
        }


        if(empty($valorConsignar)) {
            $code = 500;
            $errores[] = 'valor a aconsignar invalido';

            \Log::info("valor a aconsignar invalido " . $numeroCuenta);
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
                    \Log::info("error al crear la consignacion " . $numeroCuenta);
                }
            }else{
                $code = 500;
                $errores[] = 'Esta cuenta no existe';
                \Log::info("error Esta cuenta no existe " . $numeroCuenta);
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

            \Log::info("error numero de cuenta invalido");
        }

        if(empty($valor)){
            $code = 500;
            $errores[] = 'valor a retirar invalido';

            \Log::info("error valor a retirar invalido");
        }

        if(empty($errores)){

            $cuenta = Cuenta::where('numero_cuenta',$numeroCuenta)->first();

            if(!empty($cuenta)){
                
                if($cuenta->saldo < $valor){
                    $code = 500;
                    $errores[] = 'Su saldo es insuficiente';

                    \Log::info("Error saldo insuficiente " . $numeroCuenta);

                }

                if(empty($errores)){
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

                    \Log::info("Guarda retiro de dinero " . $numeroCuenta);
                }
            }else {
                $code = 500;
                $errores[] = 'Esta cuenta no existe';

                \Log::info("error la cuenta no existe " . $numeroCuenta);
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

            \Log::info("error numero de cuenta invalido");
        }
        $saldo = null;
        if(empty($errores)) {
            $cuenta = Cuenta::where('numero_cuenta',$numeroCuenta)->first();
            if(!empty($cuenta)) {
                $saldo = $cuenta->saldo;
            }else {
                $errores[] = 'Esta cuenta no existe';
                $code = 500;
                \Log::info("error Esta cuenta no existe " . $numeroCuenta);
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
