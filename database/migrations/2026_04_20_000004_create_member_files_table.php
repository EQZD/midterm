<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('original_name');   // оригинальное имя файла
            $table->string('stored_name');     // имя в storage
            $table->string('file_path');       // полный путь
            $table->string('mime_type');       // image/jpeg, application/pdf ...
            $table->unsignedBigInteger('file_size'); // в байтах
            $table->string('uploaded_by');     // email кто загрузил
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_files');
    }
};
