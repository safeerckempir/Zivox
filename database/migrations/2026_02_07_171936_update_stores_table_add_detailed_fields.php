<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postcode');
            $table->string('country');
            $table->string('currency');
            $table->string('contact_number');
            $table->string('contact_email');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->text('address');
            $table->dropColumn(['address_line1', 'address_line2', 'city', 'state', 'postcode', 'country', 'currency', 'contact_number', 'contact_email']);
        });
    }
};
