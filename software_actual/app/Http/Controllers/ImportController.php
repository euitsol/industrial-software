<?php

namespace App\Http\Controllers;
use App\Models\CsvData ;
use App\Models\Contact ;
use App\Models\Promotion_type ;
use App\Models\User;
use App\Models\Message ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    //

    public function getImport()
    {
        $data = Promotion_type::get();
        return view('import.index',compact('data'));
        // return $data;
    }
    public function parseImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
        
    
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));    
        if (count($data) > 0) {
            $csv_data = $data;            
        } else {
            return redirect()->back();
        }
        $promotion_type = Promotion_type::findOrFail($request->promotion_type);
        // $coloum_name = CsvData::get();
        // $columns = \Schema::getColumnListing('coloum_name');
        $product = new CsvData;
        $columns = $product->getTableColumns();
    

       // return $csv_data;

        return view('import.import_fields', compact( 'promotion_type', 'data', 'csv_data','columns'));    
    }




    public function add()
    {       
        return view('import.add');
    }
    public function save(Request $request)
    {
        $request->validate([
            'promotion_type' => 'required',
        ]);
        $save = new Promotion_type;
        $save->type = $request->promotion_type;
        $save->user_id = Auth::id();
        $save->save();
        $this->message('success', 'Promotion Type Added Successfully');
        return redirect()->route('import');
    }
    public function show($id)
    {
        $pt = Promotion_type::findOrFail($id);
        $added_by = User::findOrFail($pt->user_id);
        return view('import.show', compact('pt','added_by'));
        // return $added_by->name;
    }

    public function edit($id)
    {
        $pt = Promotion_type::findOrFail($id);
        
        return view('import.edit', compact('pt'));
        // return $added_by->name;
    }

    public function update(Request $request)
    {
        $request->validate([
            'promotion_type' => 'required',
        ]);

        $pt = Promotion_type::findOrFail($request->id);
        $pt->type = $request->promotion_type;
        $pt->save();

        $this->message('success', 'Promotion Type update successfully');
        return redirect()->route('import');
    }


    public function destroy($id)
    {
        $pt = Promotion_type::findOrFail($id);        
        $pt->delete();
        $this->message('success', 'Promotion Type deleted successfully');
        return redirect()->back();      
    }
    public function csv_save(Request $request)
    {
        
        
        $output= "";
        for( $data = 2 ; $data < $request->j ; $data++ )
        {
            $save = new CsvData;
            $colum_name = 1;
                        
            foreach($request-> $data  as $dt)
            {                              
                if($colum_name < $request->i+1 )
                {                                      
                    $find = "c".$colum_name; 
                    $colum_name++;                   
                    foreach($request->$find as $l)
                    {
                         if($l != "none")
                         {
                            if($l == "phone")
                            {
                                $phone_number = $dt;
                                if (substr($phone_number, 0, 1) == '0')
                                {
                                    $phone_number = $phone_number;
                                }
                                else
                                {
                                    $phone_number = '0'.$phone_number;
                                }
                                $save->$l = $phone_number;
                            }
                            else
                            {
                                $save->$l = $dt;
                            }
                            
                         }

                                                  
                    }
                }
            }
            $save->promotion_type_id = $request->id;
            $save->save();                       
        }
        return redirect()->route('promotion_type.sms', ['id' => $request->id]);
    }
    public function csv_info()
    {
        $data = Promotion_type::get();
        return view('sms.csv_info',compact('data'));
    }
    public function csv_info_search(Request $request)
    {
        $data = CsvData::where('promotion_type_id',$request->promotion_type)->get();       
        $product = new CsvData;
        $columns = $product->getTableColumns();
        $message_data = Message::where('promotion_type_id',$request->promotion_type)->get();
        $user_data = User::get();
        $id = $request->promotion_type;
        return view('import.new', compact('data','columns','id','message_data','user_data'));
    }
    public function csv_view($id)
    {
        $data = CsvData::where('promotion_type_id',$id)->get();       
        $product = new CsvData;
        $columns = $product->getTableColumns();
        $message_data = Message::where('promotion_type_id',$id)->get();
        $user_data = User::get();
        
        return view('sms.promotion_sms',compact('data','columns','id','message_data','user_data')) ;
    }

    public function csv_edit($id)
    {
        
        $data = CsvData::where('id',$id)->get();       
        $product = new CsvData;
        $columns = $product->getTableColumns();
        
        return view('import.csv_info_edit',compact('data','columns','id')) ;
    }
    public function csv_update(Request $request)
    {
        $product = new CsvData;
        $columns = $product->getTableColumns();
        $pt = CsvData::findOrFail($request->id);
        foreach($columns as $cl)
        {            
            $pt->$cl = $request->$cl;
        }
        $pt->promotion_type_id = $request->promotion_type_id;
        $pt->save();       
        $data = CsvData::where('promotion_type_id',$request->promotion_type_id)->get();       
        $product = new CsvData;
        $columns = $product->getTableColumns();
        $message_data = Message::where('promotion_type_id',$request->promotion_type_id)->get();
        $user_data = User::get();
        $msg = "Data Updated Successfully";
        return view('import.new', compact('data','columns','id','message_data','user_data','msg'));
    }
    public function csv_delete($id)
    {
        $pt = CsvData::findOrFail($id);
        $pt->delete();
        $data = CsvData::where('id',$id)->get();       
        $product = new CsvData;
        $columns = $product->getTableColumns();
        $message_data = Message::where('promotion_type_id',$pt->promotion_type_id)->get();
        $user_data = User::get();
        $msg = "Data Deleted Successfully";
        return view('import.new', compact('data','columns','id','message_data','user_data','msg'));
    }
    
}
