<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\WebEmailContactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\EmailService;
use Illuminate\Validation\ValidationException;

use Exception;
use Redirect;


class TasksController extends Controller
{
    public function __construct()
    {
        //     $this->middleware('auth', ['except' => ['getFormSettings','getList']]);
    }

    public function addTask($locale, Request $request)
    {
    }

    public function fetchEmailContactus($locale)
    {

        // get WebEmailContactus tasks_id = 0
        $getEmailContactus = WebEmailContactus::where("tasks_id", WebEmailContactus::TASK_AWAIT)->get();

        /***
         * insert into tasks and update tasks_id WebEmailContactus
         */
        foreach ($getEmailContactus as $emailContactus) {

            // new task
           // $loginUser = $this->loginUser();
            $newTask = Tasks::firstOrNew(['email_id' => $emailContactus->id]);
            // if ($emailContactus->get('parent_task_id') != 'NULL') {
            //     $newTask->parent_task_id = $emailContactus->get('parent_task_id');
            // }

            $newTask->subject = $this->shortenSubject($emailContactus->subject);
            $newTask->content = $emailContactus->description;
            $newTask->attachment = $emailContactus->attachments;
            $newTask->start_datetime = $emailContactus->start_datetime;
            $newTask->due_datetime = $emailContactus->due_datetime;
            $newTask->task_desc = $emailContactus->task_desc;
            //  $newTask->remarks = $request->get('remarks');
            // the email which from client request or enquire
            $newTask->from_firstname = $emailContactus->firstname;
            $newTask->from_lastname = $emailContactus->lastname;
            $newTask->from_email = $emailContactus->email;

            // $newTask->assignor = $loginUser['username'];
            // $arAssignee = $request->get('assignee');
            // $newTask->assignee = $arAssignee['email'];
            $newTask->type = 'Email enquires';
            $newTask->status = Tasks::STATUS_OPEN;

            // TODO :: get account_contact_id the id assoicate to account table
            //  $newTask->account_contact_id = $request->get('account_contact_id');

            if ($newTask->save()) {
                logger()->debug(" newTask - Store data : SAVED " . var_export($newTask, true));
                $emailContactus->tasks_id = $newTask->id;
                $emailContactus->save();
            }
        }
    }

    
    /**
     *  return json of task status
     */
    public function getFormSettings()
    {
        $arySetting['status'] = [
            ['value' => Tasks::STATUS_OPEN],
            ['value' => Tasks::STATUS_PRIOR],
            ['value' => Tasks::STATUS_IN_PROGRESS],
            ['value' => Tasks::STATUS_REVIEW],
            ['value' => Tasks::STATUS_CLOSED],
            ['value' => Tasks::STATUS_REOPEN]
        ];

        $arySetting['assignees'] = [
            ['name' => 'David Tai', 'email' => 'wmtai@akasa.co.uk'],
            ['name' => 'Yitsen Chen', 'email' => 'yitsen@akasa.co.uk'],
            ['name' => 'Ivan', 'email' => 'ivan@akasa.co.uk'],
            ['name' => 'Bernardo Costa', 'email' => 'bernardo@akasa.co.uk'],
            ['name' => 'Phoebe', 'email' => 'phoebe@akasa.co.uk'],
            ['name' => 'Ashley Wang', 'email' => 'ashleywang@akasa.co.uk'],
            ['name' => 'Tony', 'email' => 'tony@akasa.co.uk'],
            ['name' => 'Charya Long', 'email' => 'maggie@akasa.co.uk'],
            ['name' => 'Justin Mak', 'email' => 'jmtest2211@outlook.com'],
            // ['name' => 'Justin Mak','email'=> 'justin@akasa.co.uk'],

            //     ['name' => 'Calvin','email'=> 'calvin@akasa.co.uk'],
        ];
        return response()->json($arySetting);
    }

    /**
     * add new tasks
     * post
     */
    public function addNewTask($locale, Request $request, EmailService $emailService)
    {
        Logger()->debug(" addNewTask : data " . var_export($request->all(), true));
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            return response()->json($result);
        }
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'task_desc' => 'required',
                    'assignee' => 'required',
                    'start_datetime' => 'required',
                    'tstatus' => 'required',
                    'submitting' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',
                    'task_desc.required' => 'Task Description is required.',
                    'assignee.required' => 'Assignee is required.',
                    'start_datetime.required' => 'Start date is required.',
                    'tstatus' => 'Status is required',
                    'submitting.required' => 'Form is not valid.',

                ]
            );
            $loginUser = $this->loginUser();
            $newTask = Tasks::firstOrNew(['email_id' => $request->get('id')]);
            if ($request->get('parent_task_id')) {
                $newTask->parent_task_id = $request->get('parent_task_id');
            }

            $newTask->subject = $request->get('subject');
            $newTask->content = $request->get('description');
            $newTask->attachment = $request->get('attachments');
            $newTask->start_datetime = $request->get('start_datetime');
            $newTask->due_datetime = $request->get('due_datetime');
            $newTask->task_desc = $request->get('task_desc');
            //  $newTask->remarks = $request->get('remarks');
            // the email which from client request or enquire
            $newTask->from_firstname = $request->get('firstname');
            $newTask->from_lastname = $request->get('lastname');
            $newTask->from_email = $request->get('email');

            $newTask->assignor = $loginUser['username'];
            $arAssignee = $request->get('assignee');
            $newTask->assignee = $arAssignee['email'];
            $newTask->type = 'Email enquires';

            $aryStatus = $request->get('tstatus');
            $newTask->status = $aryStatus['value'];

            // TODO :: get account_contact_id the id assoicate to account table
            $newTask->account_contact_id = $request->get('account_contact_id');

            if ($newTask->save()) {
                // send notification to assignee
                $aryNotice = [
                    'name' => $arAssignee['name'],
                    'email' => $arAssignee['email'],
                    'subject' => 'New Task is assigned - ' . $newTask->subject,
                    'link' => route('cs.taskDetail', ['locale' => $locale, 'id' => $newTask->id]),
                ];
                $sendNotice = $emailService->taskNotification($aryNotice);
                logger()->debug(" newTask -send notice return : " . var_export($sendNotice, true));
                logger()->debug(" newTask - Store data : SAVED " . var_export($request->all(), true));
                $result = ['result' => true, 'data' => $newTask];
            } else {
                logger()->error(" newTask - Store data : failed to save " . var_export($request->all(), true));
            }

            return response()->json($result);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /**
     * update task desc, status, due_datetime
     */
    public function updateDetail($locale, Request $request)
    {
        Logger()->debug(" updateTaskDetail : data " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'task_desc' => 'required',
                    'tstatus' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',
                    'task_desc.required' => 'Task Description is required.',
                    'tstatus' => 'Status is required',
                ]
            );
            $loginUser = $this->loginUser();
            $task = Tasks::whereId($request->get('id'))->first();

            $task->task_desc = $request->get('task_desc');
            $aryStatus = $request->get('tstatus');
            $task->status = $aryStatus['value'];

            $task->due_datetime = ($request->get('due_datetime') != 'NULL' ? $request->get('due_datetime') : '');
            $task->updated_by = $loginUser['username'];
            if ($task->save()) {
                logger()->debug(" updateTaskDetail - Store data : SAVED " . var_export($request->all(), true));
                $result = ['result' => true, 'data' => $task];
            } else {
                logger()->error(" updateTaskDetail - Store data : failed to save " . var_export($request->all(), true));
            }
            return response()->json($result);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getList($locale, Request $request)
    {
        $sort = $request->has('sort') ? $request->get('sort') : 'created_at';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $lang = $request->has('lang') ? $request->get('lang') : 'en';
        $skip = ($page - 1) * $rows;


        $tasks = Tasks::orderBy($sort, $order)->skip($skip)->take($rows);
        $result['total'] = Tasks::all()->count();
        $result['rows'] = $tasks->get();

        return response()->json($result);
    }

    /**
     * view page of task detail
     */
    public function viewDetailById($locale, $id, Request $request)
    {
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            // redirect to login
            $currenturl = $request->url();

            //   dd($currenturl);
            $host = request()->getHttpHost();
            $url = "http://" . $host . "/marketing/login.php?returnUrl=" . $currenturl;
            return Redirect::to($url);
        }
        try {
            $title = "TASK";
            return view('backend.customerServices.taskDetail', compact('id', 'title'));
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        }
    }

    /**
     * return json
     */
    public function getDetailById($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'email ID is required.',
                ]
            );
            $result['result'] = false;

            $task = Tasks::where('id', $request->get('id'))->first();
            if ($task) {
                $result['result'] = true;
                $result['data'] = $task;
            }

            return response()->json($result);
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        }
    }

    public function testNotice($locale, $id, EmailService $emailService)
    {
        // send notification to assignee
        $aryNotice = [
            'name' => 'Justin Mak',
            //'email' => 'justin@akasa.co.uk',
            'email' => 'jmtest2211@outlook.com',
            //'email' => 'makjustin@protonmail.com',


            'subject' => 'New Task is assigned - ',
            'link' => route('cs.taskDetail', ['locale' => $locale, 'id' => $id]),
        ];
        return $emailService->taskNotification($aryNotice);
    }

    /**
     * function to shorten subject
     */
    public function shortenSubject($subject)
    {
        $aryStr = [
            [
                'find_str' => 'RMA Related',
                'replace_str' => 'RR'
            ],
            [
                'find_str' => 'Technical Support',
                'replace_str' => 'TS'
            ],
            [
                'find_str' => 'Press Inquiries',
                'replace_str' => 'PI'
            ],
            [
                'find_str' => 'Reseller and Distribution',
                'replace_str' => 'RAD'
            ],
            [
                'find_str' => 'Others',
                'replace_str' => 'OT'
            ],

        ];
        foreach ($aryStr as $str){
            $subject = str_replace($str['find_str'], $str['replace_str'], $subject);
        }
        return $subject;
    }


}
