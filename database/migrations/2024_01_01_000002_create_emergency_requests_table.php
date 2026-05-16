<?php
// database/migrations/2024_01_01_000002_create_emergency_requests_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('emergency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('blood_type', 5);
            $table->unsignedTinyInteger('units')->default(1);
            $table->enum('urgency', ['critical', 'urgent', 'normal'])->default('critical');
            $table->string('hospital_name');
            $table->string('city');
            $table->string('ward')->nullable();
            $table->string('contact_name');
            $table->string('phone', 20);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'fulfilled', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergency_requests');
    }
};
