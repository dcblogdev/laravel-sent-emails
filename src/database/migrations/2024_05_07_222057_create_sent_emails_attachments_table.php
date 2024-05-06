<?php

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sent_emails_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(SentEmail::class)->nullable();
            $table->string('filename')->nullable();
            $table->text('path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_emails_attachments');
    }
};