<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('mobile');
            $table->string('customer_name');
            $table->string('requester_name')->nullable();
            $table->enum('result_destination', Order::RESULT_DESTINATIONS)->default('EMAIL');
            $table->string('result_email')->nullable();
            $table->string('special_id')->default(Order::generateSpecialID());
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
