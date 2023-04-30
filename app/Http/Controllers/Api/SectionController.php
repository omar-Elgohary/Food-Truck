<?php
namespace App\Http\Controllers\Api;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class SectionController extends Controller
{
    use ApiResponseTrait;

    public function allSections()
    {
        try{
            $sections = Section::all();
            return $this->returnData(200, 'Sections Fetched Successfully', $sections);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Sections Fetched Failed');
        }
    }
    
    public function addSection(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|unique:sections',
            ]);

            $section = Section::create([
                'name' => $request->name,
            ]);
            return $this->returnData(200, 'Section Added Successfully', $section);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Section Add Failed');
        }
    }



    public function editSection(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required|unique:sections',
            ]);
            $section = Section::find($id);
            $section->name = $request->name;
            $section->save();
            return $this->returnData(200, 'Section Edited Successfully', $section);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, 'Section Edit Failed');
        }
    }
}
