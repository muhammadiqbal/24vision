<?php

use App\Models\Port;
use App\Models\FreightIdeaMeasurement;
use App\Models\LdRateType;
use App\Models\QuantityMeasurement;
use App\Models\ShipSpecialization;
use App\Models\StowageFactorUnit;
use App\Models\ShipType;
use App\Models\Ship;
use App\Models\Region;
use App\Models\ShipPosition;
use App\Models\Cargo;
use App\Models\FuelType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard();

		// $this->call('PortDataSeeder');
		$this->call('FreightIdeaMeasurementSeeder');
		$this->call('LdRateTypeSeeder');
		$this->call('QuantityMeasurementSeeder');
		$this->call('ShipSpecializationSeeder');
		$this->call('StowageFactorUnitSeeder');
		$this->call('ShipTypeSeeder');
		$this->call('FuelTypeSeeder');
		// $this->call('CargoDataSeeder');
		// $this->call('ShipSeeder');
		//$this->call('RegionSeeder');
		//$this->call('ShipPositionSeeder');

	}

}

class PortDataSeeder extends Seeder {

	public function run() {
		DB::table('ports')->delete();

		Port::create(array('name' => 'Agliè', 'location' => '45.3681,7.7681'));
		Port::create(array('name' => 'Airasca', 'location' => '44.9181,7.4855'));
		Port::create(array('name' => '"Ala di Stura"', 'location' => '45.3154,7.3026'));
		Port::create(array('name' => '"Albiano dIvrea"', 'location' => '45.4339,7.9517'));
		Port::create(array('name' => '"Alice Superiore"', 'location' => '45.4599,7.7774'));
		Port::create(array('name' => 'Almese', 'location' => '45.1169,7.3954'));
		Port::create(array('name' => 'Alpette', 'location' => '45.4106,7.5808'));
		Port::create(array('name' => 'Alpignano', 'location' => '45.0943,7.5244'));
		Port::create(array('name' => 'Andezeno', 'location' => '45.0373,7.8731'));
		Port::create(array('name' => 'Trausella', 'location' => '45.4908,7.7632'));
		Port::create(array('name' => 'Traversella', 'location' => '45.5096,7.7506'));
		Port::create(array('name' => 'Traves', 'location' => '45.2683,7.4308'));
		Port::create(array('name' => 'Trofarello', 'location' => '44.9847,7.7464'));
		Port::create(array('name' => 'Usseaux', 'location' => '45.0486,7.0267'));
		Port::create(array('name' => 'Usseglio', 'location' => '45.2328,7.2172'));
		Port::create(array('name' => 'Vaie', 'location' => '45.1016,7.2898'));
		Port::create(array('name' => '"Val della Torre"', 'location' => '45.1563,7.4463'));
		Port::create(array('name' => 'Valgioie', 'location' => '45.0761,7.3407'));
		Port::create(array('name' => '"Vallo Torinese"', 'location' => '45.2245,7.4975'));
		Port::create(array('name' => 'Valperga', 'location' => '45.3701,7.6579'));
		Port::create(array('name' => '"Valprato Soana"', 'location' => '45.5222,7.5502'));
		Port::create(array('name' => 'Varisella', 'location' => '45.2096,7.4861'));
		Port::create(array('name' => '"Vauda Canavese"', 'location' => '45.2792,7.6164'));
		Port::create(array('name' => 'Venaus', 'location' => '45.1596,7.0092'));
		Port::create(array('name' => '"Venaria Reale"', 'location' => '45.1342,7.629'));
		Port::create(array('name' => 'Verolengo', 'location' => '45.1911,7.9694'));
		Port::create(array('name' => '"Verrua Savoia"', 'location' => '45.1578,8.0935'));
		Port::create(array('name' => 'Vestignè', 'location' => '45.3867,7.9559'));
		Port::create(array('name' => 'Vialfrè', 'location' => '45.3812,7.8177'));
		Port::create(array('name' => '"Vico Canavese"', 'location' => '45.397,7.4668'));
		Port::create(array('name' => 'Vidracco', 'location' => '45.4317,7.7586'));
		Port::create(array('name' => 'Vigone', 'location' => '44.8455,7.4961'));
		Port::create(array('name' => '"Villafranca Piemonte"', 'location' => '44.78,7.5016'));
		Port::create(array('name' => '"Villanova Canavese"', 'location' => '45.2445,7.5533'));
		Port::create(array('name' => 'Villarbasse', 'location' => '45.0463,7.4695'));
		Port::create(array('name' => '"Villar Dora"', 'location' => '45.1156,7.3847'));
		Port::create(array('name' => 'Villareggia', 'location' => '45.3111,7.9778'));
		Port::create(array('name' => '"Villar Focchiardo"', 'location' => '45.1103,7.2328'));
		Port::create(array('name' => '"Villar Pellice"', 'location' => '44.8094,7.1533'));
		Port::create(array('name' => '"Villar Perosa"', 'location' => '44.9193,7.2481'));
		Port::create(array('name' => 'Villastellone', 'location' => '44.9218,7.7446'));
		Port::create(array('name' => 'Vinovo', 'location' => '44.9482,7.6338'));
		Port::create(array('name' => '"Virle Piemonte"', 'location' => '44.8656,7.5713'));
		Port::create(array('name' => 'Vische', 'location' => '45.3352,7.9459'));
		Port::create(array('name' => 'Vistrorio', 'location' => '45.443,7.7685'));
		Port::create(array('name' => 'Viù', 'location' => '45.2389,7.3766'));
		Port::create(array('name' => 'Volpiano', 'location' => '45.2015,7.7773'));
		Port::create(array('name' => 'Volvera', 'location' => '44.956,7.5125'));
		Port::create(array('name' => '"Alagna Valsesia"', 'location' => '45.8542,7.9374'));
		Port::create(array('name' => '"Albano Vercellese"', 'location' => '45.4272,8.3807'));
		Port::create(array('name' => '"Alice Castello"', 'location' => '45.3663,8.0741'));
		Port::create(array('name' => 'Arborio', 'location' => '45.4959,8.3864'));
		Port::create(array('name' => '"Asigliano Vercellese"', 'location' => '45.2625,8.4097'));
		Port::create(array('name' => 'Balmuccia', 'location' => '45.8189,8.1427'));
		Port::create(array('name' => 'Balocco', 'location' => '45.4562,8.2813'));
		Port::create(array('name' => 'Bianzè', 'location' => '45.3096,8.1238'));
		Port::create(array('name' => 'Boccioleto', 'location' => '45.8302,8.113'));
		Port::create(array('name' => '"Borgo dAle"', 'location' => '45.3527,8.0519'));
		Port::create(array('name' => 'Borgosesia', 'location' => '45.7153,8.2772'));
		Port::create(array('name' => '"Borgo Vercelli"', 'location' => '45.3589,8.4642'));
		Port::create(array('name' => 'Breia', 'location' => '45.7667,8.3108'));
		Port::create(array('name' => 'Buronzo', 'location' => '45.4819,8.2683'));
		Port::create(array('name' => 'Campertogno', 'location' => '45.7999,8.0333'));
		Port::create(array('name' => 'Carcoforo', 'location' => '45.9096,8.0457'));
		Port::create(array('name' => 'Caresana', 'location' => '45.2219,8.5064'));
		Port::create(array('name' => 'Caresanablot', 'location' => '45.3585,8.3931'));
		Port::create(array('name' => 'Carisio', 'location' => '45.4103,8.2002'));
		Port::create(array('name' => '"Casanova Elvo"', 'location' => '45.402,8.2947'));
		Port::create(array('name' => '"San Giacomo Vercellese"', 'location' => '45.4992,8.3278'));
		Port::create(array('name' => 'Cellio', 'location' => '45.7571,8.3117'));
		Port::create(array('name' => 'Cervatto', 'location' => '45.8829,8.1633'));
		Port::create(array('name' => 'Cigliano', 'location' => '45.3094,8.0222'));
		Port::create(array('name' => 'Civiasco', 'location' => '45.8069,8.2932'));
		Port::create(array('name' => 'Collobiano', 'location' => '45.397,8.3493'));
		Port::create(array('name' => 'Costanzana', 'location' => '45.2372,8.3711'));
		Port::create(array('name' => 'Cravagliana', 'location' => '45.8485,8.203'));
		Port::create(array('name' => 'Crescentino', 'location' => '45.1914,8.1011'));
		Port::create(array('name' => 'Crova', 'location' => '45.3317,8.2121'));
		Port::create(array('name' => 'Desana', 'location' => '45.2706,8.361'));
		Port::create(array('name' => 'Fobello', 'location' => '45.8902,8.1578'));
		Port::create(array('name' => '"Fontanetto Po"', 'location' => '45.1942,8.1927'));
		Port::create(array('name' => 'Formigliana', 'location' => '45.4294,8.2928'));
		Port::create(array('name' => 'Gattinara', 'location' => '45.6189,8.3686'));
		Port::create(array('name' => 'Ghislarengo', 'location' => '45.53,8.3863'));
		Port::create(array('name' => 'Greggio', 'location' => '45.4517,8.3842'));
		Port::create(array('name' => 'Guardabosone', 'location' => '45.702,8.2493'));
		Port::create(array('name' => 'Lamporo', 'location' => '45.2306,8.0974'));
		Port::create(array('name' => 'Lenta', 'location' => '45.556,8.3836'));
		Port::create(array('name' => 'Lignana', 'location' => '45.287,8.345'));
		Port::create(array('name' => '"Livorno Ferraris"', 'location' => '45.285,8.0786'));
		Port::create(array('name' => 'Lozzolo', 'location' => '45.6265,8.324'));
		Port::create(array('name' => 'Mollia', 'location' => '45.8151,8.0308'));
		Port::create(array('name' => 'Moncrivello', 'location' => '45.3335,7.9967'));
		Port::create(array('name' => '"Motta de Conti"', 'location' => '45.1945,8.522'));
		Port::create(array('name' => 'Olcenengo', 'location' => '45.3646,8.3109'));
		Port::create(array('name' => 'Oldenico', 'location' => '45.4038,8.3822'));
		Port::create(array('name' => '"Palazzolo Vercellese"', 'location' => '45.1856,8.2308'));
		Port::create(array('name' => 'Pertengo', 'location' => '45.236,8.4176'));
		Port::create(array('name' => 'Pezzana', 'location' => '45.2631,8.4863'));
		Port::create(array('name' => 'Pila', 'location' => '45.7705,8.0833'));
		Port::create(array('name' => 'Piode', 'location' => '45.772,8.0517'));
		Port::create(array('name' => 'Postua', 'location' => '45.7139,8.2317'));
		Port::create(array('name' => 'Prarolo', 'location' => '45.281,8.4777'));
		Port::create(array('name' => 'Quarona', 'location' => '45.7589,8.2669'));
		Port::create(array('name' => '"Quinto Vercellese"', 'location' => '45.3806,8.3628'));
		Port::create(array('name' => 'Rassa', 'location' => '45.7684,8.012'));
		Port::create(array('name' => '"Rima San Giuseppe"', 'location' => '45.8847,7.9989'));
		Port::create(array('name' => 'Rimasco', 'location' => '45.86,8.0639'));
		Port::create(array('name' => 'Rimella', 'location' => '45.9091,8.1835'));
		Port::create(array('name' => '"Riva Valdobbia"', 'location' => '45.832,7.9578'));
		Port::create(array('name' => 'Rive', 'location' => '45.2152,8.4188'));
		Port::create(array('name' => 'Roasio', 'location' => '45.6058,8.2871'));
		Port::create(array('name' => 'Ronsecco', 'location' => '45.2531,8.2781'));
		Port::create(array('name' => 'Rossa', 'location' => '45.833,8.1206'));
		Port::create(array('name' => 'Rovasenda', 'location' => '45.5399,8.3188'));
		Port::create(array('name' => 'Sabbia', 'location' => '45.857,8.2361'));
		Port::create(array('name' => 'Ponti', 'location' => '44.6294,8.3653'));
		Port::create(array('name' => '"Ponzano Monferrato"', 'location' => '45.0855,8.2632'));
		Port::create(array('name' => 'Ponzone', 'location' => '45.6557,8.1896'));
		Port::create(array('name' => '"Pozzol Groppo"', 'location' => '44.8776,9.0292'));
		Port::create(array('name' => '"Pozzolo Formigaro"', 'location' => '44.7963,8.7859'));
		Port::create(array('name' => 'Prasco', 'location' => '44.6397,8.5524'));
		Port::create(array('name' => 'Predosa', 'location' => '44.7524,8.6566'));
		Port::create(array('name' => 'Quargnento', 'location' => '44.9459,8.4881'));
		Port::create(array('name' => 'Quattordio', 'location' => '44.8974,8.4061'));
		Port::create(array('name' => 'Ricaldone', 'location' => '44.7335,8.4692'));
	}

}


	/**
	* 
	*/
	class FreightIdeaMeasurementSeeder extends Seeder
	{
		
		public function run(){

			DB::table('freight_idea_measurements')->delete();
			
			FreightIdeaMeasurement::create(['id'=>1,'name'=>'Per MTS']);
			FreightIdeaMeasurement::create(['id'=>2,'name'=>'Lumpsum']);
			FreightIdeaMeasurement::create(['id'=>3,'name'=>'Time Charter']);
			FreightIdeaMeasurement::create(['id'=>4,'name'=>'Best offer']);
		}

	}

		/**
	* 
	*/
	class FuelTypeSeeder extends Seeder
	{
		
		public function run(){

			DB::table('fuel_types')->delete();
			
			FuelType::create(['id'=>1,'name'=>'FO']);
			FuelType::create(['id'=>2,'name'=>'MD/GO']);
			FuelType::create(['id'=>3,'name'=>'LSMGO']);
			
		}

	}


	/**
	* 
	*/
	class LdRateTypeSeeder extends Seeder
	{
		
		public function run(){
			DB::table('loading_dischaging_rate_type')->delete();
			LdRateType::create(['id'=>1,'name'=>'SHEX EIU']);
			LdRateType::create(['id'=>2,'name'=>'SHEX UU']);
			LdRateType::create(['id'=>3,'name'=>'SSHEX EIU']);
			LdRateType::create(['id'=>4,'name'=>'SSHEX UU']);
			LdRateType::create(['id'=>5,'name'=>'FHEX EIU']);
			LdRateType::create(['id'=>6,'name'=>'FHEX UU']);
			LdRateType::create(['id'=>7,'name'=>'FSHEX EIU']);
			LdRateType::create(['id'=>8,'name'=>'FSHEX UU']);
			LdRateType::create(['id'=>9,'name'=>'TFHEX EIU']);
			LdRateType::create(['id'=>10,'name'=>'TFHEX UU']);
			LdRateType::create(['id'=>11,'name'=>'SHINC']);
			LdRateType::create(['id'=>12,'name'=>'SSHINC']);
		}

	}

		/**
	* 
	*/
	class QuantityMeasurementSeeder extends Seeder
	{
		
		public function run(){
			DB::table('quantity_measurements')->delete();
			QuantityMeasurement::create(['id'=>1,'name'=>'Exact']);
			QuantityMeasurement::create(['id'=>2,'name'=>'About +-/%']);
			QuantityMeasurement::create(['id'=>3,'name'=>'From to']);
		}

	}

/**
	* 
	*/
	class ShipSpecializationSeeder extends Seeder
	{
		
		public function run(){
			DB::table('ship_specializations')->delete();
			ShipSpecialization::create(['id'=>1,'name'=>'Dry Bulk Carrier']);
			ShipSpecialization::create(['id'=>2,'name'=>'Product Tanker']);
			ShipSpecialization::create(['id'=>3,'name'=>'Containership']);
			ShipSpecialization::create(['id'=>4,'name'=>'Oil Tanker']);
			ShipSpecialization::create(['id'=>5,'name'=>'Multi Purpose Vessel']);
			ShipSpecialization::create(['id'=>6,'name'=>'Refigerated-Cargo-Ship']);
			ShipSpecialization::create(['id'=>7,'name'=>'Chemical Carrier']);
			ShipSpecialization::create(['id'=>8,'name'=>'Vehicle carrier']);
			ShipSpecialization::create(['id'=>9,'name'=>'Livestock Carrier']);
			ShipSpecialization::create(['id'=>10,'name'=>'Hvy lift Vessel']);
			ShipSpecialization::create(['id'=>11,'name'=>'Ro-ro Vessel']);
		}

	}

	/**
	* 
	*/
	class ShipTypeSeeder extends Seeder
	{
		public function run(){
			DB::table('ship_types')->delete();
			ShipType::create(['id'=>1,'name'=>'Coaster']);
			ShipType::create(['id'=>2,'name'=>'Handysize']);
			ShipType::create(['id'=>3,'name'=>'Handymax']);
			ShipType::create(['id'=>4,'name'=>'Panamax']);
			ShipType::create(['id'=>5,'name'=>'Capesize']);

		}
	}

	/**
	* 
	*/
	class StowageFactorUnitSeeder extends Seeder
	{
		
		public function run(){
			DB::table('stowage_factor_units')->delete();
			StowageFactorUnit::create(['id'=>1,'unit'=>'FT/MT']);
			StowageFactorUnit::create(['id'=>2,'unit'=>'M2/MT']);
			StowageFactorUnit::create(['id'=>3,'unit'=>'DWCC']);
		}

	}

		/**
	* 
	*/
	class CargoDataSeeder extends Seeder
	{
		
		public function run(){
			//DB::table('cargos')->delete();
    
        	Cargo::create([
        		'loading_port'=>1,
        		'discharging_port'=>5,
        		'laycan_first_day'=>'25-10-2017',
        		'laycan_last_day'=>'30-11-2017',
        		'cargo_description'=>'textile',
        		'stowage_factor'=>5,'sf_unit'=>1,
        		'ship_specialization_id'=>1,
        		'quantity_measurement_id'=>1,
        		'quantity'=>45,
        		'loading_rate_type'=>1,
        		'loading_rate'=>23,
        		'discharging_rate_type'=>1,
        		'discharging_rate'=>23,
        		'freight_idea_measurement_id'=>1,
        		'freight_idea'=>23,
        		'extra_condition'=>null
        	]);

        	Cargo::create([
        		'loading_port'=>2,
        		'discharging_port'=>10,
        		'laycan_first_day'=>'25-10-2017',
        		'laycan_last_day'=>'30-11-2017',
        		'cargo_description'=>'textile',
        		'stowage_factor'=>5,'sf_unit'=>1,
        		'ship_specialization_id'=>2,
        		'quantity_measurement_id'=>1,
        		'quantity'=>45,
        		'loading_rate_type'=>1,
        		'loading_rate'=>23,
        		'discharging_rate_type'=>1,
        		'discharging_rate'=>23,
        		'freight_idea_measurement_id'=>1,
        		'freight_idea'=>23,
        		'extra_condition'=>null
        	]);

        	Cargo::create([
        		'loading_port'=>4,
        		'discharging_port'=>3,
        		'laycan_first_day'=>'25-10-2017',
        		'laycan_last_day'=>'30-11-2017',
        		'cargo_description'=>'textile',
        		'stowage_factor'=>5,'sf_unit'=>1,
        		'ship_specialization_id'=>1,
        		'quantity_measurement_id'=>1,
        		'quantity'=>45,
        		'loading_rate_type'=>1,
        		'loading_rate'=>23,
        		'discharging_rate_type'=>1,
        		'discharging_rate'=>23,
        		'freight_idea_measurement_id'=>1,
        		'freight_idea'=>23,
        		'extra_condition'=>null
        	]);

        	Cargo::create([
        		'loading_port'=>1,
        		'discharging_port'=>3,
        		'laycan_first_day'=>'25-10-2017',
        		'laycan_last_day'=>'30-11-2017',
        		'cargo_description'=>'textile',
        		'stowage_factor'=>5,'sf_unit'=>1,
        		'ship_specialization_id'=>'1',
        		'quantity_measurement_id'=>1,
        		'quantity'=>45,
        		'loading_rate_type'=>1,
        		'loading_rate'=>23,
        		'discharging_rate_type'=>1,
        		'discharging_rate'=>23,
        		'freight_idea_measurement_id'=>1,
        		'freight_idea'=>23,
        		'extra_condition'=>null
        	]);
		}
	}





	/**
	* 
	*/
	class RegionSeeder extends Seeder
	{
		public function run(){
			DB::table('regions')->delete();
			Region::create(['name'=>'Europe']);
		}
	}

/**
	* 
	*/
	class ShipPositionSeeder extends Seeder
	{
		public function run(){
			DB::table('ship_positions')->delete();

			ShipPosition::create([ 
				'ship_id'=>1,
		        'region_id'=>1,
		        'port_id'=>1,
		        'date_of_opening'=>'05-10-2017'
		    ]);

		    ShipPosition::create([ 
				'ship_id'=>2,
		        'region_id'=>1,
		        'port_id'=>1,
		        'date_of_opening'=>'05-10-2017'
		    ]);

		    ShipPosition::create([ 
				'ship_id'=>3,
		        'region_id'=>1,
		        'port_id'=>1,
		        'date_of_opening'=>'05-10-2017'
		    ]);

		    ShipPosition::create([ 
				'ship_id'=>2,
		        'region_id'=>1,
		        'port_id'=>3,
		        'date_of_opening'=>'05-10-2017'
		    ]);

		    ShipPosition::create([ 
				'ship_id'=>2,
		        'region_id'=>1,
		        'port_id'=>5,
		        'date_of_opening'=>'05-10-2017'
		    ]);

		    ShipPosition::create([ 
				'ship_id'=>2,
		        'region_id'=>1,
		        'port_id'=>3,
		        'date_of_opening'=>'05-10-2017'
		    ]);

		    ShipPosition::create([ 
				'ship_id'=>2,
		        'region_id'=>1,
		        'port_id'=>5,
		        'date_of_opening'=>'05-10-2017'
		    ]);
		}
	}	


	/**
	 * 
	 */
	class ShipSeeder extends Seeder
	{
		public function run(){ 
		DB::table('ships')->delete();

		Ship::create([
			'name'=>'sunny',
	        'imo'=>'asd1223',
	        'year_of_built'=>'2017-10-05',
	        'dwcc'=>23,
	        'max_holds_capacity'=>23,
	        'max_laden_draft'=>12,
	        'flag'=>'Germany',
	        'ship_type_id'=>1,
	        'ship_specialization_id'=>3,
        ]);

		Ship::create([
			'name'=>'goinmarry',
	        'imo'=>'as223',
	        'year_of_built'=>'2017-10-05',
	        'dwcc'=>23,
	        'max_holds_capacity'=>23,
	        'max_laden_draft'=>12,
	        'flag'=>'Germany',
	        'ship_type_id'=>3,
	        'ship_specialization_id'=>2,
        ]);

        Ship::create([
			'name'=>'mobydik',
	        'imo'=>'asd1',
	        'year_of_built'=>'2017-10-05',
	        'dwcc'=>23,
	        'max_holds_capacity'=>23,
	        'max_laden_draft'=>12,
	        'flag'=>'Germany',
	        'ship_type_id'=>2,
	        'ship_specialization_id'=>1,
        ]);
		}
	
	}	

	