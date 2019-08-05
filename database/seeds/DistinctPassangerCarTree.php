<?php

use App\Models\Tecdoc\DistinctPassangerCarTree as DistinctPassangerCarTreeAlias;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Classes\PartfixTecDoc;

class DistinctPassangerCarTree extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param PartfixTecDoc $tecDoc
     * @return void
     */
    public function run(PartfixTecDoc $tecDoc)
    {
        try {
            $distinct_passanger_car_tree = DistinctPassangerCarTreeAlias::first();

            if($distinct_passanger_car_tree) {
                echo "distinct_passanger_car_trees rows - " . $distinct_passanger_car_tree->count()."\n";
                return;
            };

            $passanger_trees = $tecDoc->getDistinctSections();


            foreach ($passanger_trees as $key => $passanger_tree) {
                $distinct_passanger_car_tree = new DistinctPassangerCarTreeAlias;
                $distinct_passanger_car_tree->searchtreeid = $passanger_tree->searchtreeid;
                $distinct_passanger_car_tree->passanger_car_trees_id = $passanger_tree->id;
                $distinct_passanger_car_tree->passanger_car_trees_parentid = $passanger_tree->parentid;
                $distinct_passanger_car_tree->description = $passanger_tree->description;
                if($passanger_tree->parentid != 0) {
                    try {
                        $parent_node = DistinctPassangerCarTreeAlias::where('passanger_car_trees_id', $passanger_tree->parentid)->first();
                        $distinct_passanger_car_tree
                            ->appendToNode($parent_node)
                            ->save();
                    } catch (LogicException $e) {
                        dump($parent_node);
                        dump($passanger_tree);
                        dd($e);
                    }
                } else {
                    $distinct_passanger_car_tree->save();
                }
            }

        } catch (\PDOException $e) {
            dd($e);
            DB::connection()->getPdo()->rollBack();
        }
    }
}
