<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement('INSERT INTO admins (id, nom, prenom, email, password, created_at, updated_at) SELECT id, nom, prenom, email, password, created_at, updated_at FROM vendeurs WHERE is_admin = 1');

        $seq = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'admins'", [DB::getDatabaseName()]);
        $maxId = DB::table('vendeurs')->max('id') ?? 0;
        if (isset($seq[0]->AUTO_INCREMENT) && $seq[0]->AUTO_INCREMENT <= $maxId) {
            DB::statement("ALTER TABLE admins AUTO_INCREMENT = " . ($maxId + 1));
        }

        Schema::table('vendeurs', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });

        DB::statement('UPDATE vendeurs v JOIN admins a ON v.id = a.id SET v.is_admin = 1');

        Schema::dropIfExists('admins');
    }
};
