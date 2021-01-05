<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
                $table->id();
                $table->text('name');
                // $table->text('email');
                $table->text('phone');
                $table->text('address');
                $table->foreignId('user_id');
                $table->foreignId('country_id');
                $table->foreignId('state_id');
                $table->text('comment');
                $table->text('organization');
                $table->text('captcha');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_contacts');
    }
}
