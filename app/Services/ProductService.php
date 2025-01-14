<?php

namespace App\Services;

use App\Models\Products;
use App\Models\CRM_818\ProdlistBoxes818;
use App\Models\ProdlistBoxes;

use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public function updatePstatus($productId, $fromStatus, $toStatus, $comment = null)
    {
        if ($productId && $fromStatus && $toStatus) {
            $product = Products::whereId($productId)->first();
            $product->pstatus = $toStatus;
            if ($toStatus == Products::PSTATUS_HIDDEN) {
                $product->active = 0;
                $product->newproduct = 0;
            } else if ($toStatus == Products::PSTATUS_NEW) {
                $product->active = 1;
                $product->newproduct = 1;
            } else {
                $product->active = 1;
                $product->newproduct = 0;
            }

            if ($toStatus == Products::PSTATUS_EOL) {
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

    public function resetSeqnoWithinBox($boxid, $menucat)
    {
        try {
            // 10.5
            $seq = 10;
            $boxes = ProdlistBoxes::where("boxno", $boxid)->where("menucat", $menucat)->orderBy("seqno", 'asc')->pluck('id')->toArray();
            foreach ($boxes as $id) {
                $newseq = sprintf("%04d", $seq);
                ProdlistBoxes::whereId($id)->update(['seqno' => $newseq]);
                $seq += 10;
            }
            // 8.18
            $seq = 10;
            $boxes = ProdlistBoxes818::where("boxno", $boxid)->where("menucat", $menucat)->orderBy("seqno", 'asc')->pluck('id')->toArray();
            foreach ($boxes as $id) {
                $newseq = sprintf("%04d", $seq);
                ProdlistBoxes818::whereId($id)->update(['seqno' => $newseq]);
                $seq += 10;
            }
            return true;
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function resetBoxSeqno($menucat)
    {
        try {
            // 10.5
            $seq = 10;
            $boxes = ProdlistBoxes::select('id', 'boxno', 'menucat')->where("menucat", $menucat)->groupBy('boxno')->orderBy("box_seqno", 'asc')->get();
            foreach ($boxes->toArray() as $box) {
                $newseq = sprintf("%04d", $seq);
                ProdlistBoxes::where('menucat', $box['menucat'])->where('boxno', $box['boxno'])->update(['box_seqno' => $seq]);
                $seq += 10;
            }

            // 8.18
            $seq = 10;
            $boxes = ProdlistBoxes818::select('id', 'boxno', 'menucat')->where("menucat", $menucat)->groupBy('boxno')->orderBy("box_seqno", 'asc')->get();
            foreach ($boxes->toArray() as $box) {
                $newseq = sprintf("%04d", $seq);
                ProdlistBoxes818::where('menucat', $box['menucat'])->where('boxno', $box['boxno'])->update(['box_seqno' => $seq]);
                $seq += 10;
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }
}
