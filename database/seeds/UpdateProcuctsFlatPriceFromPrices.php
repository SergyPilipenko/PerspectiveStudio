<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProcuctsFlatPriceFromPrices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return 1;
        $sql = "UPDATE `products_flat` AS `pf`,
        (
            SELECT products_flat.id, w.price FROM products_flat, (SELECT article_id, min(price) as price from prices GROUP BY article_id) as w
            where w.article_id = products_flat.id
        ) AS `src`
        SET
            `pf`.`price` = `src`.`price`
        WHERE
            `pf`.`id` = `src`.id";

        try {
            DB::connection()->update($sql);
        } catch (\PDOException $exception) {
            dd($exception->getMessage());
        }
    }
}
