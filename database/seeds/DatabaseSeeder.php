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
use App\Models\CargoStatus;
use App\Models\CargoType;
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

		$this->call('CargoTypeSeeder');
		$this->call('CargoStatusSeeder');
		$this->call('LdRateTypeSeeder');
		$this->call('QuantityMeasurementSeeder');
		$this->call('ShipSpecializationSeeder');
		$this->call('StowageFactorUnitSeeder');
		$this->call('ShipTypeSeeder');
		$this->call('FuelTypeSeeder');

	}

}
	/**
	* 
	*/
	class UserSeeder extends Seeder
	{
		
		public function run(){

			DB::table('users')->delete();
			User::create([
				'name' => 'admin',
		        'email' => 'admin@24vision.com',
		        'password' => bcrypt('PSbi4macom'),
		        'remember_token' => str_random(10),
			]);
		}

	}	


	/**
	* 
	*/
	class CargoTypeSeeder extends Seeder
	{
		
		public function run(){

			DB::table('cargo_types')->delete();
			CargoType::create([
				'id'=>1,
				'name'=>'test'
			]);
		}

	}

		/**
	* 
	*/
	class CargoStatusSeeder extends Seeder
	{
		
		public function run(){

			DB::table('cargo_status')->delete();
			CargoStatus::create([
				'id'=>1,
				'name'=>'OK'
			]);
			CargoStatus::create([
				'id'=>2,
				'name'=>'Incomplete'
			]);
			CargoStatus::create([
				'id'=>3,
				'name'=>'Unusable'
			]);
			CargoStatus::create([
				'id'=>4,
				'name'=>'Review'
			]);
			
		}

	}
	

	/**
	* 
	*/
	class FuelTypeSeeder extends Seeder
	{
		
		public function run(){

			DB::table('fuel_types')->delete();
			
			FuelType::create([
				'id'=>1,
				'name'=>'FO'
			]);
			FuelType::create([
				'id'=>2,
				'name'=>'MD/GO'
			]);
			FuelType::create([
				'id'=>3,
				'name'=>'LSMGO'
			]);
			
		}

	}


	/**
	* 
	*/
	class LdRateTypeSeeder extends Seeder
	{
		
		public function run(){
			DB::table('loading_discharging_rate_type')->delete();
			LdRateType::create([
				'id'=>1,
				'name'=>'SHEX EIU'
			]);
			LdRateType::create([
				'id'=>2,
				'name'=>'SHEX UU'
			]);
			LdRateType::create([
				'id'=>3,
				'name'=>'SSHEX EIU'
			]);
			LdRateType::create([
				'id'=>4,
				'name'=>'SSHEX UU'
			]);
			LdRateType::create([
				'id'=>5,
				'name'=>'FHEX EIU'
			]);
			LdRateType::create([
				'id'=>6,
				'name'=>'FHEX UU'
			]);
			LdRateType::create([
				'id'=>7,
				'name'=>'FSHEX EIU'
			]);
			LdRateType::create([
				'id'=>8,
				'name'=>'FSHEX UU'
			]);
			LdRateType::create([
				'id'=>9,
				'name'=>'TFHEX EIU'
			]);
			LdRateType::create([
				'id'=>10,
				'name'=>'TFHEX UU'
			]);
			LdRateType::create([
				'id'=>11,
				'name'=>'SHINC'
			]);
			LdRateType::create([
				'id'=>12,
				'name'=>'SSHINC'
			]);
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

			ShipSpecialization::create([
				'id'=>1,
				'name'=>'Dry Bulk Carrier'
			]);
			ShipSpecialization::create([
				'id'=>2,
				'name'=>'Product Tanker'
			]);
			ShipSpecialization::create([
				'id'=>3,
				'name'=>'Containership'
			]);
			ShipSpecialization::create([
				'id'=>4,
				'name'=>'Oil Tanker'
			]);
			ShipSpecialization::create([
				'id'=>5,
				'name'=>'Multi Purpose Vessel'
			]);
			ShipSpecialization::create([
				'id'=>6,
				'name'=>'Refigerated-Cargo-Ship'
			]);
			ShipSpecialization::create([
				'id'=>7,
				'name'=>'Chemical Carrier'
			]);
			ShipSpecialization::create([
				'id'=>8,
				'name'=>'Vehicle carrier'
			]);
			ShipSpecialization::create([
				'id'=>9,
				'name'=>'Livestock Carrier'
			]);
			ShipSpecialization::create([
				'id'=>10,
				'name'=>'Hvy lift Vessel'
			]);
			ShipSpecialization::create([
				'id'=>11,
				'name'=>'Ro-ro Vessel'
			]);
		}

	}

	/**
	* 
	*/
	class ShipTypeSeeder extends Seeder
	{
		public function run(){
			DB::table('ship_types')->delete();
			
			ShipType::create([
				'id'=>1,
				'name'=>'Coaster'
			]);
			ShipType::create([
				'id'=>2,
				'name'=>'Handysize'
			]);
			ShipType::create([
				'id'=>3,
				'name'=>'Handymax'
			]);
			ShipType::create([
				'id'=>4,
				'name'=>'Panamax'
			]);
			ShipType::create([
				'id'=>5,
				'name'=>'Capesize'
			]);

		}
	}

	/**
	* 
	*/
	class StowageFactorUnitSeeder extends Seeder
	{
		
		public function run(){
			DB::table('stowage_factor_units')->delete();
			StowageFactorUnit::create([
				'id'=>1,
				'unit'=>'FT/MT'
			]);
			StowageFactorUnit::create([
				'id'=>2,
				'unit'=>'M2/MT'
			]);
			StowageFactorUnit::create([
				'id'=>3,
				'unit'=>'DWCC'
			]);
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

	