<?php

namespace App\Http\Controllers;

use App\Models\Keywords;
use App\Models\Navmenu2022Filter;
use App\Models\ProdKeywords;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class KeywordsController extends Controller
{
    public function __construct()
    {
        logger()->debug(Auth::user());
    }

//     public function exportFilter($locale, FileService $fileService)
//     {
//         // start
//         $content = [];
//         $aryFilterCatName=[];
//         $aryFkey=[]

//         /******************************************************************************
//          * Socket
//          ******************************************************************************/
//         /*
//         $content[] ="[SOCKET TYPE]\n";
//         $socketAllowIn = $this->getAllowMenucat([4,5]);
//         $aryFkey[] = 'SOCKET TYPE';

//         Keywords::typeIntel()->get();



//         // find socket value
//         // get socket list from sockets
//         $intel_sql = "SELECT id, skey, display_name FROM keyword_list WHERE `type`=5 AND status = 1 order by seqno";
//         $select = $db->prepare($intel_sql);
//         if ($select->execute()) {
//             foreach ($select->fetchAll(PDO::FETCH_ASSOC) as $k) {
//                 $aryKey = json_decode($k['display_name'], true);
//                 $k['display_name'] = $aryKey['en'];
//                 $newSocketlist['intel'][] = $k;
//                 $tagKey[$k['skey']] = $k['display_name'];
//             };
//         }
//         $amd_sql = "SELECT id, skey, display_name FROM keyword_list WHERE `type`=4 AND status = 1 order by seqno";
//         $select = $db->prepare($amd_sql);
//         if ($select->execute()) {
//             foreach ($select->fetchAll(PDO::FETCH_ASSOC) as $k) {
//                 $aryKey = json_decode($k['display_name'], true);
//                 $k['display_name'] = $aryKey['en'];
//                 $newSocketlist['amd'][] = $k;
//                 $tagKey[$k['skey']] = $k['display_name'];
//             };
//         }


//         $aryAllowIn['socket'] = $socketAllowIn;
//         fprintf($handle, "%s", "filter_id=4");
//         fprintf($handle, "%s", "\nfilter_flag=socket");
//         fprintf($handle, "%s", "\nfilter_data=" . json_encode($newSocketlist));
//         fprintf($handle, "%s", "\nfilter_in=" . json_encode($socketAllowIn));


//         // last part
//         $content[] ="\n\n[SETTINGS]\n";
//         $content[] =
//         fprintf($handle, "\n\n");
//         fprintf($handle, "[SETTINGS]");
//         $content[] = "\nfilter_allow_in=" . json_encode($aryAllowIn);
//         $content[] = "\nfilter_arykey=" . json_encode($aryFkey);
//         $content[] = "\nfilter_cat_name=" . json_encode($aryFilterCatName);
//         $content[] = "\nfilter_tags_key=" . json_encode($tagKey);
//         // end

//         // $content = [];
//         // $content[] = "[json]\njson_menu=" . json_encode($this->activeAryNavmenu2022List($locale));
//         // $content[] = "\nfilter_menucat=" . json_encode($this->activeAryNavmenu2022ListOneLevel($locale));

//         // if ($fileService->createConf('filter', 'LHS_filter.conf', $locale,  implode("\n\n", $content))) {
//         //     return response()->json(['result' => true]);
//         // } else {
//         //     return response()->json(['result' => false]);
//         // }

// */
//     }

/**
 * get selected filter
 */

    public function getAllowMenucat($aryKtype)
    {
        if (!empty($aryKtype)) {
            $data = Navmenu2022Filter::whereIn('ktype', $aryKtype)->get()->toArray();

            return $data;
        } else {
            return false;
        }

        // find 2022_navmenu_filter
        $sql = " SELECT menucat FROM `2022_navmenu_filter` WHERE ktype in (?) group by menucat";

        $select = $db->prepare($sql);
        $select->execute([$ktype]);
        return $select->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getSocketList($locale)
    {
        $socketList = [];
        $intel = Keywords::Select('id', 'skey', 'display_name')->TypeIntel()->get()->toArray();
        foreach ($intel as $k) {
            $aryKey = json_decode($k['display_name'], true);
            $k['display_name'] = $aryKey[$locale];
            $socketList['intel'][] = $k;
        };

        $amd = Keywords::Select('id', 'skey', 'display_name')->TypeAmd()->get()->toArray();
        foreach ($amd as $k) {
            $aryKey = json_decode($k['display_name'], true);
            $k['display_name'] = $aryKey[$locale];
            $socketList['amd'][] = $k;
        };

        return $socketList;
    }

    /**
     * get product basic info
     * return json 
     */
    public function getSocketTypeByPartno($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                ],
                [
                    'partno.required' => 'Partno is required.',
                ]
            );
            // set default list
            $allSockets = Keywords::whereIn('type', [4, 5])
                ->pluck('skey')->toArray();
            $socketList = [];
            foreach ($allSockets as $socket) {
                $socketList[$socket] = false;
            }
            Logger()->debug(" getSocketTypeByPartno : allSockets " . var_export($socketList, true));

            // get socket belong to partno
            $prodSockets = ProdKeywords::where("prod_keywords.partno", $request->get('partno'))
                ->leftJoin('keyword_list as kl', 'kl.skey', '=', 'prod_keywords.skey')
                ->whereIn("kl.type", [Keywords::TYPE_AMD, Keywords::TYPE_INTEL])
                ->get()->toArray();
            Logger()->debug(" getSocketTypeByPartno : prodSockets " . var_export($prodSockets, true));


            if ($prodSockets) {
                foreach ($prodSockets as $ps) {
                    $socketList[$ps['skey']] = true;
                    $aryDisplayName = json_decode($ps['display_name'], true);
                    $socketList['display_name'][] = $aryDisplayName[$locale];
                }
            }
            return response()->json($socketList);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /**
     * update socket type of keywords
     * return json 
     */
    public function updateSocketTypeByPartno($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                    'data' => 'required',
                ],
                [
                    'partno.required' => 'Partno is required.',
                    'data.required' => 'Data is required.',
                ]
            );
            Logger()->debug(" updateSocketTypeByPartno : request " . var_export($request->all(), true));

            $requestSockets = $request->get('data');
            $selectedSockets = [];
            foreach ($requestSockets as $rKey => $rSocket) {
                if ($rSocket) {
                    $selectedSockets[] = $rKey;
                }
            }
            // $selectedSockets = array_keys($request->get('data'));
            Logger()->debug(" updateSocketTypeByPartno : selectedSocket " . var_export($selectedSockets, true));

            $updateSocket = $this->handleKeyword2prod($request->get('partno'), $selectedSockets, [Keywords::TYPE_AMD, Keywords::TYPE_INTEL]);

            if (!empty($updateSocket)) {
                // get socket list

                return response()->json($this->getSocketTypeByPartno($locale, $request));
            } else {
                return response()->json(['data' => "has no change"]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getKeywordsByPartno($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                ],
                [
                    'partno.required' => 'Partno is required.',
                ]
            );
            $prodKeywords = ProdKeywords::where('partno', $request->get('partno'))->get();
            if ($prodKeywords) {
                $list = [];
                foreach ($prodKeywords as $ps) {
                    $list[$ps->skey] = true;
                }
                return response()->json($list);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /**
     * handle update or remove in prod_keywords
     * return json array
     */
    public function handleKeyword2prod($partno, $arySelectedKeys, $aryType = [])
    {
        try {
            if (isset($partno) && $partno) {
                $doneId = [];
                $err = [];

                // get keyword id has been assigned
                $existingIds = ProdKeywords::where("prod_keywords.partno", $partno)
                    ->leftJoin('keyword_list as kl', 'kl.skey', '=', 'prod_keywords.skey')
                    ->whereIn("kl.type", $aryType)
                    ->pluck('prod_keywords.skey')->toArray();

                Logger()->debug(" handleKeyword2prod - arySelectedKeys : " . var_export($arySelectedKeys, true));
                Logger()->debug(" handleKeyword2prod - existingIds : " . var_export($existingIds, true));
                $cntTask = 0;
                // find keywords to insert
                if ($aryInsert = array_diff($arySelectedKeys, $existingIds)) {
                    $cntTask += count($aryInsert);
                };
                Logger()->debug(" handleKeyword2prod - aryInsert : " . var_export($aryInsert, true));
                Logger()->debug(" handleKeyword2prod - cntTask : " . var_export($cntTask, true));

                // find keywords to delete
                if ($aryDelete = array_diff($existingIds, $arySelectedKeys)) {
                    $cntTask += count($aryDelete);
                };
                Logger()->debug(" handleKeyword2prod - aryDelete : " . var_export($aryDelete, true));

                // do insert
                if (!empty($aryInsert)) {
                    foreach ($aryInsert as $k => $ids) {
                        $newProdKey = ProdKeywords::firstOrNew(
                            ['skey' => $ids, 'partno' => $partno]
                        );
                        if ($newProdKey->save()) {
                            $doneId[] = $newProdKey->id;
                        };
                        Logger()->debug(" handleKeyword2prod - insert data : " . var_export($ids, true));
                        Logger()->debug(" handleKeyword2prod - newProdKey : " . var_export($newProdKey, true));
                    }
                }
                // // do delete
                foreach ($aryDelete as $k => $ids) {
                    $delProdKey = ProdKeywords::where('skey', $ids)->where('partno', $partno)->first();
                    if ($delProdKey) {
                        if ($delProdKey->delete()) {
                            $doneId[] = $delProdKey->id;
                        };
                        Logger()->debug(" handleKeyword2prod - delProdKey : " . var_export($delProdKey, true));
                    }
                }
                return $doneId;
            } else {
                Logger()->debug(" handleKeyword2prod - no partno : ");
                return false;
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }



    /**
     * list out all keywords 
     * return json array
     */
    public function list_all(Request $request)
    {
        $sort = $request->get('sort') ? $request->get('sort') : 'type, seqno';
        $order = $request->get('order') ? strval($request->get('order')) : 'asc';
        $page = $request->get('page') ? intval($request->get('page')) : 1;
        $rows = $request->get('rows') ? intval($request->get('rows')) : 25;
        $offset = ($page - 1) * $rows;
        $keywords = Keywords::orderBy('seqno', 'asc')->get();
        return response()->json(['rows' => $keywords, 'total' => Keywords::all()->count()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $keywords = Keywords::whereNull('parent_id')->orderBy('seq', 'asc')->get();
        return view('admin.keywords.index', compact('keywords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $keywords = Keywords::whereNull('parent_id')->orderBy('seq', 'asc')->get();
        logger()->debug("Keywords create");
        return view('admin.keywords.create', compact('keywords'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //logger()->debug(" Keywords - Store : " . var_export($request->all(),true));
        $keywords = (new Keywords)
            ->validateAndFill($request->all())
            ->setAttribute('status', Keywords::STATUS_ACTIVE);
        // set default value 
        $keywords->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        // set default value
        $keywords->display_name = $this->assignDefaultValue($request->input("display_name")['en'], $request->input('display_name'));


        if ($keywords->save()) {
            logger()->debug(" Keywords - Store data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.keywords_list', [config('app.locale')])->with('status', 'Keywords is added');
        } else {
            logger()->debug(" Keywords - Store data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keywords  $Keywords
     * @return \Illuminate\Http\Response
     */
    public function show(Keywords $Keywords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keywords  $Keywords
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, $id)
    {
        logger()->debug(var_export($id, true));
        $getKeyword = Keywords::whereId($id)->first();
        logger()->debug(var_export($getKeyword, true));

        $keywords = Keywords::whereNull('parent_id')->orderBy('seq', 'asc')->get();
        return view('admin.keywords.edit', compact('keywords', "getKeyword"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keywords  $Keywords
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //  logger()->debug(" Keywords - update : " . var_export($request->all(),true));
        $keywords = Keywords::whereId($request->input("id"))->first();
        $keywords->parent_id = $request->input('parent_id');
        $keywords->seq = $request->input('seq');

        // set default value 
        $keywords->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        // set default value
        $keywords->display_name = $this->assignDefaultValue($request->input("display_name")['en'], $request->input('display_name'));


        if ($keywords->save()) {
            logger()->debug(" Keywords - update data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.keywords_list', [config('app.locale')])->with('status', 'Keywords is Updated');
        } else {
            logger()->debug(" Keywords - update data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keywords $keywords)
    {
        //
    }
}
