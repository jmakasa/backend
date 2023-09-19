<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\EmployeeDepartments;
use App\Models\EmployeeInDepartments;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\EmailService;
use Illuminate\Validation\ValidationException;

use Exception;
use Redirect;


class EmployeesController extends Controller
{

    protected $title;
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['getTaskFormSettings','getTaskList']]);
        // $this->middleware('auth:api', ['except' => ['getEmployeeList','getEmployeeSettings']]);
        $this->title = "Employee Portal | Backend";
    }

    /**
     *  return json of task status
     */
    public function getEmployeeSettings()
    {
        $arySetting['status'] = [
            ['value' => Employees::STATUS_ACTIVE],
            ['value' => Employees::STATUS_INACTIVE],
            ['value' => Employees::STATUS_SUSPEND],

        ];

        // departments tree
        $arySetting['departments'] = $this->aryDeptList();
        $arySetting['employees'] = $this->aryEmployeeList();

        return response()->json($arySetting);
    }

    /**
     * create new departments
     */
    public function addDept($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                $this->validateName()['rules'],
                $this->validateName()['ruleMessages']
            );

            $newDept = (new EmployeeDepartments)
                ->validateAndFill($request->all())
                ->setAttribute('status', EmployeeDepartments::STATUS_ACTIVE);
            // if parent_department
            //$newDept->parent_id = $request->get('parent_department')['id'];

            if ($newDept->save()) {
                logger()->debug(" addDept - insert data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true]);
            } else {
                logger()->debug(" addDept - insert data : NO inserted" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            Logger()->error(" addDept : ValidationException - " . var_export($ex, true));
            return $ex->validator->errors();
        }
    }

    /**
     * edit new departments
     */
    public function editDept($locale, Request $request)
    {
        logger()->debug(" editDepartment -  data : SAVED" . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                $this->validateId()['rules'],
                $this->validateId()['ruleMessages']
            );
            $dept = EmployeeDepartments::whereId($request->get('id'))->first();
            $dept->name = $request->get('name');

            if ($dept->save()) {
                logger()->debug(" editDept - edit data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true]);
            } else {
                logger()->debug(" editDept - edit data : NO updated" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            Logger()->error(" editDept : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }
    /**
     * del department
     */
    public function delDept($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                $this->validateId()['rules'],
                $this->validateId()['ruleMessages']
            );
            $dept = EmployeeDepartments::whereId($request->get('id'))->first();
            logger()->debug(" delDept -  data " . var_export($request->all(), true));

            if ($dept->delete()) {
                logger()->debug(" delDept - delete data : DELETED" . var_export($request->all(), true));
                return response()->json(['result' => true]);
            } else {
                logger()->debug(" delDept - delete data : NO delete" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            Logger()->error(" delDept : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    /**
     * add employee
     */
    public function addEmployee($locale, Request $request){
        logger()->debug(" addEmployee - reqeust " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                $this->validateAddEmployee()['rules'],
                $this->validateAddEmployee()['ruleMessages']
            );
            $input = $request->only('username','password','email','name','position','location');
            $newEmployee = (new Employees)
                ->validateAndFill($input)
                ->setAttribute('status', Employees::STATUS_ACTIVE);
            // check password and password confirm
            if ($request->get('password') != $request->get('password_confirm')){
                // return false
                logger()->error(" addEmployee - password is not match ." | ". $request->get('password')." | ".$request->get('password_confirm')");
                return response()->json(['result' => false]); 
            } else {
                $newEmployee->password = Hash::make($request->get('password'));
            }

                
            if ($newEmployee->save()) {
                // insert or update empl in dept $request->get('department')
                if ($request->get('department') && !empty($request->get('department'))){
                    $this->insertUpdateEmplDept($request->get('department'),$newEmployee->id);
                }
                logger()->debug(" addEmployee - insert data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true]);
            } else {
                logger()->debug(" addEmployee - insert data : NO inserted" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }


            
        } catch (ValidationException $ex) {
            Logger()->error(" addEmployee : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }




    /**
     * edit employee
     */
    public function editEmployee($locale, Request $request)
    {
        logger()->debug(" editEmployee -  data : request " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                $this->validateIdEmail()['rules'],
                $this->validateIdEmail()['ruleMessages']
            );
            $employee = Employees::whereId($request->get('id'))->first();
            $employee->name = $request->get('name');
           // $employee->email = $request->get('email');
            $employee->position = $request->get('position');
            $employee->join_date = $request->get('join_date');
            $employee->remarks = $request->get('remarks');
            $employee->location = $request->get('location');
            $employee->username = $request->get('username');
            $aryStatus = $request->get('status');
            $employee->status = $aryStatus['value'];

            // if change password 
            if ($request->get('password') != $request->get('password_confirm')){
                // return false
                logger()->error(" editEmployee - password is not match ." | ". $request->get('password')." | ".$request->get('password_confirm')");
                return response()->json(['result' => false]); 
            } else {
                $employee->password = Hash::make($request->get('password'));
            }

            // insert or update empl in dept $request->get('department')
            if ($request->get('department') && !empty($request->get('department'))){
                $this->insertUpdateEmplDept($request->get('department'),$request->get('id'));
            }

            if ($employee->save()) {
                logger()->debug(" editDept - edit data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true]);
            } else {
                logger()->debug(" editDept - edit data : NO updated" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            Logger()->error(" editDept : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    public function viewList($locale)
    {
        return view('backend.employees.list', ['title' => $this->title]);
    }

    public function viewDepartmentList($locale)
    {
        $this->title = "Employee Department Portal | Backend";
        return view('backend.employees.department_list', ['title' => $this->title]);
    }

    public function getEmployeeDeptsDetail($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                $this->validateId()['rules'],
                $this->validateId()['ruleMessages']
            );
            $department = EmployeeDepartments::whereId($request->get('id'))->first();
            return response()->json($department);
        } catch (ValidationException $ex) {
            Logger()->error(" getEmployeeDepartmentsDetail : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    /**
     * getEmployeeList 
     * return json
     */
    public function getEmployeeList()
    {
        try {
            $result['result'] = false;
            $employees = Employees::all();
            if ($employees) {
                $result['result'] = true;
                $result['data'] = $employees;
            }
            return response()->json($result['data']);
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        }
    }

        /**
     * getEmployeeList 
     * return json
     */
    public function aryEmployeeList()
    {
        try {
            return Employees::all()->toArray();
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        }
    }

    //
    /**
     * getEmployeeDetail 
     * return json
     */
    public function getEmployeeDetail($locale, Request $request)
    {
        logger()->debug(" getEmployeeDetail -  data " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                $this->validateId()['rules'],
                $this->validateId()['ruleMessages']
            );
            return response()->json(Employees::whereId($request->get('id'))->with('inDepartments')->first());
        } catch (ValidationException $ex) {
            Logger()->error(" getEmployeeDepartmentsDetail : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    /*
    get employeeDetail by email
    */
    public function getEmployeeDetailByEmail($email){
        try {
            
            return response()->json(Employees::where('email',$email)->with('inDepartments')->first());
        } catch (ValidationException $ex) {
            Logger()->error(" getEmployeeDetailByEmail : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }


    /** 
     * return ALL Department
     */
    public function aryDeptList()
    {
        $homeDepartments = EmployeeDepartments::select('id', 'parent_id', 'name', 'department_email', 'status')->whereParentId("0")->get();
        Logger()->debug(" aryDepartmentList - " . var_export($homeDepartments, true));
        $aryDepartments = [];
        foreach ($homeDepartments as $department) {
            $aryDepartments[$department['id']]['id'] = $department['id'];
            $aryDepartments[$department['id']]['parent_id'] = $department['parent_id'];
            $aryDepartments[$department['id']]['name'] = $department['name'];
            $aryDepartments[$department['id']]['department_email'] = $department['department_email'];
            $aryDepartments[$department['id']]['status'] = $department['status'];
            Logger()->debug(" aryDepartmentList - recurringchildren " . var_export($department, true));
            if ($department->recurringchildren->toArray()) {
                foreach ($department->recurringchildren->toArray() as $subDepartment) {
                    $aryDepartments[$department['id']]['children'][$subDepartment['id']]['id'] = $subDepartment['id'];
                    $aryDepartments[$department['id']]['children'][$subDepartment['id']]['parent_id'] = $subDepartment['parent_id'];
                    $aryDepartments[$department['id']]['children'][$subDepartment['id']]['name'] = $subDepartment['name'];
                    $aryDepartments[$department['id']]['children'][$subDepartment['id']]['department_email'] = $subDepartment['department_email'];
                    $aryDepartments[$department['id']]['children'][$subDepartment['id']]['status'] = $subDepartment['status'];
                    foreach ($subDepartment['children'] as $lastDepartment) {
                        $aryDepartments[$department['id']]['children'][$subDepartment['id']]['children'][$lastDepartment['id']]['id'] = $lastDepartment['id'];
                        $aryDepartments[$department['id']]['children'][$subDepartment['id']]['children'][$lastDepartment['id']]['parent_id'] = $lastDepartment['parent_id'];
                        $aryDepartments[$department['id']]['children'][$subDepartment['id']]['children'][$lastDepartment['id']]['name'] = $lastDepartment['name'];
                        $aryDepartments[$department['id']]['children'][$subDepartment['id']]['children'][$lastDepartment['id']]['department_email'] = $lastDepartment['department_email'];
                        $aryDepartments[$department['id']]['children'][$subDepartment['id']]['children'][$lastDepartment['id']]['status'] = $lastDepartment['status'];
                    }
                }
            }
        }
        return $aryDepartments;
    }

    /***
     * api -- list out departments
     */
    public function jsonDeptsList($locale, $state = null)
    {
        logger()->debug(" jsonDeptsList " . $state);
        if ($state == 'open') {
            $homeDepts = EmployeeDepartments::select('id', 'parent_id', 'name', 'status', DB::raw("'open' as state"))->whereParentId("0")
                ->with(['children' => function ($query) use ($locale) {
                    $query->select('*')->selectRaw("'open' as state");
                }])->get();
            return response()->json($homeDepts);
        } else {
            $homeDepts = EmployeeDepartments::select('id', 'parent_id', 'name', 'status', DB::raw("'closed' as state"))->whereParentId("0")
                ->with(['children' => function ($query) use ($locale) {
                    $query->select('*')->selectRaw("'closed' as state");
                }])->get();
        }

        return response()->json($homeDepts);
    }

    private function insertUpdateEmplDept($aryDept, $employeeId){
        // insert or update empl in dept $request->get('department')
        DB::table('employee_in_departments')
        ->updateOrInsert(
            ['employees_id' => $employeeId, 'employee_departments_id' => $aryDept['id']],
            ['status' => EmployeeInDepartments::STATUS_ACTIVE,'access_right' => EmployeeInDepartments::ACCESS_RIGHT_DEFAULT]
        );
                    
    }

    private function validateName()
    {
        return [
            'rules' => [
                'name' => 'required',
            ],
            'ruleMessages' => [
                'name.required' => 'NAME is required.',
            ],
        ];
    }
    private function validateIdEmail()
    {
        return [
            'rules' => [
                'name' => 'required',
                'email' => 'required',
            ],
            'ruleMessages' => [
                'name.required' => 'NAME is required.',
                'email.required' => 'EMAIL is required.',
            ],
        ];
    }

    private function validateAddEmployee()
    {
        return [
            'rules' => [
                'name' => 'required',
                'email' => 'required|unique:employees',
                'password' => 'required',
                'username' => 'required|unique:employees',
            ],
            'ruleMessages' => [
                'name.required' => 'NAME is required.',
                'email.required' => 'EMAIL is required.',
                'email.unique' => 'EMAIL is existed.',
                'password.required' => 'PASSWORD is required.',
                'username.required' => 'USERNAME is required.',
                'username.unique' => 'USERNAME is existed.',
            ],
        ];
    }
}
