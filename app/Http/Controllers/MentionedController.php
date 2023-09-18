<?php

namespace App\Http\Controllers;

use App\Models\TicketNotes;
use App\Models\Mentioned;
use App\Models\Employees;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class MentionedController extends Controller
{

    public function __construct()
    {
        //   $this->middleware('auth', ['except' => ['getBlogsList']]);
        //ini_set('memory_limit', '2048M');
    }


    /**
     * add mentioned 
     * 
     * 
     */
    public function addMentioned(Request $request)
    {
        $result = ['result' => false];
        try {
            $this->validate(
                $request,
                [
                    'employees_id' => 'required',
                    'type' => 'required',
                    'type_id' => 'required',
                    
                ],
                [
                    'employees_id.required' => 'Employees ID is required.',
                    'type.required' => 'Type is required.',
                    'type_id.required' => 'Type ID is required.',
                ]
            );

            logger()->debug(" addMentioned : " . var_export($request->all(), true));


            $newMentioned = (new Mentioned)
                ->validateAndFill($request->all());
            return   $newMentioned->save();

        } catch (ValidationException $ex) {
            logger()->error(" addMentioned " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }



    public function getMentionedByEmployeesId($locale, Request $request)
    {
        $result = ['result' => false];
        // if (!$this->hasLoginFromMarketing()) {
        //     return response()->json($result);
        // }
        // logger()->debug(" getNotesByTicketId : " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'users_id' => 'required',
                ],
                [
                    'users_id.required' => 'Users ID is required.',
                ]
            );
            // find the employee_id
            $employId = Employees::where("users_id",$request->get('users_id'))->pluck('id')->first();

            $Mentioned = Mentioned::where('employees_id', $employId)->orderBy("created_at", "desc");
            if ($request->get('type')){
                $Mentioned->where('type',$request->get('type'));
            }
            $aryMentioneds = $Mentioned->get()->toArray();
            $resultData = [];
            foreach ($aryMentioneds as $key => $mention){
                if ($mention['type'] == Mentioned::TYPE_TICKET_NOTE){
                    $aryMentioneds[$key]['data'] = TicketNotes::whereId($mention['type_id'])->with("ticket")->first();
                    // $ticketNotes = TicketNotes::where('tickets_id',$aryMentioneds[$key]['data']['tickets_id'])->orderBy('id','asc')->get();
                    // $cntIdx = 0;
                    // foreach ($ticketNotes as $note){
                    //     $cntIdx++;
                    //     if ($note->id ==$mention['type_id']){
                    //         break;
                    //     }
                    // }
                    // $aryMentioneds[$key]['collapse_idx'] = $cntIdx;
                }
            }
            return response()->json(['total' => count($aryMentioneds), 'rows' => $aryMentioneds]);
        } catch (ValidationException $ex) {
            logger()->error(" getMentionedByEmployeesId " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    

    public function list(){

    }
}
