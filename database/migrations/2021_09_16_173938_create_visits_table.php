<?php

use App\Enums\VisitStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date');
            $table->time('start_at');
            $table->time('end_at');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')
                ->on('employees')
                ->references('id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')
                ->on('services')
                ->references('id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')
                ->on('clients')
                ->references('id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->decimal('price');
            $table->string('status')->default(VisitStatus::NEW);
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
        Schema::dropIfExists('visits');
    }
}
