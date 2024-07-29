<?php

namespace App\Http\Controllers;

use App\Models\CompanyFinancials;
use Illuminate\Http\Request;

class CompanyFinancialsController extends Controller
{
    public function index()
    {
        $financials = CompanyFinancials::get();
        return view('index', ['financials' => $financials]);
    }

    public function edit($id)
    {
        $financials = CompanyFinancials::findOrFail($id);
        return view('edit', compact('financials'));
    }

    public function update(Request $request, $id)
    {
        $financials = CompanyFinancials::findOrFail($id);

        if (($request->value != $financials->value && $request->due_date < date('Y-m-d')) || 
            ($request->due_date < date('Y-m-d') && (float) $request->fees != (float) $financials->fees)) 
        {
            $newValue = (float) $request->value * (1 + ((float) $request->fees / 100));
        }

        $financialsData = [
            'company_name' => $request->company_name,
            'email' => $request->email,
            'cnpj' => $request->cnpj,
            'bar_code' => $request->bar_code,
            'value' => $newValue ?? $request->value,
            'due_date' => date('Y-m-d', strtotime($request->due_date)),
            'fees' => (float) $request->fees,
        ];      
    
        $financials->update($financialsData);
    
        return redirect()->route('index') 
            ->with('success', 'Dados atualizados com sucesso!');
    }

    public function delete($id)
    {
        $financials = CompanyFinancials::findOrFail($id);

        $financials->delete();

        return redirect()->route('index') 
            ->with('success', 'Dados excluídos com sucesso!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ],[
            'file.required' => 'O campo arquivo é obrigatório.',
            'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV.',
            'file.max' => 'Tamanho do arquivo execede :max Mb.'
        ]);

        $headers = [
            'NOME FANTASIA',
            'EMAIL',
            'CNPJ',
            'CODIGO DE BARRAS',
            'VALOR',
            'VENCIMENTO',
            'JUROS',
        ];

        $filePath = $request->file('file')->getRealPath();
        $file = fopen($filePath, 'r');

        $financialsData = [];
        $registerNumber = 0;
        $emailRegistered = false;
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ',')) !== false) {
            if ($row === $headers) {
                continue;
            }
        
            $rowArray = [];
            foreach ($headers as $key => $header) {

                $rowArray[$header] = $row[$key] ?? null;

                switch ($header) {
                    case 'EMAIL':
                        if(CompanyFinancials::where('email', $rowArray[$header])->first()){
                            $emailRegistered .= $rowArray[$header] . ", ";
                        }
                        break;
                    case 'VENCIMENTO':
                        $rowArray[$header] = date('Y-m-d', strtotime($rowArray[$header]));
                        break;
                    case 'JUROS':
                        $rowArray[$header] = (float) $rowArray[$header];
                        break;
                    case 'VALOR':
                        $rowArray[$header] = (float) $rowArray[$header];
                        break;
                }                
            }
            $registerNumber++;
            $financialsData[] = $rowArray;
        }

        if($emailRegistered){
            return back()->with('error', 'Dados não importados. Existem e-mails já cadastrados.:<br> ' . $emailRegistered);
        }

        $financialsData = $this->mappedDataFinancials($financialsData);
        $financialsData = $this->updateBillValue($financialsData);

        CompanyFinancials::insert($financialsData);

        fclose($file);

        return redirect()->route('index')->with('success', 'Dados importados com sucesso. Total de registros importados: ' . $registerNumber);
    }

    public function updateBillValue(array $financialsData)
    {
        foreach ($financialsData as $key => $value) {
            if($value['due_date'] < date('Y-m-d')){
                $financialsData[$key]['value'] = floatval($value['value']) * (1 + ($value['fees'] / 100));
            }
        }

        return $financialsData;
    }

    public function mappedDataFinancials(array $financialsData)
    {
        $data = [];

        foreach ($financialsData as $value) {
            $mappedData = [
                'company_name' => $value['NOME FANTASIA'],
                'email' => $value['EMAIL'],
                'cnpj' => $value['CNPJ'],
                'bar_code' => $value['CODIGO DE BARRAS'],
                'value' => (float) $value['VALOR'],
                'due_date' => $value['VENCIMENTO'],
                'fees' => (float) $value['JUROS'],
            ];
        
            $data[] = $mappedData;
        }

        return $data;
    }
}
