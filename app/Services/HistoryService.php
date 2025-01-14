<?php

namespace App\Services;

use App\Models\Products;
use App\Models\ProductChangeLogs;
use App\Models\ProductsHistory;
use App\Models\SalesOffices;
use App\Models\SalesOfficesChangeLogs;
use Illuminate\Support\Carbon;

class HistoryService
{
    protected $currentDatetime;
    public function __construct()
    {
        $datetime = Carbon::now();
        $this->currentDatetime = $datetime->isoFormat("Y-M-D HH:mm:ss");
    }

    public function addProductsHistory($id, $action, $name)
    {
        $data  = Products::whereId($id)->first();

        $history = $data->replicate();
        $history->setTable('akasaweb2021.products_history');
        $history->id = $id;
        $history->timestamps = false;
        $history->action = $action;
        $history->logged_by = $name;
        $history->logged_at = $this->currentDatetime;

        if ($history->save()) {
            logger()->debug(" addProductsHistory : done" . var_export($history, true));
            return true;
        } else {
            logger()->error(" FAILED addProductsHistory $action, $name, $id ");
            return false;
        }
    }

    // products history
    public function addProductsChangeLogs($id, $partno, $tablename, $field, $val_o, $val_n, $action, $user)
    {
        Logger()->debug(" addProductsChangeLogs : tablename:$tablename, fieldname:$field, getOriginal:$val_o, new value:$val_n");
        $data = [];
        $data['id'] = $id;
        $data['partno'] = $partno;
        $data['tablename'] = $tablename;
        $data['fieldname'] = $field;
        $data['orgvalue'] = $val_o;
        $data['newvalue'] = $val_n;
        $data['action'] = $action;
        $data['created_by'] = $user;
        return ProductChangeLogs::create($data);
    }

    public function addSalesOfficesHistory($id, $action, $name)
    {
        $data  = SalesOffices::whereId($id)->first();

        $history = $data->replicate();
        $history->setTable('akasaweb2021.sales_offices_history');
        $history->id = $id;
        $history->timestamps = false;
        $history->action = $action;
        $history->logged_by = $name;
        $history->logged_at = $this->currentDatetime;

        if ($history->save()) {
            logger()->debug(" addSalesOfficesHistory : done" . var_export($history, true));
            return true;
        } else {
            logger()->error(" FAILED addSalesOfficesHistory $action, $name, $id ");
            return false;
        }
    }

    // products history
    public function addSalesOfficesChangeLogs($id, $field, $val_o, $val_n, $action, $user)
    {
        Logger()->debug(" addSalesOfficesChangeLogs : fieldname:$field, getOriginal:$val_o, new value:$val_n ");
        $data = [];
        $data['id'] = $id;
        $data['fieldname'] = $field;
        $data['orgvalue'] = $val_o;
        $data['newvalue'] = $val_n;
        $data['action'] = $action;
        $data['created_by'] = $user;
        
        return SalesOfficesChangeLogs::create($data);
    }
}
