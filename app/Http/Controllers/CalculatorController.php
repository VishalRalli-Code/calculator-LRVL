<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'num1' => 'required|numeric',
            'num2' => 'required|numeric',
            'operation' => 'required|in:add,subtract,multiply,divide'
        ]);

        $num1 = $request->num1;
        $num2 = $request->num2;
        $operation = $request->operation;
        $result = null;
        $error = null;

        switch ($operation) {
            case 'add':
                $result = $num1 + $num2;
                break;
            case 'subtract':
                $result = $num1 - $num2;
                break;
            case 'multiply':
                $result = $num1 * $num2;
                break;
            case 'divide':
                if ($num2 == 0) {
                    $error = 'Cannot divide by zero';
                } else {
                    $result = $num1 / $num2;
                }
                break;
        }

        return response()->json([
            'result' => $result,
            'error' => $error
        ]);
    }
}