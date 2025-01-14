<?php

namespace App\Http\Controllers;

use App\Models\SalesOffices;

use App\Services\FileService;

use App\Services\HistoryService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Storage;


class SalesOfficesController extends Controller
{
    protected $imgPath;
    protected $imgWebPath;
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
        $this->imgWebPath = "/img/company_logo/";
        $this->imgPath = env("AKASAWEBDIR_2206", "/akasa/www/akasa2206") . $this->imgWebPath;
    }

    public function listName($locale, $q)
    {
        logger()->debug(" SalesRecordsController : listName " . var_export($q, true));
        return response()->json(SalesOffices::select('id', 'company_name', 'continent', 'custom_continent', 'country', 'country_code')
            ->where("company_name", "like", "%" . $q . "%")->get()->toArray());
    }

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function getList($locale, Request $request)
    {
        logger()->debug(" SalesRecordsController : getList " . var_export($request->all(), true));
        try {
            $sort = $request->has('sort') ? $request->get('sort') : 'updated_at';
            $order = $request->has('order') ? $request->get('order') : 'desc';
            $page = $request->has('page') ? $request->get('page') : 1;
            $rows = $request->has('rows') ? $request->get('rows') : 50;
            $skip = ($page - 1) * $rows;

            $data = SalesOffices::orderBy($sort, $order);
            if ($request->has("country_code") && $request->get("country_code")) {
                $data->where("country_code", $request->get("country_code"));
            }

            if ($request->has("name") && $request->get("name")) {
                $data->where("company_name", 'like', "%" . $request->get("name") . "%");
            }

            $result['total'] = $data->get()->count();
            $result['rows'] = $data->skip($skip)->take($rows)->get()->toArray();

            return response()->json($result);
        } catch (Exception $e) {
            Logger()->error(" getSalesItemsList : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }
    }

    /**
     * return json out
     * by currency, continent, country
     */
    public function exportConf($locale, Request $request, FileService $fileService)
    {
        try {
            $salesOffices = SalesOffices::where('status', 'Active')->get();
            $data = [];
            $data['sales_offices'] = $salesOffices->toArray();
            $data['country_list'] = $this->countryList();
            $data['continent_list'] = $this->continentList();
            $data['stype_list'] = $this->stypeList();
            // $data['sales_office'] = $salesOffices->get(); continentList()stypeList
            //return response()->json($data);


            // get the list of country

            $result = $fileService->createConf('sales_offices', 'sales_offices.conf', $locale,  "[sales_offices]\nlist=" . json_encode($data));
            if ($result) {
                return response()->json(['result' => true, 'data' => $result]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (Exception $e) {
            Logger()->error(" getSalesItemsList : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }
    }

    public function addSalesOffice($locale, Request $request)
    {
        logger()->debug(" SalesRecordsController : addSalesOffice " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'company_name' => 'required',
                    'continent' => 'required',
                    'country' => 'required',
                ],
                [
                    'company_name.required' => 'Company name is required.',
                    'continent.required' => 'Continent is required.',
                    'country.required' => 'Country is required.',

                ]
            );

            $user = $request->get('username');
            $currentDatetime = Carbon::now();

            if ($request->has('id') && $request->get("id")) {
                $data = SalesOffices::whereId($request->get("id"))->firstOrFail();

                $country = $request->get('country');

                $data->company_name = $request->get('company_name');
                $data->account_ref = $request->get('account_ref');
                $data->logo = $request->get('logo');
                $data->continent = $country['continent'];
                $data->custom_continent = $country['custom_continent'];
                $data->country_code = $country['country_code'];
                $data->country = $country['country'];
                $data->currency = $request->get('currency');
                $data->address = $request->get('address');
                $data->tel = $request->get('tel');
                $data->fax = $request->get('fax');
                $data->email = $request->get('email');
                $data->website = $request->get('website');
                $data->stype = $request->get('stype');
                $data->status = $request->get('status');

                $historyService = new HistoryService;
                // log & history if has been changed
                if ($data->isDirty()) {
                    foreach ($data->getDirty() as $key => $value) {
                        Logger()->debug(" update sales offices : fieldname " . $key . " getOriginal " . $data->getOriginal($key) . " new value " . $value);
                        $historyService->addSalesOfficesChangeLogs($data->id, $key, $data->getOriginal($key), $value, 'change', $user);
                    }
                    $data->updated_by = $user;
                    // add history
                    $historyService->addSalesOfficesHistory($data->id, "update", $user);
                }
                if ($data->save()) {
                    return response()->json($data);
                } else {
                    return response()->json(false);
                }
            } else {
                // Create NEW 
                $data = $request->only(
                    'company_name',
                    'logo',
                    'continent',
                    'currency',
                    'address',
                    'tel',
                    'fax',
                    'email',
                    'website',
                    'online_shop',
                    'stype',
                    'status'
                    //     'account_ref', 
                );
                $country = $request->get('country');
                $data['country_code'] = $country['country_code'];
                $data['country'] = $country['country'];
                $data['custom_continent'] = $country['custom_continent'];
                $data['created_by'] = $user;
                $data['created_at'] = $currentDatetime->isoFormat("Y-M-D HH:mm:ss");

                $addNew = SalesOffices::firstOrCreate($data);
                if ($addNew) {
                    Logger()->debug(" addSalesOffice : DONE  - " . var_export($addNew, true));
                    return response()->json(['result' => true, 'data' => $addNew]);
                } else {
                    Logger()->debug(" addSalesOffice : FAILED  - addSalesOffice " . var_export($addNew, true));
                    Logger()->debug(" addSalesOffice : FAILED  - data " . var_export($data, true));
                    return response()->json(['result' => false]);
                }
            }
        } catch (Exception $e) {
            Logger()->error(" SalesRecordsController : createSalesOffice : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }
    }

    public function deleteSalesOffice($locale, Request $request)
    {
        logger()->debug(" SalesRecordsController : deleteSalesOffice " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',

                ]
            );

            $user = $request->get('username');
            $id = $request->get('id');

            $data = SalesOffices::where('id', $id)->first();
            if ($data) {
                $historyService = new HistoryService;
                $historyService->addSalesOfficesHistory($id, "delete", $request->get('username'));
                $file = $data->logo;
                if ($data->delete()) {
                    Storage::disk('web2206')->delete($file);
                    Logger()->debug(" deleteSalesOffice : DONE  - " . var_export($data, true));
                    return response()->json(['result' => true, 'data' => $data]);
                } else {
                    Logger()->debug(" deleteSalesOffice : FAILED  - deleteSalesOffice " . var_export($data, true));
                    Logger()->debug(" deleteSalesOffice : FAILED  - data " . var_export($data, true));
                    return response()->json(['result' => false]);
                }
            }
        } catch (Exception $e) {
            Logger()->error(" SalesRecordsController : deleteSalesOffice : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }
    }

    public function removeLogo($locale, Request $request)
    {
        logger()->debug(" SalesRecordsController : removeLogo " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',

                ]
            );

            $user = $request->get('username');
            $id = $request->get('id');

            $data = SalesOffices::where('id', $id)->first();
            if ($data) {
                $historyService = new HistoryService;
                $historyService->addSalesOfficesHistory($id, "remove logo", $request->get('username'));
                $file = $data->logo;
                if (Storage::disk('web2206')->delete($file)) {
                    $data->logo = "";
                    if ($data->isDirty()) {
                        foreach ($data->getDirty() as $key => $value) {
                            Logger()->debug(" update sales offices : fieldname " . $key . " getOriginal " . $data->getOriginal($key) . " new value " . $value);
                            $historyService->addSalesOfficesChangeLogs($data->id, $key, $data->getOriginal($key), $value, 'change', $user);
                        }
                        $data->updated_by = $user;
                        // add history
                        $historyService->addSalesOfficesHistory($data->id, "update", $user);
                    }
                }

                // log & history if has been changed

                if ($data->save()) {
                    return response()->json(['result' => true, 'data' => $data]);
                } else {
                    return response()->json(['result' => false]);
                }
            }
        } catch (Exception $e) {
            Logger()->error(" SalesRecordsController : removeLogo : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }
    }

    private function continentList()
    {
        return  [
            ["value" => "Africa"],
            ["value" => "Asia"],
            ["value" => "Australia"],
            ["value" => "Europe"],
            ["value" => "Middle East"],
            ["value" => "North America"],
            ["value" => "South America"],
        ];
    }

    private function stypeList()
    {
        return  [
            ["value" => "Retailer"],
            ["value" => "Distributor"],
            ["value" => "e-Shop"],
            ["value" => "Marketplace"],
        ];
    }

    private function countryList()
    {
        return  [
            ["country_code" => "AT", "country" => "Austria", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "BE", "country" => "Belgium", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "BG", "country" => "Bulgaria", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "CA", "country" => "Canada", "continent" => "North America", "custom_continent" => "North America"],
            ["country_code" => "CH", "country" => "Switzerland", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "CZ", "country" => "Czech Republic", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "DE", "country" => "Germany", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "DK", "country" => "Denmark", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "DZ", "country" => "Algeria", "continent" => "Africa", "custom_continent" => "Africa"],
            ["country_code" => "EE", "country" => "Estonia", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "ES", "country" => "Spain", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "FI", "country" => "Finland", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "FR", "country" => "France", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "GB", "country" => "United Kingdom", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "GR", "country" => "Greece", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "HK", "country" => "Hong Kong", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "HU", "country" => "Hungary", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "IE", "country" => "Ireland", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "IL", "country" => "Israel", "continent" => "Asia", "custom_continent" => "Middle East"],
            ["country_code" => "IN", "country" => "India", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "IT", "country" => "Italy", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "LU", "country" => "Luxembourg", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "LV", "country" => "Latvia", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "NL", "country" => "The Netherlands", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "NO", "country" => "Norway", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "PL", "country" => "Poland", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "PT", "country" => "Portugal", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "RO", "country" => "Romania", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "RU", "country" => "Russian Federation", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "SE", "country" => "Sweden", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "SI", "country" => "Slovenia", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "SK", "country" => "Slovakia", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "TR", "country" => "Turkey", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "TW", "country" => "Taiwan, Province of China", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "UA", "country" => "Ukraine", "continent" => "Europe", "custom_continent" => "Europe"],
            ["country_code" => "US", "country" => "United States", "continent" => "North America", "custom_continent" => "North America"],
            ["country_code" => "CN", "country" => "China", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "SG", "country" => "Singapore", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "JP", "country" => "Japan", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "KP", "country" => "Korea", "continent" => "Asia", "custom_continent" => "Asia"],
            ["country_code" => "AE", "country" => "United Arab Emirates (UAE)", "continent" => "Asia", "custom_continent" => "Middle East"]
        ];
    }

    
}
