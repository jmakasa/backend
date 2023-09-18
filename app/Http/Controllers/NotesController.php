<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use App\Models\TicketNotes;
use App\Models\Mentioned;
use App\Models\Employees;
use App\Models\TicketThreads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;
use App\Services\EmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use File;

use App\Http\Controllers\MentionedController as MentionedCtrl;

class NotesController extends Controller
{

    public function __construct()
    {
        //   $this->middleware('auth', ['except' => ['getBlogsList']]);
        //ini_set('memory_limit', '2048M');
    }


    /**
     * add notes
     * return json 
     * 
     */
    public function addTicketNote($locale, Request $request,MentionedCtrl $mentionedCtrl)
    {
        $result = ['result' => false];
        try {
            $this->validate(
                $request,
                [
                    'tickets_id' => 'required',
                    'content' => 'required',
                ],
                [
                    'tickets_id.required' => 'Ticket ID is required.',
                    'content.required' => 'Content is required.',
                ]
            );

            logger()->debug(" addTicketNote : " . var_export($request->all(), true));

            //class="img-fluid"
            //style=".*;"

            $content =  preg_replace('/width.*px;/', '', $request->get('content'));
            $content = str_replace("<img", '<img class="img-fluid" ', $content);
            
            $request->merge([
                'content' => $content,
            ]);
            $threadNotes = (new TicketNotes)
                ->validateAndFill($request->all())
                ->setAttribute('status', TicketNotes::STATUS_ACTIVE);
                $threadNotes->save();
            if ($threadNotes) {
                logger()->debug(" addTicketNote : inserted " . var_export($threadNotes, true));

                // handle mentioned
                if (!empty($request->get('mentioned'))){
                    // check mentioned
                    $mentionedEmployees = Employees::whereIn('id',$request->get('mentioned'))->with('inDepartments')->get();
                    logger()->debug(" addTicketNote get employees has been mentioned : " . var_export($mentionedEmployees, true));
                    foreach ($mentionedEmployees as $mentionedEmploy){
                        //MentionedCtrl
                        $data = [
                            'employees_id' => $mentionedEmploy->id,
                            'type' => Mentioned::TYPE_TICKET_NOTE,
                            'type_id' => $threadNotes->id,
                        ];
                        $request = new Request($data);
                        $newMentioned = $mentionedCtrl->addMentioned($request);
                       logger()->debug(" addTicketNote add mentioned " . var_export($newMentioned, true));
                    }
                }
                return response()->json(['result' => true, 'data' => $threadNotes]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            logger()->error(" addTicketNote " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    /***
     * delete note
     */
    public function deleteTicketNote($locale, Request $request){
        $result = ['result' => false];
        try {
            $this->validate(
                $request,
                ['id' => 'required',],
                ['id.required' => 'ID is required.',]
            );

            logger()->debug(" deleteTicketNote : " . var_export($request->all(), true));

            $note=TicketNotes::whereId($request->get('id'));

            if ($note->delete()) {
                return response()->json(['result' => true, 'data' => $note]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            logger()->error(" deleteTicketNote " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }

    }

    /***
     * edit note
     */
    public function editTicketNote($locale, Request $request){
        $result = ['result' => false];
        try {
            $this->validate(
                $request,
                ['id' => 'required','content' => 'required',],
                ['id.required' => 'ID is required.', 'content.required' => 'Content is required.',]
            );

            logger()->debug(" editTicketNote : " . var_export($request->all(), true));

            $note=TicketNotes::whereId($request->get('id'));
            $note->content = $request->get('content');

            if ($note->save()) {
                return response()->json(['result' => true, 'data' => $note]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            logger()->error(" editTicketNote " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }



    public function getNotesByTicketId($locale, Request $request)
    {
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            return response()->json($result);
        }
        logger()->debug(" getNotesByTicketId : " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'Ticket ID is required.',
                ]
            );
            $ticketNotes = TicketNotes::where('tickets_id', $request->get('id'))->orderBy("created_at", "asc")->get()->toArray();
            logger()->debug(" ticketNotes : " . var_export($ticketNotes, true));
            return response()->json(['result' => true, 'data' => $ticketNotes]);
        } catch (ValidationException $ex) {
            logger()->error(" getNotesByTicketId " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }
}
