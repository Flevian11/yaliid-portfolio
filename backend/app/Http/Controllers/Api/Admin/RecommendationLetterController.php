<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\RecommendationLetter; use Illuminate\Http\Request;
class RecommendationLetterController extends Controller {
 public function index(){return response()->json(RecommendationLetter::with('experience')->latest()->paginate(50));}
 public function store(Request $request){$data=$request->validate(['experience_id'=>'nullable|exists:experiences,id','title'=>'required|string|max:190','issuer_name'=>'nullable|string|max:150','issuer_position'=>'nullable|string|max:150','issuer_organization'=>'nullable|string|max:190','issue_date'=>'nullable|date','description'=>'nullable|string','is_published'=>'boolean','file'=>'required|file|mimes:pdf,doc,docx|max:10240']);$file=$request->file('file');$data['file_path']=$file->store('recommendation-letters','public');$data['file_name']=$file->getClientOriginalName();$data['mime_type']=$file->getMimeType();$data['file_size']=$file->getSize();unset($data['file']);return response()->json(RecommendationLetter::create($data),201);}
 public function destroy($id){RecommendationLetter::findOrFail($id)->delete();return response()->noContent();}
}
