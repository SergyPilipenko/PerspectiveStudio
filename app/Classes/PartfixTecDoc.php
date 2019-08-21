<?php


namespace App\Classes;
use App\Classes\Tecdoc;
use Illuminate\Support\Facades\DB;

class PartfixTecDoc extends Tecdoc
{
    public $linkageTypeId = [];

    public $section_parts = [];

    /**
     * PartfixTecDoc constructor.
     */
    public function __construct($type = 'passenger')
    {
        parent::__construct($connection = 'mysql_tecdoc');
        $this->setType($type);
    }

    /**
     * Бренды у которых есть модели в $year году
     *
     * (требуется заполненная таблица models_counstruction_interval с помощью seeder-a AddModelsConstructionIntervalTable)
     * @param $year
     * @return array
     */
    public function getBrandsByModelsCreatedYear($year) : array
    {
        return DB::connection('mysql')->select("
            SELECT DISTINCT mf.id, mf.description 
            FROM 
                (SELECT id, model_id, manufacturer_id, created, 
                    (CASE WHEN models_counstruction_interval.stopped = '' THEN YEAR(CURRENT_DATE) ELSE models_counstruction_interval.stopped END) stopped
                FROM models_counstruction_interval) w 
            JOIN ".env('DB_TECDOC_DATABASE').".manufacturers mf on w.manufacturer_id = mf.id
            WHERE w.stopped >= '".$year."' 
                AND w.created <= '".$year."' 
                AND w.created != '' 
                AND mf.ispassengercar = 'true' 
            ORDER BY mf.description");
    }

    /**
     * (1.4) Типы кузова
     *
     * @param $models_ids
     * @return mixed
     */

    public function getModelsBodyTypes($models_ids)
    {
        return DB::connection($this->connection)->select("
            SELECT DISTINCT a.displayvalue FROM `models` m
                LEFT JOIN passanger_cars p ON m.id = p.modelid
                LEFT JOIN passanger_car_attributes a ON p.id = a.passangercarid
                WHERE m.id IN ($models_ids) AND a.attributetype = 'BodyType' AND m.canbedisplayed = 'true'
        ");
    }

//    public function getModelsAttributes($models_ids)
//    {
//
//        $models = [];
//
//        $attributes =  DB::connection($this->connection)->select("
//           SELECT * FROM models m
//            LEFT JOIN passanger_cars p ON m.id = p.modelid
//            LEFT JOIN passanger_car_attributes a ON p.id = a.passangercarid
//            WHERE m.id IN ({$models_ids})
//        ");
//
//        foreach ($attributes as $attribute) {
//            if(!array_key_exists($attribute->modelid)) {
//                $models[$attribute->modelid]
//            }
//        }
//
//        dd($models);
//
//
//    }

    /**
     * (1.4) Объемы двигателей для моделей
     *
     * @param $models_ids
     * @return mixed
     */

    public function getModelsEngines($models_ids, $body_type)
    {
        $engineType = [];
        $attributes =  DB::connection($this->connection)->select("
            SELECT w.id, w.model_id, w.passanger_car_id, pca.displayvalue as EngineType, cp.displayvalue as capacity, w.displayvalue as BodyType, pca.displayvalue, w.description from (SELECT a.id, a.attributetype, p.description, a.displayvalue,  p.id as passanger_car_id, m.id as model_id
                FROM models m
                LEFT JOIN passanger_cars p on m.id = p.modelid
                LEFT JOIN passanger_car_attributes a ON p.id = a.passangercarid
                WHERE m.id IN ($models_ids) AND a.attributetype = 'BodyType' AND a.displayvalue = '".$body_type."') w
                LEFT JOIN passanger_car_attributes pca ON pca.passangercarid = w.passanger_car_id
                LEFT JOIN passanger_car_attributes cp ON cp.passangercarid = w.passanger_car_id
                WHERE pca.attributetype = 'EngineType' and cp.attributetype = 'Capacity'
        ");

        foreach ($attributes as $attribute) {
            $engineType[$attribute->EngineType][] = $attribute->capacity;
        }

        foreach ($engineType as &$type) {
            $type = array_unique($type);
        }

        return $engineType;
    }

    public function getModificationsEngines($modifications, $body_type)
    {
        $engineType = [];

        $attributes = DB::connection($this->connection)->select("
            SELECT w.passanger_car_id, pca.displayvalue as EngineType, cp.displayvalue as capacity, w.displayvalue as BodyType, pca.displayvalue, w.description from (SELECT a.id, a.attributetype, p.description, a.displayvalue,  p.id as passanger_car_id
                FROM passanger_cars p
                LEFT JOIN passanger_car_attributes a ON p.id = a.passangercarid
                WHERE p.id IN ($modifications) AND a.attributetype = 'BodyType' AND a.displayvalue = '".$body_type."') w
                LEFT JOIN passanger_car_attributes pca ON pca.passangercarid = w.passanger_car_id
                LEFT JOIN passanger_car_attributes cp ON cp.passangercarid = w.passanger_car_id
                WHERE pca.attributetype = 'EngineType' and cp.attributetype = 'Capacity'
        ");

        foreach ($attributes as $attribute) {
            $engineType[$attribute->EngineType][] = $attribute->capacity;
        }

        foreach ($engineType as &$type) {
            $type = array_unique($type);
        }

        return $engineType;
    }

    /**
     * (1.3) Модификации авто
     *
     * @param $model_id
     * @return mixed
     */
    public function getModifications($model_id)
    {
        switch ($this->type) {
            case 'passenger':
                return DB::connection($this->connection)->select("
					SELECT id, fulldescription name, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue, pc.constructioninterval
					FROM passanger_cars pc 
					LEFT JOIN passanger_car_attributes a on pc.id = a.passangercarid
					WHERE canbedisplayed = 'True'
					AND modelid = " . (int)$model_id . " AND ispassengercar = 'True'");
                break;
            case 'commercial':
                return DB::connection($this->connection)->select("
					SELECT id, fulldescription name, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue
					FROM commercial_vehicles cv 
					LEFT JOIN commercial_vehicle_attributes a on cv.id = a.commercialvehicleid
					WHERE canbedisplayed = 'True'
					AND modelid = " . (int)$model_id . " AND iscommercialvehicle = 'True'");
                break;
            case 'motorbike':
                return DB::connection($this->connection)->select("
					SELECT id, fulldescription name, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue
					FROM motorbikes m 
					LEFT JOIN motorbike_attributes a on m.id = a.motorbikeid
					WHERE canbedisplayed = 'True'
					AND modelid = " . (int)$model_id . " AND ismotorbike = 'True'");
                break;
            case 'engine':
                return DB::connection($this->connection)->select("
					SELECT id, fulldescription name, salesDescription, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue
					FROM engines e 
					LEFT JOIN engine_attributes a on e.id= a.engineid
					WHERE canbedisplayed = 'True'
					AND manufacturerId = " . (int)$model_id . " AND isengine = 'True'");
                break;
            case 'axle':
                return DB::connection($this->connection)->select("
					SELECT id, fulldescription name, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue
					FROM axles ax 
					LEFT JOIN axle_attributes a on ax.id= a.axleid
					WHERE canbedisplayed = 'True'
					AND modelid = " . (int)$model_id . " AND isaxle = 'True'");
                break;
        }
    }

//    public function getGarageModificications()
//    {
//        switch ($this->type) {
//            case 'passenger':
//                return DB::connection($this->connection)->select("
//					SELECT id, fulldescription name, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue, pc.constructioninterval
//					FROM passanger_cars pc
//					LEFT JOIN passanger_car_attributes a on pc.id = a.passangercarid
//					WHERE canbedisplayed = 'True'
//					AND modelid = " . (int)$model_id . " AND ispassengercar = 'True'");
//                break;
//        }
//    }

    public function getModelsModifications($models_ids)
    {
        switch ($this->type) {
            case 'passenger':
                return DB::connection($this->connection)->select("
					SELECT id, fulldescription name, a.attributegroup, a.attributetype, a.displaytitle, a.displayvalue, pc.constructioninterval
					FROM passanger_cars pc 
					LEFT JOIN passanger_car_attributes a on pc.id = a.passangercarid
					WHERE canbedisplayed = 'True'
					AND modelid IN " . $models_ids . " AND ispassengercar = 'True'");
                break;
        }
    }

    /**
     * (2.4) Выборка всех уникальных категорий
     *
     * @return mixed
     */

    public function getDistinctSections()
    {
        switch ($this->type) {
            case 'passenger':
                return DB::connection($this->connection)->select("
                SELECT DISTINCT searchtreeid, id, parentid, description FROM `passanger_car_trees`
                ");
                break;
        }
    }


    /**
     * (2.4) Выборка вложенного дерева категрий
     *
     * @param $modification_id
     * @param $section_id
     * @return mixed
     */

    public function getNestedSections($modification_id, $section_id = null)
    {
        $sections = $this->getSections($modification_id, $section_id);
        if(count($sections)) {
            foreach ($sections as $section) {

                $section->children = $this->getNestedSections($modification_id, $section->id);
            }
        } else {
            $section_parts = $this->getSectionParts($modification_id, $section_id);
            if(count($section_parts)) $this->section_parts = array_merge($this->section_parts, $section_parts);
        }


        return $sections;
    }

    public function getAllSectionParts()
    {
        $sections = $this->getNestedSections();
    }



    /**
     * (2.3) Поиск запчастей раздела
     *
     * @param $modification_id
     * @param $section_id
     * @return mixed
     */
    public function getSectionParts($modification_id, $section_id)
    {
        switch ($this->type) {
            case 'passenger':
                return DB::connection($this->connection)->select(" SELECT al.datasupplierarticlenumber part_number, s.description supplier_name, prd.description product_name
                    FROM article_links al 
                    JOIN passanger_car_pds pds on al.supplierid = pds.supplierid
                    JOIN suppliers s on s.id = al.supplierid
                    JOIN passanger_car_prd prd on prd.id = al.productid
                    WHERE al.productid = pds.productid
                    AND al.linkageid = pds.passangercarid
                    AND al.linkageid = " . (int)$modification_id . "
                    AND pds.nodeid = " . (int)$section_id . "
                    AND al.linkagetypeid = 2
                    ORDER BY s.description, al.datasupplierarticlenumber");
                break;
            case 'commercial':
                return DB::connection($this->connection)->select(" SELECT al.datasupplierarticlenumber part_number, s.description supplier_name, prd.description product_name
                    FROM article_links al 
                    JOIN commercial_vehicle_pds pds on al.supplierid = pds.supplierid
                    JOIN suppliers s on s.id = al.supplierid
                    JOIN commercial_vehicle_prd prd on prd.id = al.productid
                    WHERE al.productid = pds.productid
                    AND al.linkageid = pds.commertialvehicleid
                    AND al.linkageid = " . (int)$modification_id . "
                    AND pds.nodeid = " . (int)$section_id . "
                    AND al.linkagetypeid = 16
                    ORDER BY s.description, al.datasupplierarticlenumber");
                break;
            case 'motorbike':
                return DB::connection($this->connection)->select(" SELECT al.datasupplierarticlenumber part_number, s.description supplier_name, prd.description product_name
                    FROM article_links al 
                    JOIN motorbike_pds pds on al.supplierid = pds.supplierid
                    JOIN suppliers s on s.id = al.supplierid
                    JOIN motorbike_prd prd on prd.id = al.productid
                    WHERE al.productid = pds.productid
                    AND al.linkageid = pds.motorbikeid
                    AND al.linkageid = " . (int)$modification_id . "
                    AND pds.nodeid = " . (int)$section_id . "
                    AND al.linkagetypeid = 777
                    ORDER BY s.description, al.datasupplierarticlenumber");
                break;
            case 'engine':
                return DB::connection($this->connection)->select(" SELECT pds.engineid, al.datasupplierarticlenumber part_number, prd.description product_name, s.description supplier_name
                    FROM article_links al 
                    JOIN engine_pds pds on al.supplierid = pds.supplierid
                    JOIN suppliers s on s.id = al.supplierid
                    JOIN engine_prd prd on prd.id = al.productid
                    WHERE al.productid = pds.productid
                    AND al.linkageid = pds.engineid
                    AND al.linkageid = " . (int)$modification_id . "
                    AND pds.nodeid = " . (int)$section_id . "
                    AND al.linkagetypeid = 14
                    ORDER BY s.description, al.datasupplierarticlenumber");
                break;
            case 'axle':
                return DB::connection($this->connection)->select(" SELECT pds.axleid, al.datasupplierarticlenumber part_number, prd.description product_name, s.description supplier_name
                    FROM article_links al 
                    JOIN axle_pds pds on al.supplierid = pds.supplierid
                    JOIN suppliers s on s.id = al.supplierid
                    JOIN axle_prd prd on prd.id = al.productid
                    WHERE al.productid = pds.productid
                    AND al.linkageid = pds.axleid
                    AND al.linkageid = " . (int)$modification_id . "
                    AND pds.nodeid = " . (int)$section_id . "
                    AND al.linkagetypeid = 19
                    ORDER BY s.description, al.datasupplierarticlenumber");
                break;
        }
    }

    /**
     * (3.5) Применимость изделия
     *
     * @param $number
     * @param $brand_id
     * @return array
     */
    public function getArtVehicles($number, $brand_id)
    {
        $result = [];
        $rows = DB::connection($this->connection)->select("
            SELECT linkageTypeId, linkageId FROM article_li WHERE DataSupplierArticleNumber='" . $number . "' AND supplierId='" . $brand_id . "'
        ");
        $rows = json_decode(json_encode($rows), true);

        foreach ($rows as $key => &$row) {
//            dd(in_array($row['linkageTypeId'], $this->linkageTypeId));
            if(in_array($row['linkageTypeId'], $this->linkageTypeId)) continue;
            switch ($row['linkageTypeId']) {
                case 'PassengerCar':
                    $this->linkageTypeId[] = $row['linkageTypeId'];

                    $result[$row['linkageId']][] = DB::connection($this->connection)->select("SELECT DISTINCT p.id, mm.description make, m.description model, p.constructioninterval, p.description FROM passanger_cars p 
                        JOIN models m ON m.id=p.modelid
                        JOIN manufacturers mm ON mm.id=m.manufacturerid
                        WHERE p.id=" . $row['linkageId']);
                    break;
                case 'CommercialVehicle':
                    $this->linkageTypeId[] = $row['linkageTypeId'];
                    $result[$row['linkageId']][] = DB::connection($this->connection)->select("SELECT DISTINCT p.id, mm.description make, m.description model, p.constructioninterval, p.description FROM commercial_vehicles p 
                        JOIN models m ON m.id=p.modelid
                        JOIN manufacturers mm ON mm.id=m.manufacturerid
                        WHERE p.id=" . $row['linkageId']);
                    break;
                case 'Motorbike':
                    $result[$row['linkageId']][] = DB::connection($this->connection)->select("SELECT DISTINCT p.id, mm.description make, m.description model, p.constructioninterval, p.description FROM motorbikes p 
                        JOIN models m ON m.id=p.modelid
                        JOIN manufacturers mm ON mm.id=m.manufacturerid
                        WHERE p.id=" . $row['linkageId']);
                    break;
                case 'Engine':
                    $result[$row['linkageId']][] = DB::connection($this->connection)->select("SELECT DISTINCT p.id, m.description make, '' model, p.constructioninterval, p.description FROM `engines` p 
                        JOIN manufacturers m ON m.id=p.manufacturerid
                        WHERE p.id=" . $row['linkageId']);
                    break;
                case 'Axle':
                    $result[$row['linkageId']][] = DB::connection($this->connection)->select("SELECT DISTINCT p.id, mm.description make, m.description model, p.constructioninterval, p.description FROM axles p 
                        JOIN models m ON m.id=p.modelid
                        JOIN manufacturers mm ON mm.id=m.manufacturerid
                        WHERE p.id=" . $row['linkageId']);
                    break;
            }
            if($key >= 10) {
                break;
            }
        }
//        dd($this);
//        dd($result);

        return $result;
    }

    /**
     * (3.7) Аналоги-заменители
     * @param $number
     * @param $brand_id
     * @return mixed
     */
    public function getArtCross($number, $brand_id)
    {
        return DB::connection($this->connection)->select("
            SELECT DISTINCT s.description, c.PartsDataSupplierArticleNumber FROM article_oe a
            JOIN manufacturers m ON m.id=a.manufacturerId 
            JOIN article_cross c ON c.OENbr=a.OENbr
            JOIN suppliers s ON s.id=c.SupplierId
            WHERE a.datasupplierarticlenumber='" . $number . "' AND a.supplierid='" . $brand_id . "'
        ");
    }

    /**
     * (3.3) Характеристики изделия
     *
     * @param $number
     * @param $brand_id
     * @return mixed
     */
    public function getArtAttributes($number, $brand_id)
    {
        return DB::connection($this->connection)->select("
            SELECT displaytitle, displayvalue, description FROM article_attributes WHERE datasupplierarticlenumber='" . $number . "'  AND supplierId='" . $brand_id . "'
        ");
    }
}
