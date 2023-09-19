<?php

namespace App\Services;
use App\Models\Products;
use Illuminate\Support\Carbon;

class HistoryService
{
    public function updatePstatus($productId, $fromStatus, $toStatus, $comment = null){
        if ($productId && $fromStatus && $toStatus){
            $product = Products::whereId($productId)->first();
            $product->pstatus = $toStatus;
             if ($toStatus == Products::PSTATUS_HIDDEN){
                $product->active = 0;
                $product->newproduct = 0;
            } else if ($toStatus == Products::PSTATUS_NEW){
                $product->active = 1;
                $product->newproduct = 1;
            } else {
                $product->active = 1;
                $product->newproduct = 0;
            }

            if ($toStatus == Products::PSTATUS_EOL){
                $product->eol = 1;
                $product->eol_date = Carbon::now()->format('Y-m-d H:i:s');
                $product->eol_comment = $comment;
            } else {
                $product->eol = 0;
                $product->eol_date = NULL;
                $product->eol_comment = '';
            }
            return $product->save();
        }
    }
}
