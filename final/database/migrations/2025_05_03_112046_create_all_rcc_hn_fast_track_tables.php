<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllRccHnFastTrackTables extends Migration
{
    public function up()
    {
        // RCC Vehicle Types
        Schema::create('rcc_vehicle_types', function (Blueprint $table) {
            $table->increments('rcc_veh_type_id');
            $table->string('rcc_veh_type_name', 100);
            $table->timestamp('rcc_created_at')->useCurrent();
            $table->timestamp('rcc_updated_at')->useCurrent();
        });

        // RCC Roles
        Schema::create('rcc_roles', function (Blueprint $table) {
            $table->increments('rcc_role_id');
            $table->string('rcc_role_name', 100);
            $table->timestamp('rcc_created_at')->useCurrent();
            $table->timestamp('rcc_updated_at')->useCurrent();
        });

        // RCC Service Area
        Schema::create('rcc_service_area', function (Blueprint $table) {
            $table->increments('rcc_area_id');
            $table->string('rcc_area_name', 100);
            $table->timestamp('rcc_created_at')->useCurrent();
            $table->timestamp('rcc_updated_at')->useCurrent();
        });

        // RCC Service Units
        Schema::create('rcc_service_units', function (Blueprint $table) {
            $table->increments('rcc_serv_id');
            $table->string('rcc_serv_name', 100);
            $table->text('rcc_location');
            $table->date('rcc_established_date');
            $table->string('rcc_contact_name', 100);
            $table->string('rcc_contact_tel', 10);
            $table->string('rcc_serv_img_path', 100);
            $table->timestamp('rcc_created_at')->useCurrent();
            $table->timestamp('rcc_updated_at')->useCurrent();
        });

        // RCC Service Unit Areas (pivot)
        Schema::create('rcc_service_unit_areas', function (Blueprint $table) {
            $table->increments('rcc_sua_id');
            $table->unsignedInteger('rcc_serv_id');
            $table->unsignedInteger('rcc_area_id');

            $table->foreign('rcc_serv_id')->references('rcc_serv_id')->on('rcc_service_units');
            $table->foreign('rcc_area_id')->references('rcc_area_id')->on('rcc_service_area');
        });

        // RCC Users
        Schema::create('rcc_users', function (Blueprint $table) {
            $table->increments('rcc_user_id');
            $table->unsignedInteger('rcc_role_id');
            $table->string('rcc_username', 100);
            $table->string('rcc_password', 150);
            $table->string('rcc_email', 100);
            $table->timestamp('rcc_created_at')->useCurrent();
            $table->timestamp('rcc_updated_at')->useCurrent();

            $table->foreign('rcc_role_id')->references('rcc_role_id')->on('rcc_roles');
        });

        // RCC Emergency Vehicles
        Schema::create('rcc_emergency_vehicles', function (Blueprint $table) {
            $table->increments('rcc_emer_veh_id');
            $table->unsignedInteger('rcc_veh_type_id');
            $table->string('rcc_plate_prefix', 3);
            $table->string('rcc_plate_number', 5);
            $table->string('rcc_province', 50);
            $table->string('rcc_standard_number', 50);
            $table->date('rcc_license_expiry_date');
            $table->date('rcc_start_year');
            $table->string('rcc_pdfFilePath', 100);
            $table->timestamp('rcc_created_at')->useCurrent();
            $table->timestamp('rcc_updated_at')->useCurrent();

            $table->foreign('rcc_veh_type_id')->references('rcc_veh_type_id')->on('rcc_vehicle_types');
        });

        // RCC Vehicle Images
        Schema::create('rcc_vehicle_images', function (Blueprint $table) {
            $table->increments('rcc_veh_img_id');
            $table->unsignedInteger('rcc_emer_veh_img_id');
            $table->string('rcc_img_path', 100);
            $table->timestamp('rcc_uploaded_at')->useCurrent();

            $table->foreign('rcc_emer_veh_img_id')->references('rcc_emer_veh_id')->on('rcc_emergency_vehicles');
        });

        // HN Personal Info
        Schema::create('hn_personal_info', function (Blueprint $table) {
            $table->increments('hn_infoId');
            $table->string('hn_firstName', 50);
            $table->string('hn_lastName', 50);
            $table->string('hn_gender', 50)->default('Male');
            $table->enum('hn_bloodGroup', ['A', 'B', 'AB', 'O'])->default('A');
            $table->text('hn_address');
            $table->timestamp('hn_created_at')->useCurrent();
            $table->timestamp('hn_updated_at')->useCurrent();
        });

        // HN Incidents
        Schema::create('hn_incidents', function (Blueprint $table) {
            $table->increments('hn_incident_id');
            $table->string('hn_caseNo', 20)->unique();
            $table->text('hn_note');
            $table->text('hn_location_link');
            $table->enum('hn_Ispatient_conscious', ['1', '2', '3']);
            $table->tinyInteger('hn_Ispatient_breathing');
            $table->integer('hn_num_victims', false, true)->default(1);
            $table->text('hn_symptoms');
            $table->enum('hn_status', ['1', '2', '3']);
            $table->enum('hn_source', ['1', '2']);
            $table->timestamp('hn_created_at')->useCurrent();
            $table->timestamp('hn_updated_at')->useCurrent();
        });

        // HN Images
        Schema::create('hn_images', function (Blueprint $table) {
            $table->increments('hn_img_id');
            $table->string('hn_img_path', 100);
            $table->timestamp('hn_created_at')->useCurrent();
            $table->timestamp('hn_updated_at')->useCurrent();
        });

        // HN Incident Images
        Schema::create('hn_incident_images', function (Blueprint $table) {
            $table->increments('hn_incident_img_id');
            $table->unsignedInteger('hn_incident_id');
            $table->unsignedInteger('hn_img_id');
            $table->timestamp('hn_created_at')->useCurrent();
            $table->timestamp('hn_updated_at')->useCurrent();

            $table->foreign('hn_incident_id')->references('hn_incident_id')->on('hn_incidents');
            $table->foreign('hn_img_id')->references('hn_img_id')->on('hn_images');
        });

        // HN Reporters
        Schema::create('hn_reporters', function (Blueprint $table) {
            $table->increments('hn_reporter_id');
            $table->string('hn_firstName', 50);
            $table->string('hn_lastName', 50);
            $table->string('hn_telNo', 10);
            $table->timestamp('hn_created_at')->useCurrent();
        });

        // HN Users
        Schema::create('hn_users', function (Blueprint $table) {
            $table->increments('hn_user_id');
            $table->string('hn_telNo', 10);
            $table->string('hn_password', 150);
            $table->unsignedInteger('hn_infoId');

            $table->foreign('hn_infoId')->references('hn_infoId')->on('hn_personal_info');
        });

        // HN Incident Reporters
        Schema::create('hn_incident_reporters', function (Blueprint $table) {
            $table->increments('hn_inc_rep_id');
            $table->unsignedInteger('hn_incident_id');
            $table->unsignedInteger('hn_user_id');
            $table->unsignedInteger('hn_reporter_id');
            $table->dateTime('hn_reported_at')->useCurrent();

            $table->foreign('hn_incident_id')->references('hn_incident_id')->on('hn_incidents');
            $table->foreign('hn_user_id')->references('hn_user_id')->on('hn_users');
            $table->foreign('hn_reporter_id')->references('hn_reporter_id')->on('hn_reporters');
        });

        // Fast Track Hospitals
        Schema::create('fast_track_hospitals', function (Blueprint $table) {
            $table->increments('fst_hosp_id');
            $table->string('fst_hosp_name', 100);
            $table->timestamp('fst_created_at')->useCurrent();
            $table->timestamp('fst_updated_at')->useCurrent();
        });

        // Fast Track Users
        Schema::create('fast_track_users', function (Blueprint $table) {
            $table->increments('fst_user_id');
            $table->unsignedInteger('rcc_role_id');
            $table->unsignedInteger('rcc_serv_id');
            $table->string('fst_username', 100);
            $table->string('fst_password', 150);
            $table->string('profile_img_path', 255)->default('https://dummyimage.com/500x500/000/fff.png&text=Profile');
            $table->boolean('fst_status')->default(0);
            $table->string('fst_email', 100);
            $table->timestamp('fst_created_at')->useCurrent();
            $table->timestamp('fst_updated_at')->useCurrent();

            $table->foreign('rcc_role_id')->references('rcc_role_id')->on('rcc_roles');
            $table->foreign('rcc_serv_id')->references('rcc_serv_id')->on('rcc_service_units');
        });

        // Fast Track Service Unit Vehicles
        Schema::create('fast_track_service_unit_vehicles', function (Blueprint $table) {
            $table->increments('fst_serv_u_veh_id');
            $table->unsignedInteger('rcc_serv_id');
            $table->unsignedInteger('rcc_emer_veh_id');

            $table->foreign('rcc_serv_id')->references('rcc_serv_id')->on('rcc_service_units');
            $table->foreign('rcc_emer_veh_id')->references('rcc_emer_veh_id')->on('rcc_emergency_vehicles');
        });

        // Fast Track Mission Logs
        Schema::create('fast_track_mission_logs', function (Blueprint $table) {
            $table->increments('fst_mis_log_id');
            $table->unsignedInteger('rcc_emer_veh_id');
            $table->unsignedInteger('hn_incident_id');
            $table->unsignedInteger('fst_hosp_id');
            $table->dateTime('fst_command_time');
            $table->dateTime('fst_receive_time');
            $table->integer('fst_receive_mileage');
            $table->dateTime('fst_incident_time');
            $table->integer('fst_incident_mileage');
            $table->dateTime('fst_hospital_time');
            $table->integer('fst_hospital_mileage');
            $table->boolean('fst_status');
            $table->timestamp('fst_created_at')->useCurrent();

            $table->foreign('rcc_emer_veh_id')->references('rcc_emer_veh_id')->on('rcc_emergency_vehicles');
            $table->foreign('hn_incident_id')->references('hn_incident_id')->on('hn_incidents');
            $table->foreign('fst_hosp_id')->references('fst_hosp_id')->on('fast_track_hospitals');
        });

        // Fast Track Mission Cancellations
        Schema::create('fast_track_mission_cancellations', function (Blueprint $table) {
            $table->increments('fst_mis_cancel_id');
            $table->unsignedInteger('fst_mis_log_id');
            $table->text('fst_cancel_reason');
            $table->timestamp('fst_created_at')->useCurrent();

            $table->foreign('fst_mis_log_id')->references('fst_mis_log_id')->on('fast_track_mission_logs');
        });

        // Fast Track Cancel Images
        Schema::create('fast_track_cancel_images', function (Blueprint $table) {
            $table->increments('fst_cancel_img_id');
            $table->unsignedInteger('fst_mis_log_id');
            $table->string('fst_cancel_img_path', 100);
            // <<< แก้ตรงนี้
            $table->timestamp('fst_created_at')->useCurrent();

            $table->foreign('fst_mis_log_id')
                ->references('fst_mis_log_id')
                ->on('fast_track_mission_logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fast_track_cancel_images');
        Schema::dropIfExists('fast_track_mission_cancellations');
        Schema::dropIfExists('fast_track_mission_logs');
        Schema::dropIfExists('fast_track_service_unit_vehicles');
        Schema::dropIfExists('fast_track_users');
        Schema::dropIfExists('fast_track_hospitals');
        Schema::dropIfExists('hn_incident_reporters');
        Schema::dropIfExists('hn_users');
        Schema::dropIfExists('hn_reporters');
        Schema::dropIfExists('hn_incident_images');
        Schema::dropIfExists('hn_images');
        Schema::dropIfExists('hn_incidents');
        Schema::dropIfExists('hn_personal_info');
        Schema::dropIfExists('rcc_vehicle_images');
        Schema::dropIfExists('rcc_emergency_vehicles');
        Schema::dropIfExists('rcc_users');
        Schema::dropIfExists('rcc_service_unit_areas');
        Schema::dropIfExists('rcc_service_units');
        Schema::dropIfExists('rcc_service_area');
        Schema::dropIfExists('rcc_roles');
        Schema::dropIfExists('rcc_vehicle_types');
    }
}
