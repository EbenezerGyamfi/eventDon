<?php

namespace App\Support\Gifts;

use App\Models\Gifts;

class GiftsService
{
    /**
     * @throws \Exception
     */
    public static function generateGiftCode(): string
    {
        $lastCode = Gifts::latest('code')->first();
        if ($lastCode) {
            $length = strlen($lastCode->code);
            $startPos = 4;
            $endPos = $length - 4;
            $itemCount = (int) substr($lastCode->code, $startPos, $endPos - $startPos);
        } else {
            $itemCount = 0;
        }

        return date('y').random_int(10, 99).str_pad($itemCount + 1, 4, '0', STR_PAD_LEFT).date('md');
    }
}
