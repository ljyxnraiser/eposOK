<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_info', function(Blueprint $table)
		{
			$table->integer('client_id')->primary()->comment('客户id');
			$table->string('client_name', 100)->nullable()->comment('客户名称');
			$table->string('client_passwd', 150)->nullable()->comment('客户密码
');
			$table->smallInteger('client_status')->nullable()->comment('客户状态');
			$table->float('client_sum', 150)->comment('客户余额');
			$table->timestamps();
           // $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
           // $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('client_info');
	}

}
